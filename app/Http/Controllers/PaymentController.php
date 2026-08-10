<?php

namespace App\Http\Controllers;

use App\Channels\SmsChannel;
use App\Helpers\Helper;
use App\Jobs\MailJob;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderTransaction;
use App\Models\QrDetails;
use App\Models\User;
use App\Models\UserAddress;
use App\Notifications\NewAdminOrder;
use App\Notifications\NewCustomerOrder;
use Bavix\Wallet\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Softon\Indipay\Facades\Indipay; 
use Cart;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

class PaymentController extends Controller
{
    public function makePaytmPayment($order){
        Log::info('Making Payment Started');

        $order = Helper::decodeId($order);
        OrderTransaction::create([
            'user_id' => auth()->user()->id,
            'order_id' => $order,
            'mode' => 'Paytm',
            'status' => 'Processing',
        ]);
        Log::info('Transaction Saved');
        $order = Order::find($order);
        
        $parameters = [
            'ORDER_ID' => $order->id,
            'CUST_ID' => $order->user->id,
            'TXN_AMOUNT' => $order->total
        ];
        // go to vender/softon/indipay/src/Gateways/PaytmGateway.php
        // and add this line on line no 62 all done no need to change anything to public
        // $this->parameters['CHECKSUMHASH'] = $this->checksum; 
        Log::info('Preparing Indipay with Paytm Gateway');
        $order = Indipay::gateway('Paytm')->prepare($parameters);
        Log::info('Processing Indipay');
        return Indipay::process($order);

    }

    public function paytmPaymentResponse(Request $request){

        Log::info('Paytm Payment Response Initiated');

        // For default Gateway
        $response = Indipay::gateway('Paytm')->response($request);
        if(isset($response['status'])){

            Log::info('Response Received');
            if(Auth::check()){

                $transaction = OrderTransaction::where('order_id', $response['ORDERID'])->where('user_id', auth()->user()->id)->first();
                $order = Order::find($response['ORDERID']);
                if($order->type == 'Recharge')
                    $this->rechargeOrderResponse($response, $transaction, $order);
                else
                    $this->productOrderResponse($response, $transaction, $order);
                
                Log::info('Transaction and Order Details Saved');

            }else{
                abort(403, 'Session Expired. Please login and try again');
            }
        }else{
            abort(403, 'Something Went Wrong. Please try again');
        }
        Cart::clearCartConditions();
        Cart::clear();
        return redirect()->route('account.order.show', $response['ORDERID']); 
    
    }
    
    public function razorpayPaymentResponse(Request $request){
        
        Log::info('Razorpay Payment Response Initiated:'. json_encode($request->all()));

        $input = $request->all();      
        $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));
        $razorpay_payment = $api->payment->fetch($input['razorpay_payment_id']);
        $razorpay_order = $api->order->fetch($input['razorpay_order_id']);
        $order = Order::find($razorpay_order->receipt);
        $order->status = 'Processing';
        if(count($input) && !empty($input['razorpay_payment_id'])) {

            $attributes  = array(
                'razorpay_signature'  =>  $input['razorpay_signature'],  
                'razorpay_payment_id'  => $input['razorpay_payment_id'] ,  
                'razorpay_order_id' => $order->order_transaction->razorpay_order_id
            );
            
            try {
                // verify the sign from response
                $api->utility->verifyPaymentSignature($attributes);

            }  catch(SignatureVerificationError $ex){
                Helper::throwExeception($ex);

            }

            Log::info('Payment Status Success');
            if($order->type == 'Recharge' || env('APP_ENV') != 'production') // mark order status complete when recharge or local...
                $order->status = 'Completed';
            $order->save();
            $transaction = $order->order_transaction;
            $transaction->status = 'Completed';
            $transaction->code = null;
            $transaction->razorpay_payment_id = $razorpay_payment->id;
            $transaction->razorpay_signature = $input['razorpay_signature'];
            $transaction->save(); 
            
            Log::info('Order Status Success');

            if($order->type == 'Recharge'){
                $wallet = auth()->user()->getWallet('call-wallet');
                $wallet->depositFloat($order->subtotal);
                return $this->rechargeOrderResponse($order, true);
            }else
                return $this->productOrderResponse($order);

        }
    }

    private function rechargeOrderResponse($order){

        $this->withdrawWallet($order);

        Cart::session(auth()->id())->clear();
        Cart::session(auth()->id())->removeCartCondition('GST @ 18%');
        Cart::session(auth()->id())->removeCartCondition('Wallet Balance Usage');
        Log::info('Cart and Conditions cleared in payment response');
        return redirect()->route('account.order.show', $order->id)->with('success', 'Congratulations ! Credits added successfully. You have '.INR.' '.auth()->user()->getWallet('call-wallet')->balanceFloat.' credits now.'); 
    }

    private function productOrderResponse($order){
        $this->sendEmailToCustomer($order);
        Notification::send(User::role('admin')->get(), new NewAdminOrder($order));
        $this->withdrawWallet($order);
        
        Cart::clearCartConditions();
        Cart::clear();
        Log::info('Cart and Conditions cleared in payment response');
        return redirect()->route('account.order.show', $order->id)->with('success', 'Thank You! Your order is placed successfully. We will process your order soon.'); 

    }

    private function sendEmailToCustomer($order){
        
        if(isset($order->address->email) && $order->address->email != null){
            Notification::route('mail', $order->address->email)
                        ->route(SmsChannel::class, $order->address->phone)
                        ->notify(new NewCustomerOrder($order));
        }
    }

    private function withdrawWallet($order, $is_session = false){
        Log::info('withdrawWallet Amount'. $order->total);
        $name = 'Wallet Balance Usage';
        
        $wallet = $is_session ? Cart::session(auth()->id())->getCondition($name) : Cart::getCondition($name);
        Log::info(json_encode($wallet));
        // on payment success withdraw the used amount from users wallet
        if($wallet != null){
            $condition = Cart::getCondition('Wallet Balance Usage');
            $amount = $condition->getCalculatedValue($order->total);
            $order->user->withdrawFloat($amount,[
                'created_by' => $order->user->id,
                'order_id' => $order->id,
                'message' => 'Wallet Balance Withdraw for order #'.$order->id
            ]); 
            Log::info('Wallet Balance Withdraw for order #'.$order->id);
        }
    }
}

<?php
namespace App\Traits;
use App\Helpers\Helper;
use App\Mail\IncompleteOrder;
use App\Mail\OrderFailed;
use App\Models\Order;
use Cart;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Razorpay\Api\Api;

trait WalletTrait
{

    public function applyWalletBalance($total, $is_session = false){
        try {
            $real_wallet = auth()->user()->wallet->balanceFloat;

            $total = Helper::decodeId($total);
            $value = (MAX_WALLET_USAGE/100)*$total; //get 20% of total

            // if wallet has less balance please exit;
            if($real_wallet <= 0 ){
                $this->emit('alert', 'error', 'Insufficient Wallet Balance');
                return;
            }

            $this->use_wallet = !$this->use_wallet;
            if($this->use_wallet){

                // if 20% is more than the wallet balance use all wallet balance in checkout
                $this->wallet_balance_used = $value > $real_wallet ? $real_wallet : $value;
                $condition = new \Darryldecode\Cart\CartCondition(array(
                    'name' => 'Wallet Balance Usage',
                    'type' => 'discount',
                    'target' => 'total', 
                    'value' => -$this->wallet_balance_used,
                    'order' => 1,
                    'attributes' => array( // attributes field is optional
                        'is_coupon' => false,
                    )
                ));

                if($is_session) 
                    Cart::session(auth()->id())->condition($condition); 
                else 
                    Cart::condition($condition);
                
                Log::info('Wallet Balance Applied');
                $this->wallet_balance = $this->wallet_balance - $this->wallet_balance_used;
                
            }else{
                if($is_session) 
                    Cart::session(auth()->id())->removeCartCondition('Wallet Balance Usage');
                else 
                    Cart::removeCartCondition('Wallet Balance Usage');
                $this->wallet_balance = auth()->user()->wallet->balanceFloat;
            }
        } catch (\Exception $ex) {
            Helper::throwExeception($ex);
        }

    }

    public function handleRazorPayError($res)
    {
        $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));
        $delay = now()->addMinutes(30);

        if (isset($res['error'])) {
            $razorpay_order = $api->order->fetch($res['error']['metadata']['order_id']);
            $order = Order::find($razorpay_order->receipt);
            $order->status = 'Failed';
            $order->save();

            Log::error('Payment Status Failed: ' . $res['error']['description']);
            $transaction = $order->order_transaction;
            $transaction->code = json_encode($res);
            $transaction->status = 'Failed';
            $transaction->save();

            Mail::to(ADMIN_EMAILS)->queue(new OrderFailed($order, $res));
            Mail::to($order->user->email)->later($delay, new IncompleteOrder($order));

            Cart::clearCartConditions();
            Cart::clear();
            // $this->emit('alert', 'error', $res['error']['description']);
            return Redirect::route('account.order.show', $order->id);
        } else if (!empty($res)) {

            $razorpay_order = $api->order->fetch($res);
            $order = Order::find($razorpay_order->receipt);
            $order->status = 'Failed';
            $order->save();

            $transaction = $order->order_transaction;
            $transaction->status = 'Failed';
            // $transaction->code = 'Payment Failed/Aborted';
            $transaction->save();

            Mail::to(ADMIN_EMAILS)->queue(new OrderFailed($order, $res));
            Mail::to($order->user->email)->later($delay, new IncompleteOrder($order));
            
            Cart::clearCartConditions();
            Cart::clear();
            Log::error('Payment Status Failed: Payment Window modal closed');
            request()->session()->flash(
                'error',
                'Payment Failed/Aborted!'
            );
            return Redirect::route('account.order.show', $order->id);
        }
    }
    
}
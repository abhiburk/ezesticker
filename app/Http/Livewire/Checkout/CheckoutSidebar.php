<?php

namespace App\Http\Livewire\Checkout;

use App\Helpers\Helper;
use App\Jobs\MailJob;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderTransaction;
use App\Models\UserAddress;
use App\Traits\WalletTrait;
use Carbon\Carbon;
use Livewire\Component;
use Cart;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Razorpay\Api\Api;
use Seshac\Shiprocket\Shiprocket;

class CheckoutSidebar extends Component
{
    use WalletTrait;

    public $coupon_code = null;
    public $use_wallet = 0;
    public $wallet_balance = 0;
    public $wallet_balance_used = 0;
    protected $listeners = ['refreshCheckoutComponent' => '$refresh', 'handleRazorPayError'];

    public function mount()
    {
        $this->removeCondition('Wallet Balance Usage');
        $this->wallet_balance = auth()->user()->wallet->balanceFloat;
        $this->resellerDiscount();
        // $token =  Shiprocket::getToken();

        // $pincodeDetails = [
        //     'pickup_postcode' => '431005',
        //     'delivery_postcode' => '440001',
        //     'cod' => '0',
        //     'weight' => '0.5'

        // ];
        // $response =  Shiprocket::courier($token)->checkServiceability($pincodeDetails);
        // dd($response);
    }

    public function render()
    {
        // query to check atleast billing address is filled
        $data['address'] = UserAddress::where('user_id', auth()->user()->id)->where('address_type', 'billing')->first();
        return view('livewire.checkout.checkout-sidebar', $data);
    }

    public function rules()
    {

        return [
            'coupon_code' => ['required', 'exists:coupons,name', 
            
                function ($attribute, $value, $fail) {
                    $coupon = Coupon::where('name', $value)->first();
                    if ($coupon != null && Carbon::now() > $coupon->end_date)
                        $fail('The coupon code you entered is expired');
                }, 
                
                function ($attribute, $value, $fail) {
                    $order = Order::where('user_id', auth()->id())->where('discount_code', $value)->count();
                    if ($order > 0)
                        $fail('The coupon code is already used');
                }
            
            ]
        ];
    }

    protected $messages = [
        'coupon_code.exists' => 'The coupon code you entered is invalid.',
    ];

    public function applyCoupon(){

        $this->validate();
        Log::info('Coupon Initiated');
        try {

            $coupon = Coupon::where('name', $this->coupon_code)->first();
            Cart::removeCartCondition($coupon->name);
            $condition = new \Darryldecode\Cart\CartCondition(array(
                'name' => $coupon->name,
                'type' => $coupon->type,
                'target' => $coupon->target,
                'value' => $coupon->value,
                'order' => 2,
                'attributes' => array('is_coupon' => true)
            ));
            Cart::condition($condition);
            Log::info('Coupon Applied');
            $this->emit('refreshCheckoutComponent', '$refresh');
        } catch (Exception $ex) {
            Log::info('Coupon Applied Failed');
            Helper::throwExeception($ex);
        }
    }

    public function removeCondition($conditionName){
        Cart::removeCartCondition($conditionName);
        $this->coupon_code = null;
    }

    public function storeOrder()
    {
        try {
            Log::info('Store Order Initiated');
            // save order
            $order = new Order();
            $order->user_id = auth()->user()->id;
            $order->total = Cart::getTotal();
            $order->subtotal = Cart::getSubTotal();
            $order->cart_conditions = Cart::getConditions();

            // save address, if no default is set use billing address for order
            $ua = UserAddress::where('user_id', auth()->user()->id);
            if ($ua->where('is_default', 1)->first() == null) {
                $order->address_id = UserAddress::where('user_id', auth()->user()->id)->where('address_type', 'billing')->first()->id;
            } else {
                $order->address_id = UserAddress::where('user_id', auth()->user()->id)->where('is_default', 1)->first()->id;
            }

            $order->save();
            Log::info('Order Saved');

            // save order items
            $cart = Cart::getContent();
            foreach ($cart as $item) {
                $oi = new OrderItem();
                $oi->product_id = $item->associatedModel->id;
                $oi->order_id = $order->id;
                $oi->name = $item->name;
                $oi->price = $item->getPriceSumWithConditions();
                $oi->quantity = $item->quantity;
                $oi->save();
            }
            Log::info('Order Items Saved');

            $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));
            $razor_order  = $api->order->create(array('receipt' => $order->id, 'amount' => Cart::getTotal() * 100, 'currency' => 'INR')); // Creates order
            $razor_order_id = $razor_order['id']; // Get the created Order ID

            OrderTransaction::create([
                'user_id' => auth()->user()->id,
                'order_id' => $order->id,
                'razorpay_order_id' => $razor_order_id,  // this is razorpay order_id
                'mode' => 'Razorpay'
            ]);
            Log::info('Order Transaction Saved');

            $this->dispatchBrowserEvent('make-razorpay', ['razorpay_order_id' => $razor_order_id, 'amount' => Cart::getTotal() * 100]);
            // redirect()->route('paytm.make_payment', Helper::encodeId($order->id)); 
        } catch (Exception $ex) {
            Helper::throwExeception($ex);
        }
    }

    private function resellerDiscount(){
        if (Cart::getTotalQuantity() >= MIN_RESELLER_QTY && auth()->user()->hasRole('Reseller')) {
            $condition = new \Darryldecode\Cart\CartCondition(array(
                'name' => 'Reseller Discount',
                'type' => 'discount',
                'target' => 'total',
                'value' => "-" . RESELLER_COMMISION . "%",
                'order' => 1
            ));
            Cart::condition($condition);
        } else {
            Cart::removeCartCondition('Reseller Discount');
        }
    }
}

<?php

namespace App\Http\Livewire\Account;

use App\Helpers\Helper;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderTransaction;
use App\Models\Product;
use App\Traits\WalletTrait;
use Livewire\Component;
use Cart;
use Illuminate\Support\Facades\Log;
use Razorpay\Api\Api;

class CallCredit extends Component
{
    use WalletTrait;

    public $use_wallet = 0;
    public $wallet_balance = 0;
    public $wallet_balance_used = 0;
    public $topup_amount = 0;
    protected $listeners = ['refreshCheckoutComponent' => '$refresh', 'handleRazorPayError'];
    
    public function mount(){
        $this->wallet_balance = auth()->user()->wallet->balanceFloat;

    }

    public function render()
    {
        return view('livewire.account.call-credit');
    }

    public function selectedTopup($amount = 0){
        $userId = auth()->id();
        $this->topup_amount = Helper::decodeId($amount) ? Helper::decodeId($amount) : $amount;
        
        // clear the cart
        Cart::session($userId)->clear();
        Cart::session($userId)->removeCartCondition('GST @ '.GST_CHARGE.'%');
        Cart::session($userId)->removeCartCondition('Wallet Balance Usage');

        // reset wallet checkbox
        $this->use_wallet = false;
        
        if($this->topup_amount > 0){
            $add = [
                'id' => uniqid(),
                'name' => 'Call Topup',
                'price' => $this->topup_amount,
                'quantity' => 1,
                'attributes' => array()
            ];
            
            Cart::session($userId)->add($add);

            // apply only if GST is active
            if(IS_GST_APPLICABLE){
                $condition = new \Darryldecode\Cart\CartCondition(array(
                    'name' => 'GST @ '.GST_CHARGE,
                    'type' => 'tax',
                    'target' => 'total',
                    'value' => GST_CHARGE,
                    'order' => 1,
                    'attributes' => array( // attributes field is optional
                        'is_coupon' => false,
                    )
                ));
                Log::info('GST Applied');
                Cart::session($userId)->condition($condition); 
            }
        }
        
    }

    public function payCallTopup(){
        
        $product = Product::where('slug', 'smart-sticker-recharge')->first();
        // $condition = Cart::getCondition('Wallet Balance Usage');
        $total = Cart::session(auth()->id())->getTotal();
        $subtotal = Cart::session(auth()->id())->getSubTotal();
        
        $order = new Order();
        $order->user_id = auth()->user()->id;
        $order->type = 'Recharge';
        $order->total = $total;
        $order->subtotal = $subtotal;
        // $order->discount = $condition->getCalculatedValue(Cart::session(auth()->id())->getTotal()); //commenting as bcz wallet usage cannot be a discount
        $order->save();

        $oi = new OrderItem();
        $oi->product_id = $product->id;
        $oi->order_id = $order->id;
        $oi->name = $product->name;
        $oi->price = $subtotal;
        $oi->quantity = 1;
        $oi->save();

        $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));
        $razor_order  = $api->order->create(array('receipt' => $order->id, 'amount' => $total * 100, 'currency' => 'INR')); // Creates order
        $razor_order_id = $razor_order['id']; // Get the created Order ID

        OrderTransaction::create([
            'user_id' => auth()->user()->id,
            'order_id' => $order->id,
            'razorpay_order_id' => $razor_order_id,  // this is razorpay order_id
            'mode' => 'Razorpay'
        ]);

        $this->dispatchBrowserEvent('make-razorpay', ['razorpay_order_id' => $razor_order_id, 'amount' => $total * 100]);

    }
}

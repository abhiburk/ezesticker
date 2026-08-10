<?php

namespace App\Http\Livewire\Account;

use App\Helpers\Helper;
use App\Models\Order;
use App\Traits\WalletTrait;
use Livewire\Component;

class RetryPayment extends Component
{
    use WalletTrait;
    
    public $order;
    protected $listeners = ['handleRazorPayError'];

    public function render()
    {
        return view('livewire.account.retry-payment');
    }

    public function retryPayment($order_id){
        $order = Order::find(Helper::decodeId($order_id));
        $razor_order_id = $order->order_transaction->razorpay_order_id;
        $order_total = $order->total*100;
        $this->dispatchBrowserEvent('make-razorpay', ['razorpay_order_id' => $razor_order_id, 'amount' => $order_total]);
    }
}

<?php

namespace App\Http\Livewire\Admin;

use App\Mail\OrderStatusChange;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class OrderStatusChanger extends Component
{
    public $order_status;
    public $order = null;
    public $content = '';
    
    public function mount($order)
    {
        $this->order = $order; 
        $this->order_status = $order->status;   
    }
    
    public function render()
    {
        return view('livewire.admin.order-status-changer');
    }

    public function updateStatus()
    {
        Order::where('id', $this->order->id)->update(['status' => $this->order_status]);
        Mail::to($this->order->user->email)->queue(new OrderStatusChange($this->order, $this->content));
        redirect()->route('order.show', $this->order->id);
    }
}

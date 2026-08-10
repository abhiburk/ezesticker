<?php

namespace App\Http\Livewire\Cart;

use App\Models\User;
use Livewire\Component;
use Cart;

class CartList extends Component
{
    public $item;
    public $quantity;
    
    public function render()
    {
        $this->updateCartQty();
        return view('livewire.cart.cart-list');
    }

    public function mount($id)
    {   
        $this->item = Cart::get($id);
        // dd($this->item->quantity);
        
        // if(empty($this->item)) redirect()->route('shop.cart');
        $this->quantity = $this->item['quantity'];
        
    }

    public function removeItemFromCart(){
         
        // $this->updateCartQty();
        Cart::remove($this->item['id']);
        // $this->emit('refreshCartCount');
        //  refresh when cart is empty
        // if(Cart::getContent()->count() == 0)
            redirect()->route('shop.cart');
    }

    public function increment()
    {
        $this->quantity++;
        $this->updateCartQty();
    }

    public function decrement()
    {
        $this->quantity--;
        $this->updateCartQty();
    }

    public function updateCartQty(){
        Cart::update($this->item['id'], array(
            'quantity' => array(
                'relative' => false,
                'value' => $this->quantity
            ),
        ));

        $this->item = Cart::get($this->item['id']);
        $this->emitSelf('$refresh');
        $this->emit('refreshCartCount');
        $this->emit('refreshComponent');
        Cart::removeCartCondition('Reseller Discount');
        Cart::removeCartCondition('Wallet Balance Usage');
    }
}

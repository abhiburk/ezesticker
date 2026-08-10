<?php

namespace App\Http\Livewire\Cart;
use Cart;
use Livewire\Component;

class CartCounter extends Component
{
    protected $listeners = [
        'refreshCartCount' => '$refresh'
    ];

    public function render()
    {
        return view('livewire.cart.cart-counter');
    }
}

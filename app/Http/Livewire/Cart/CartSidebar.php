<?php

namespace App\Http\Livewire\Cart;

use Livewire\Component;

class CartSidebar extends Component
{

    protected $listeners = [
        'refreshComponent' => '$refresh'
    ];

    public function render()
    {
        return view('livewire.cart.cart-sidebar');
    }
}

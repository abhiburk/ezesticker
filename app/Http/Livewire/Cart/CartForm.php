<?php

namespace App\Http\Livewire\Cart;

use App\Models\Product;
use Livewire\Component;
use Cart;

class CartForm extends Component
{
    public $quantity = 1;
    public $product = null;
    
    public function mount($product)
    {
        $this->product = $product;
    }

    public function render()
    {
        return view('livewire.cart.cart-form');
    }

    public function increment()
    {
        $this->quantity++;
    }

    public function decrement()
    {
        if($this->quantity != 1)
            $this->quantity--;
    }

    public function getProductDiscount($product){
        $price = $product->prices->first();
        if($price->discount_type == 'Percentage'){
            $discount = -$price->discount.'%';
        }
        if($price->discount_type == 'Regular'){
            $discount = -$price->discount;
        }
        return $discount;
    }

    public function addToCart(){
        $product = Product::find($this->product->id);
        $price = $product->prices->first();

        $add = [
            'id' => uniqid(),
            'name' => $this->product->name,
            'price' => $this->product->prices->first()->price,
            'quantity' => $this->quantity,
            'attributes' => array(),
            'associatedModel' => $product,
        ];

        if($price->discount != null){
            $discountCondition = new \Darryldecode\Cart\CartCondition([
                'name' => $price->discount_type == 'Percentage' ? $price->discount.'%' : $price->discount,
                'type' => 'discount',
                'value' => $this->getProductDiscount($product),
            ]);
            Cart::condition($discountCondition);
        }

        if(IS_SHIPPING_APPLICABLE){
            $condition2 = new \Darryldecode\Cart\CartCondition(array(
                'name' => 'Shipping',
                'type' => 'charge',
                'target' => 'total', // this condition will be applied to cart's subtotal when getSubTotal() is called.
                'value' => SHIPPING_CHARGE,  
                'order' => 3
            ));
            Cart::condition($condition2);
        }

        Cart::add($add);

        $this->emit('refreshCartCount', '$refresh');
        $this->emit('alert', 'success', 'Product added to your cart');

    }
}

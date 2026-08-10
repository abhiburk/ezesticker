@extends('layouts.frontend.app')
@section('title', 'My Cart')
@section('content')
    <div class="container mt-5">
        <div class="row">

            @if (Cart::getContent()->count() > 0)
                
                <main class="col-md-8">
                    @foreach (Cart::getContent() as $item)
                        @livewire('cart.cart-list', ['id' => $item->id], key($item->id))
                    @endforeach
                </main>
                <aside class="col-md-4">
                    @livewire('cart.cart-sidebar')
                </aside>

            @else 

                <x-empty_cart/>

            @endif

        </div>
    </div>
@endsection


@extends('layouts.frontend.app')
@section('title', 'Checkout')
@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-12">
                @role('Reseller')
                    <p class="alert alert-warning text-center">
                        <small>You have a reseller account. Order minimum 20 ezestickers and get <b>20%</b> Off on total order. <a href="{{ route('shop.cart') }}">Update Cart</a></small>
                    </p>    
                @endrole
            </div>
        </div>
        <div class="row">
            @if (Cart::getContent()->count() > 0)
                <main class="col-md-8 mt-3">
                    <div class="card">
                        <div class="card-body">
                            @livewire('account.address-form')
                        </div>
                    </div>
                </main>
                <aside class="col-md-4 mt-3">
                    <div class="card mb-3">
                        <div class="card-header bg-transparent font-weight-bold">
                            Your Order
                        </div>
                        <div class="card-body">
                            @foreach (Cart::getContent() as $item)
                                <figure class="itemside d-flex align-items-center justify-content-between ">
                                    <div class="aside">
                                        <img src="{{ url('storage/'. $item->associatedModel->featured_image) }}" width="50" class="img-xs">
                                        
                                    </div>
                                    <figcaption class="info px-2">
                                        {{ $item->name }}
                                        <small class="text-muted">
                                            @forelse ($item->getConditions() as $c)
                                                {{ INR }}{{ $item->associatedModel->prices->first()->price - $c }} 
                                            @empty
                                                {{ INR }}{{ $item->associatedModel->prices->first()->price }}
                                            @endforelse
                                            x {{ $item->quantity }}
                                        </small>
                                    </figcaption>
                                    <div class="price mx-2 text-right"> 
                                        {{ INR }}{{ $item->getPriceSumWithConditions() }} 
                                        <del class="price-old text-secondary"><small>{{ INR }}{{ $item->price }}</small></del>
                                    </div>
                                </figure>
                            @endforeach
                        </div>
                    </div>
                    @livewire('checkout.checkout-sidebar')
                </aside>
            @else 
                <x-empty_cart/>
            @endif

        </div>
    </div>
@endsection 
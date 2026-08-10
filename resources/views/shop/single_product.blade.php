@extends('layouts.frontend.app')
@section('title', $product->name)
@section('content')
    <section class="bg-white">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9 col-sm-12">
                    <article class="card card-product-list border-0">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-sm-4">
                                    <span class="row justify-content-center">
                                        <img src="{{ url('storage/' . $product->featured_image) }}" class="col-6 col-lg-12">
                                    </span>
                                </div>
                                <div class="col-sm-8"> 
                                    <h3 class="title mt-2 ">{{ $product->name }}</h3>
                                    <div class="d-flex mb-3">
                                        <div class="price-wrap mr-4">
                                            <span class="price h5">{{ INR }}{{ $product->prices->first()->price }}</span>
                                            @if ($product->prices->first()->price != $product->prices->first()->orignal_price)
                                                <del class="price-old text-secondary ml-2"><small>{{ INR }}{{ $product->prices->first()->orignal_price }}</small></del>
                                            @endif
                                        </div>

                                        <div class="rating-wrap">
                                            <x-utils.rating :rating='$product->comments()->avg("rating")' />
                                            {{-- <small class="label-rating text-muted">7/10</small> --}}
                                        </div>
                                    </div>
                                    <p>{!! $product->description !!} </p>
                                    @livewire('cart.cart-form', ['product' => $product])
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>

    {{-- <x-offer/> --}}

    <section>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9 col-sm-12">
                    @livewire('comment.comment-form', ['product' => $product])
                </div>
                @livewire('comment.comment-list', ['product' => $product])
            </div>
        </div>
    </section>
    

@endsection

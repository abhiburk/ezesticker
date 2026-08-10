@extends('layouts.frontend.app')
@section('title', 'Shop')
@section('content')
    <section class="bg-white">
        <div class="container">
            <div class="section-heading text-center mb-4">
                <h2 class="text-responsive">Our Smart Stickers</h2>
                <p class="text-muted ">Check out our some of the smart stickers colection you can purchase</p>
                <hr>
            </div>
            <div class="row">
                <div class="col-md-4 mt-3">
                    <div class="card-banner"
                        style="height:220px; background-image: url('{{ url('frontend/img/steinar-engeland-drw6RtOKDiA-unsplash-2323.jpg') }}');">
                        <article class="card-body caption">
                            <h5 class="card-title font-weight-bold">Vehicle Stickers</h5>
                            <p>Apply a smart sticker to your vehicles and make yourself available near your vehicle</p>
                            <a href="{{ route('shop.slug', 'smart-vehicle-sticker') }}" class="btn btn-warning"> Order Now </a>
                        </article>
                    </div>
                </div> 
                 
                <div class="col-md-4 mt-3">
                    <div class="card-banner"
                        style="height:220px; background-image: url('{{ url('frontend/img/pexels-dids-1986996.jpg') }}');">
                        <article class="card-img-overlay caption text-white">
                            <h5 class="card-title font-weight-bold">Mini Sticker</h5>
                            <p>Do not worry about your day to day stuffs, apply mini sticker to your belongings.</p>
                            <a href="{{ route('shop.slug', 'smart-mini-sticker') }}" class="btn btn-warning"> Order Now </a>
                        </article>
                    </div>
                </div>

                <div class="col-md-4 mt-3">
                    <div class="card-banner"
                        style="height:220px; background-image: url('{{ url('frontend/img/banner-dog-1.jpg') }}');">
                        <article class="card-body caption text-white">
                            <h5 class="card-title font-weight-bold">Combo Stickers</h5>
                            <p>Get Combo stickers for your needs.</p>
                            <a href="{{ route('shop.slug', 'combo-stickers') }}" class="btn btn-warning"> Order Now </a>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- <x-offer/> --}}
@endsection


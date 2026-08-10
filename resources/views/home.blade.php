@extends('layouts.frontend.app')
@section('title', 'Smart Virtual Sticker')
@section('content')
    @php
        $banners = ['home-banner-1.jpg', 'home-banner-2.jpg', 'home-banner-3.jpg'];
    @endphp
    <header class="masthead bg-dark" style="z-index: 1;">
        <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                @foreach ($banners as $item)
                    <li data-target="#carouselExampleCaptions" data-slide-to="{{ $loop->iteration }}" class="{{ $loop->iteration==1?'active':'' }}"></li>
                @endforeach
            </ol>
            <div class="carousel-inner">
                @foreach ($banners as $item)
                    <div class="carousel-item {{ $loop->iteration==1?'active':'' }}">
                        <img src="{{ url('frontend/img/'.$item) }}" class="d-block w-100 banner-imgs"
                        style="">
                        <div class="row">
                            <div class="carousel-caption col-9 col-lg-4">
                                <div>
                                    <h1>
                                        MAKE YOUR STUFF <b class="font-weight-bold">SMARTER</b> THAN EVER
                                    </h1>
                                    {{-- <h5>Apply a smart sticker to your vehicles and make yourself available near your vehicle</h5> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </header>
    <section class="bg-light" id="video">
        <div class="container">
        <div class="row">
            <div class="col-12">
                <video class="w-100" controls src="{{url('frontend/video/ezesticker-1080p-210415.mp4')}}" />
            </div>
        </div>
        </div>
    </section>
    <section class="bg-white" id="download">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="single-banner mb-4">
                        <a href="{{ route('shop.slug', 'smart-mini-sticker') }}"><img src="{{ url('frontend/img/home-banner-4.jpg') }}" alt="For Pets"></a>
                        <div class="banner-content-4 banner-position-hm15-2 pink-banner">
                            <h2 class="text-dark">For Pets Collar</h2>
                            <h5>Best for your pets</h5>
                            <a href="{{ route('shop.slug', 'smart-mini-sticker') }}" class="btn btn-warning">ORDER NOW</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="single-banner mb-4">
                        <a href="{{ route('shop.slug', 'smart-vehicle-sticker') }}"><img src="{{ url('frontend/img/home-banner-5.jpg') }}" alt="Vehicle Sticker"></a>
                        <div class="banner-content-3 banner-position-hm15-2 pink-banner">
                            <h3 class="text-white">Vehicle Stickers</h3>
                            <a href="{{ route('shop.slug', 'smart-vehicle-sticker') }}"><i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="single-banner mb-4 ">
                        <a href="{{ route('shop.slug', 'smart-mini-sticker') }}"><img src="{{ url('frontend/img/home-banner-6.jpg') }}" alt="Mini Sticker" style="object-fit: cover;max-height: 425px;"></a>
                        <div class="banner-content-3 banner-position-hm17-1 pink-banner">
                            <h3 class="text-white">Mini Sticker</h3>
                            <a href="{{ route('shop.slug', 'smart-mini-sticker') }}" > <i class="fa fa-arrow-right"></i> </a>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </section>

    <section class="collections py-0 bg-light">
        <div class="container-fluid">
            <div class="row d-flex align-items-center">
                <div class="col-md-8 ab-content-img aci-1-bg"></div>
                <div class="col-md-4 ab-content text-center my-lg-5 my-5">
                    <h4 class="text-responsive">
                        Emergency Contact
                        <p>Scenario-1</p>
                    </h4>
                    <p>
                        Smart Vehicle Sticker are life saviour in emergency situations. Someone met with accident and their is Smart Sticker,
                        one can easily contact by scanning the QR Code on the vehicle met with an accident.
                    </p>
                    <a href="{{ route('shop.slug', 'smart-vehicle-sticker') }}" class="btn btn-warning mt-3">Order Now</a>
                </div>
            </div>
        </div>
    </section>

    <section class="banner-bottom py-5 bg-white">
        <div class="container py-md-5">
            <h2 class="text-responsive title-wthree mb-lg-5 mb-4 text-center">
                Safety For Pets
                <p>Scenario-2</p>
            </h2>
            <div class="row text-center">
                <div class="col-md-4 content-gd-wthree">
                    <img src="{{ url('frontend/img/pexels-karolina-grabowska-5705553.jpg') }}" class="img-fluid shadow-sm" alt="">
                </div>
                <div class="col-md-4 my-5 py-lg-5 my-lg-5">
                    <h4 class="font-weight-bold">How collar stickers are used ?</h4>
                    <p>
                        Our Smart collar sticker can be used on your pets collar and in case they are lost somewhere,
                        this smart sticker will be useful to contact and connect to the pet's mom.
                    </p>
                    <a href="{{ route('shop.slug', 'smart-mini-sticker') }}" class="btn btn-warning mt-3">Order Now</a>

                </div>
                <div class="col-md-4 content-gd-wthree">
                    <img src="{{ url('frontend/img/mathilde-langevin-E-BHePa1_y0-unsplash.jpg') }}" class="img-fluid shadow-sm" alt="">
                </div>
            </div>

        </div>
    </section>

    <section class="collections py-0 bg-light">
        <div class="container-fluid">
            <div class="row d-flex align-items-center">
                <div class="col-md-4 ab-content text-center my-lg-5 my-5">
                    <h4 class="text-responsive">
                        Travel Must Haves
                        <p>Scenario-3</p>
                    </h4>
                    <p>
                        You do not need to worry while you are travelling. Our mini smart stickers can be handy at such situation.
                        Just apply this stickers to you travelling bags to avoid worrying about loosing your luggage.
                    </p>
                    <a href="{{ route('shop.slug', 'smart-mini-sticker') }}" class="btn btn-warning mt-3">Order Now</a>
                </div>
                <div class="col-md-8 ab-content-img aci-2-bg"></div>
            </div>
        </div>
    </section>

    {{-- <section class="banner-bottom py-5 bg-white">
        <div class="container py-md-5">
            <div class="row align-items-center">
                <div class="col-lg-4 gallery-content-info text-center mt-lg-5">
                    <h2 class="title-wthree mb-lg-5 mb-4 text-responsive">Some Scenarios</h2>
                    <p>
                        Using our smart stickers and tags are useful at various occasion and can be life saviour sometimes.
                        Here are some of the scenarios where our smart stickers can be useful.
                    </p>
                </div>
                <div class="col-lg-8 gallery-content">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 gal-img">
                            <img src="https://demo.w3layouts.com/demos_new/template_demo/29-05-2019/baggage_demo_Free/379113341/web/images/g1.jpg"
                            alt="Baggage" class="img-fluid mt-4">
                        </div>
                        <div class="col-md-6 col-sm-6 gal-img">
                            <img src="https://demo.w3layouts.com/demos_new/template_demo/29-05-2019/baggage_demo_Free/379113341/web/images/g2.jpg"
                            alt="Baggage" class="img-fluid mt-4">
                        </div>
                        <div class="col-md-6 col-sm-6 gal-img">
                            <img src="https://demo.w3layouts.com/demos_new/template_demo/29-05-2019/baggage_demo_Free/379113341/web/images/g3.jpg"
                            alt="Baggage" class="img-fluid mt-4">
                        </div>
                        <div class="col-md-6 col-sm-6 gal-img">
                            <img src="https://demo.w3layouts.com/demos_new/template_demo/29-05-2019/baggage_demo_Free/379113341/web/images/g4.jpg"
                            alt="Baggage" class="img-fluid mt-4">
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section> --}}

    {{-- <section class="features bg-light" id="features">
        <div class="container">
            <div class="section-heading text-center">
                <h2>Unlimited Features, Unlimited Fun</h2>
                <p class="text-muted">Check out what you can do with this app theme!</p>
                <hr>
            </div>
            <div class="row">
                <div class="col-lg-4 my-auto">
                    <div class="device-container">
                        <div class="device-mockup iphone6_plus portrait white">
                            <div class="device">
                                <div class="screen">
                                    <!-- Demo image for screen mockup, you can put an image here, some HTML, an animation, video, or anything else! -->
                                    <img src="{{ url('frontend/img/demo-screen-1.jpg') }}" class="img-fluid" alt="">
                                </div>
                                <div class="button">
                                    <!-- You can hook the "home button" to some JavaScript events or just remove it -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 my-auto">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="feature-item">
                                    <i class="icon-screen-smartphone text-primary"></i>
                                    <h3>Device Mockups</h3>
                                    <p class="text-muted">Ready to use HTML/CSS device mockups, no Photoshop required!</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="feature-item">
                                    <i class="icon-camera text-primary"></i>
                                    <h3>Flexible Use</h3>
                                    <p class="text-muted">Put an image, video, animation, or anything else in the screen!
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="feature-item">
                                    <i class="icon-present text-primary"></i>
                                    <h3>Free to Use</h3>
                                    <p class="text-muted">As always, this theme is free to download and use for any purpose!
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="feature-item">
                                    <i class="icon-lock-open text-primary"></i>
                                    <h3>Open Source</h3>
                                    <p class="text-muted">Since this theme is MIT licensed, you can use it commercially!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cta">
        <div class="cta-content">
            <div class="container">
                <h2>Stop waiting.<br>Start building.</h2>
                <a href="#contact" class="btn btn-outline btn-xl js-scroll-trigger">Let's Get Started!</a>
            </div>
        </div>
        <div class="overlay"></div>
    </section> --}}
    <section class="bg-white">
        <div class="container">
          <div class="row no-gutters justify-content-between">
            <div class="col-12 col-md-5 py-12">
                <h1 class="text-responsive mb-3">Calling Feature</h1>
                <p class="font-weight-bold">
                    We use advanced data protection to
                    ensure the privacy of both caller & receiver's mobile no.
                </p>
                <p class="text-muted">
                    Both user and the owner of the QR sticker will be connected through one of our virtual number, 
                    so their is no personal number exchange between both the people.
                </p>
                </div>
            <div class="col-12 col-md-6">
                <img src="{{ url('frontend/img/undraw_calling_kpbp.svg') }}" alt="Calling" class="w-100">
            </div>
          </div>
        </div>
      </section>
    <section class="contact bg-warning" id="contact">
        <div class="container">
            <h2 class="text-center text-responsive">
                Reach Us @
            </h2>
            <x-social_media/>
            {{-- <address class="p-4">
                Techmounten - Ezesticker <br>
                Main Road, Kasabkheda, Khultabad, <br> Aurangabad MH India. 431102
            </address> --}}
        </div>
    </section>
@endsection

@push('css')
    <style>
        .aci-1-bg{
            background: url('{{ url('frontend/img/ambulance.jpg') }}');
        }
        .aci-2-bg{
            background: url('{{ url('frontend/img/pexels-dids-1986996.jpg') }}');
        }
        .ab-content-img{
            background-size: auto;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }
        .carousel-video{
            object-fit: cover;
            height: 75vh;
        }
        @media (max-width: 768px) {
            .carousel-video{
                height: 36.5vh;
            }
        }
        
    </style>
@endpush

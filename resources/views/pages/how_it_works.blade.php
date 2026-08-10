@extends('layouts.frontend.app')
@section('title', 'How it Works')
@section('content')
<div class="container bg-light">
    <div class="card my-5 shadow">
        <div class="card-body">
            <div class="row">
                <div class="col-12 text-center my-5">
                    <h1 class="text-responsive font-weight-bold d-block">How it Works ?</h1>
                </div>
                <div class="col-12">
                    <div>
                        <div class="row p-5">
                            {{-- 1 --}}
                            <div class="col-lg-6 col-sm-12  mt-5">
                                <h2 class="text-secondary hiw-title font-weight-bold">01</h2>
                                <p class="hiw-subtitle">
                                    Find EZEsticker from our website and we'll ship it for you at your given address.
                                </p>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <img src="{{ url('frontend/img/undraw_package_arrived_63rf.svg') }}" alt="Image 01" class=" w-100">
                            </div>
                            <hr>
                        </div>
                        <hr>
                        <div class="row p-5">
                            {{-- 2 --}}
                            <div class="col-lg-6 col-sm-12 mt-5">
                                <h2 class="text-secondary hiw-title font-weight-bold">02</h2>
                                <p class="hiw-subtitle">
                                    When you receives the EZEsticker, you can scan it using your camera or other apps like paytm.
                                </p>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <img src="{{ url('frontend/img/undraw_sentiment_analysis_jp6w.svg') }}" alt="Image 01" class=" w-100">
                            </div>
                        </div>
                        <hr>
                        <div class="row p-5">
                            {{-- 3 --}}
                            <div class="col-lg-6 col-sm-12 mt-5">
                                <h2 class="text-secondary hiw-title font-weight-bold">03</h2>
                                <p class="hiw-subtitle">
                                    Once scanned, you will be redirect to our web app where we'll ask you to verify & link your mobile number followed by some optional details.
                                </p>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <img src="{{ url('frontend/img/undraw_Order_confirmed_re_g0if.svg') }}" alt="Image 01" class=" w-100">
                            </div>
                        </div>
                        <hr>
                        <div class="row p-5">
                            {{-- 4 --}}
                            <div class="col-lg-6 col-sm-12 mt-5">
                                <h2 class="text-secondary hiw-title font-weight-bold">04</h2>
                                <p class="hiw-subtitle">
                                    Yeah! You are ready to put your sticker on your vehicle or on other essentials belongings.
                                </p>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <img src="{{ url('frontend/img/undraw_city_driver_jh2h.svg') }}" alt="Image 01" class=" w-100">
                            </div>
                        </div>
                        <hr>
                        <div class="row p-5">
                            {{-- 5 --}}
                            <div class="col-lg-6 col-sm-12 mt-5">
                                <h2 class="text-secondary hiw-title font-weight-bold">05</h2>
                                <p class="hiw-subtitle">
                                    Now people can simply scan your QR code to contact you through encrypted call. 
                                    No private information is exchange between both persons.
                                </p>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <img src="{{ url('frontend/img/undraw_my_app_re_gxtj.svg') }}" alt="Image 01" class=" w-100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
    <style>
        .hiw-title{
            font-size: 40px;
        }
        .hiw-subtitle{
            font-size: 25px;
        }
    </style>
@endpush

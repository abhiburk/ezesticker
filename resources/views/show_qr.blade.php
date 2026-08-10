@extends('layouts.frontend.app')
@section('title', 'QR Code: '. $title)
@section('content')
<div class="container bg-light">
    <div class="row mt-5 justify-content-center align-items-center">
        <div class="col-lg-10 col-sm-12">
            <div class="text-center">
                @empty($qr_detail)
                    <h2 class="font-weight-bold ">
                        Thank You for purchasing the <span class="text-warning font-weight-bold">eze</span>sticker.
                    </h2>
                    <p>Please enter your mobile no. to link with this QR Sticker</p>
                    {{-- <img src="{{ url('frontend/img/undraw_Access_account_re_8spm.svg') }}" alt=""
                        class="col-lg-3 col-5"> --}}
                @else
                    <h2 class="font-weight-bold text-responsive">
                        Contact Owner
                    </h2>
                    <p>Please find below details to contact the QR Sticker owner.</p>
                @endempty
            </div>
        </div>
    </div>
    <hr>
    <div class="row justify-content-center align-items-center mt-3 mb-5">
        <div class="col-lg-5 col-sm-12 col-md-12 order-sm-2">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    @empty($qr_detail)
                        @livewire('auth.login-form', ['qr_code_id' => request()->qr_code_id, 'login_source' => 'qr_sticker'])
                    @else
                        <figure class="text-center">
                            {{-- <span data-letters="{{ Helper::firstLetter($qr_detail->user->name) }}" style="font-size:2em;"></span> --}}
                            <x-utils.avtar src="{{ $qr_detail->user->getUserImageUrl() }}" name="{{ $qr_detail->user->name }}" width="100" height="100"/>
                            <figcaption class="pt-4">
                                <h3 class="title">{{ $qr_detail->user->name }}</h3>
                                @if (!empty($qr_detail->blood_group))
                                    <h6 class="font-weight-bold">
                                        Blood Group: {{ $qr_detail->blood_group }}
                                    </h6>
                                @endif
                                <p><small>{{ $qr_detail->message }}</small></p>
                            </figcaption>
                        </figure>
                        {{-- <a href="{{ route('account.message', Helper::encodeId($qr_detail->user->id)) }}">Send a Message</a> --}}
                        @livewire('utils.qr-connect', ['qr_detail' => $qr_detail])
                    @endempty
                </div>
            </div>
            <div class="card shadow-sm mt-3">
                <div class="card-body">
                    <section class="contact p-0 text-center">
                        <x-social_media />
                    </section>
                </div>
            </div>
        </div>
        @if (!empty($qr_detail) && CALL_SERVICE)
            <div class="col-lg-7 col-sm-12 col-md-12 order-sm-1 d-none d-lg-block">
                <img src="{{ url('frontend/img/Call-Flow.jpg') }}" alt="" class="img-fluid ">
            </div>
        @endif
    </div>
</div>

@endsection

@push('css')
    <style>
        section.contact ul.list-social li a {
            font-size: 15px;
            line-height: 25px;
            display: block;
            width: 25px;
            height: 25px;
            color: white;
            border-radius: 100%;
        } 
    </style>
@endpush
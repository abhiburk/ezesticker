@extends('errors.layout')
@section('title', __('Coming Soon'))
@section('content')
    <h1>coming soon<span class="dot">.</span></h1>
    {{-- <p>something quit cool</p> --}}
    <div class="icons">
        {{-- <a href="{{ WHATSAPP_LINK }}"><i class="bi bi-whatsapp"></i></a> --}}
        <a href="{{ INSTAGRAM_LINK }}"><i class="bi bi-instagram"></i></a>
        <a href="{{ FACEBOOK_LINK }}"><i class="bi bi-facebook"></i></a>
    </div>

    <p class="text-secondary" style="margin-top: 5em;">
        Product by <a href="http://techmounten.com/">Techmounten</a>
    </p>
@endsection
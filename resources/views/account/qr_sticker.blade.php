@extends('layouts.frontend.app')
@section('title', 'Qr Stickers: ' . auth()->user()->name)
@section('content')
    <div class="container-fluid ">
        <div class="container py-5" >
            <div class="row" >
                @include('account.sidebar')  
                <div class="col-sm-12 col-lg-8 mt-4">
                    @livewire('account.qr-list')
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.frontend.app')
@section('title', 'Add Call Credits')
@section('content')
    <div class="container-fluid ">
        <div class="container py-5" >
            <div class="row" >
                @include('account.sidebar')
                <div class="col-sm-12 col-lg-8 mt-lg-4">
                    <div class="row justify-content-end">
                        <div class="col-12">
                            <div class="card shadow-sm mb-3">
                                <div class="card-body">
                                    <h6 class="m-0">Incoming Call Credits: {{ INR }}{{ auth()->user()->getWallet('call-wallet')->balanceFloat ?? '0' }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    @livewire('account.call-credit')
                </div>
            </div>
        </div>
    </div>
@endsection

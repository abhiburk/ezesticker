@extends('layouts.frontend.app')
@section('title', 'Verification')
@section('content')
    <div class="container-fluid ">
        <div class="container py-5" >
            <div class="row justify-content-center">
                <div class="col-lg-6 col-sm-12 ">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            @livewire('account.otp-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

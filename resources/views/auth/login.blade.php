@extends('layouts.frontend.app')
@section('title', 'Login')
@section('content')
<div class="container-fluid bg-light">
    <!-- Outer Row -->
    <div class="row justify-content-md-center align-items-center mt-5">
        <div class="col-12">
            <div class="text-center">
                <h4 class="h4 text-gray-900 ">Welcome Back!</h4>
                <p class="text-secondary">Login or Register</p>
                <hr>
            </div>
        </div>
        <div class="col-lg-3 col-sm-12">
            <div class="card o-hidden border-0 shadow-sm my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                @livewire('auth.login-form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

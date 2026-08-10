@extends('layouts.frontend.app')
@section('title', 'Become a Reseller')
@section('content')
<div class="container bg-light">
    <div class="card my-5 shadow">
        <div class="card-body">
            <div class="row">
                <div class="col-12 text-center my-5">
                    <h1 class="text-responsive font-weight-bold d-block">Join Us Become a Reseller</h1>
                </div>
                <div class="col-12">
                    <div class="row justify-content-center ">
                        @role('Reseller')
                            <div class="col-lg-12 col-sm-12 text-center">
                                <h2 class="w-100">You are already a Reseller</h2>
                            </div>
                        @else
                            <div class="col-lg-6 col-sm-12 text-center">
                                <h4 class="text-muted mb-5">
                                    Become a reseller and help us sell ezesticker and get <b>{{ RESELLER_COMMISION }}%</b> off on your order of minimum {{ MIN_RESELLER_QTY }} ezestickers.
                                </h4>
                                @auth
                                    @livewire('reseller.reseller-button')
                                @else
                                    @livewire('auth.login-form', ['qr_code_id' => null, 'login_source' => 'reseller'])
                                @endauth
                            </div>
                        @endrole
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
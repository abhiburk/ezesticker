@extends('layouts.frontend.app')
@section('title', 'Referral Program')
@section('content')
<div class="container bg-light">
    <div class="card my-5 shadow">
        <div class="card-body">
            <div class="row">
                <div class="col-12 text-center my-5">
                    <h1 class="text-responsive font-weight-bold d-block">Refer & Earn</h1>
                </div>
                <div class="col-12">
                    <div class="row justify-content-center">
                        <div class="col-lg-8 col-sm-12 ">
                            <div class="row">
                                <div class="col-12">
                                    <p class="text-muted text-left">
                                        We'll pay you <b>{{ REFERRAL_COMMISION }}% commision</b> on every purchase made through your referral code. <br>
                                        Copy or Send the referral code to your friend and <b>GET {{ REFERRAL_COMMISION }}%</b> to you and your friends wallet.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-sm-12 mt-2">
                            <label for="on_whatsapp">Custom Referral</label>
                            <div class="input-group mb-3">
                                <input type="text" id="myInput" class="form-control" readonly="readonly"  value="{{ Auth::user()->affiliate_id }}">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="button-addon2" onclick="copyReferral(this)">Copy</button>
                                </div>
                            </div>
                            @livewire('utils.referral-invitation')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
    
@endpush

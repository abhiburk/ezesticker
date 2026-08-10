@extends('layouts.frontend.app')
@section('title', 'Call Logs')
@section('content')
    <div class="container-fluid ">
        <div class="container py-5" >
            <div class="row" >
                @include('account.sidebar')
                <div class="col-sm-12 col-lg-8 mt-lg-4">
                    <div class="row justify-content-end">
                        <div class="col-12">
                            <div class="card shadow-sm mb-3">
                                <div class="card-body d-lg-flex justify-content-lg-between align-items-center">
                                    <div class="mb-lg-0 mb-2">
                                        <div>
                                            Incoming Call Credits: {{ INR }}{{ auth()->user()->getWallet('call-wallet')->balanceFloat ?? '0' }}
                                        </div>
                                        <small class="text-muted">
                                            {{ INR }} {{ IN_CALL_CHARGE*2 }}/min for encrypted call <a href="{{ route('page.show', 'incoming-call-credits-usage') }}" target="_blank">Learn more</a>
                                            
                                        </small>
                                    </div>
                                    <a href="{{ route('account.call-logs.credit') }}">Add Credits</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @livewire('account.call-logs')
                </div>
            </div>
        </div>
    </div>
@endsection

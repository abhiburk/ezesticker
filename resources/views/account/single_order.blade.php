@extends('layouts.frontend.app')
@section('title', 'My Order: #' . $order->id)
@section('content')
    <div class="container-fluid ">
        <div class="container py-5" >
            <div class="row" >
                @include('account.sidebar')
                <div class="col-sm-12 col-lg-8 mt-4">
                    @if(isset($order->order_transaction->code->error) || $order->status == 'Failed')
                        <p class="alert alert-danger d-flex justify-content-between align-items-center"> 
                            <span>
                                <i class="bi bi-exclamation-triangle"></i>
                                <strong>{{ $order->order_transaction->code->error->description ?? 'Payment Failed/Aborted' }}</strong>
                            </span>
                            @if ($order->status == 'Failed' || $order->status == 'Pending')
                                @livewire('account.retry-payment', ['order' => $order])
                            @endif
                        </p>
                    @endif
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <strong>{!! $message !!}</strong>
                        </div>
                    @endif
                    {{-- @if ($message = Session::get('error'))
                        <div class="alert alert-danger">
                            <strong>{!! $message !!}</strong>
                        </div>
                    @endif --}}
                    <x-single_order :order="$order" :walletUsage="$wallet_usage"/>
                </div>
            </div>
        </div>
    </div>
@endsection

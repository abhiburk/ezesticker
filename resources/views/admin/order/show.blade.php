@extends('layouts.backend.app')
@section('title', 'View Order: '. request()->order->id)
@section('content')
<div class="container">
    <div class="row mt-4">
        <div class="col-lg-8 col-sm-12 mt-4">
            @isset($order->order_transaction->code->error)
                <p class="alert alert-danger"> 
                    {{ $order->order_transaction->code->error->description }}
                </p>
            @endisset
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            <x-single_order :order="$order" :walletUsage="$wallet_usage"/>
        </div>

        <div class="col-lg-4 col-sm-12 mt-4">
            @livewire('admin.order-status-changer', ['order' => $order])
        </div>
    </div>
</div>

@endsection

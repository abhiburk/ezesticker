@extends('layouts.frontend.app')
@section('title', 'Edit QR Sticker: ' . auth()->user()->name)
@section('content')
    <div class="container-fluid ">
        <div class="container py-5" >
            <div class="row" >
                @include('account.sidebar')
                <div class="col-sm-12 col-lg-8 mt-lg-4">
                    @livewire('account.qr-form', [ 'qr_detail' => $qr_detail ])
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        window.addEventListener('make-razorpay', e => {
            var options = {
                "key": "{{ env('RAZOR_KEY') }}", // Enter the Key ID generated from the Dashboard
                "amount": e.detail.amount, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                "currency": "INR",
                "order_id": e.detail.razorpay_order_id, //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
                "callback_url": "{{ route('razorpay.response') }}",
                "modal": {
                    "confirm_close": true,
                    "ondismiss": function(){
                        window.livewire.emit('handleRazorPayError', e.detail.razorpay_order_id); // listen in CheckoutSidebar.php
                    }
                }
            };
            var rzp1 = new Razorpay(options);
            rzp1.open();
            rzp1.on('payment.failed', function (response){
                window.livewire.emit('handleRazorPayError', response); // listen in CheckoutSidebar.php
            });
        });
    </script>
@endpush

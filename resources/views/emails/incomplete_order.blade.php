@component('mail::message')
# Hi {{ $order->user->name }}

It look's like you tried placing an order <b>#{{ $order->id }}</b> but could not complete it due to payment failure.

You can retry the payment from the below button.

@component('mail::button', ['url' => route('account.order.show', $order->id), 'color' => 'warning'])
Retry Payment
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
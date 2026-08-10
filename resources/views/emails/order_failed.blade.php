@component('mail::message')
# Hello

{{ $order->user->name }} failed to place an order with <b>#{{ $order->id }}</b>.

Please have a look the order details.

@component('mail::button', ['url' => route('order.show', $order->id), 'color' => 'warning'])
View Order
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
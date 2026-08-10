@component('mail::message')
# New Customer order

You have received an order from {{ $order->address->name }}. The order details are shown below for reference:

@component('mail::table')

| Product | Quantity | Price |
| :----: |:----:| :----: |
@forelse ($order->order_items as $item)
|{{ $item->name }}|{{ $item->quantity }}|{{ INR }}{{ $item->price }}
@empty 

@endforelse
||<b>Subtotal</b>|{{ INR }}{{$order->subtotal}}
||<b>Shipping</b>|{{ INR }}{{(int)SHIPPING_CHARGE}}
@if (!empty($order->discount))
||<b>Discount</b>|{{ INR }}{{$order->discount}}
@endif
||<b>Total</b>|<b>{{ INR }}{{$order->total}}</b>
@endcomponent

@component('mail::button', ['url' => route('order.show', $order->id), 'color' => 'warning'])
View Order
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
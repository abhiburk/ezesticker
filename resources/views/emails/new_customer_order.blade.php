@component('mail::message')
# Thank you for your order
Hi {{ $order->address->name }}

Your order has been received and is now being processed. Your order details are shown below for reference:

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

@component('mail::button', ['url' => route('account.order.show', $order->id), 'color' => 'warning'])
View Order
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
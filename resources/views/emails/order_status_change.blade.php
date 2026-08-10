@component('mail::message')
# Hi {{ $order->user->name }}

Your order status is changed to <b>{{ $order->status }}</b>.

@if ($order->status == 'Completed')
Thank you for purchasing ezesticker. We hope you loved it.

Please tag us with your ezesticker to our <a href="https://www.facebook.com/ezesticker">Facebook</a> and <a href="https://www.instagram.com/ezesticker">Instagram</a> handle.
@else 
{!! $content !!}
@endif

@component('mail::button', ['url' => route('order.show', $order->id), 'color' => 'warning'])
View Order
@endcomponent

Please write to us at <b>help@ezesticker.com</b> if you have any queries regarding the order, we will respond to you as soon as possible.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
@component('mail::message')
# Hi {{ $to->name }}

You have a new message from {{ $from->name }}
<p>
<i>{{ $message->message }}</i>
</p>

@component('mail::button', ['url' => route('account.message', Helper::encodeId($from->id)), 'color' => 'warning'])
View
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
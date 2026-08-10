@component('mail::message')
# Thanks for signing up, {{ $to->name }}. 
# We are glad you're here.

<div align="center" style="margin:50px;">
    <img src="{{ url('frontend/img/welcome_3gvl.svg') }}" style="width: 50%;" alt="Welcome to Ezesticker">
</div>

<p>
    You are now a part of a community that connects you for helping yourself.
    Ezesticker can be use at various situations. 
    Click the below button to see how it works !
</p>

@component('mail::button', ['url' => route('how-it-works'), 'color' => 'warning'])
How it Works
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
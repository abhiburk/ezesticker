@component('mail::message')
# Hello

Please use the verification code below to confirm your identity.
Verification Code 
# {{ $otp }}

If you did not request a otp request, no further action is required.

@component('mail::button', ['url' => route('login'), 'color' => 'warning'])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
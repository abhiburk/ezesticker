@component('mail::message')
# Hi

{{ $user->name }} invited you to join ezesticker.com. <br> 
Use the referral code <b>{{ $user->affiliate_id }}</b> and we will send you and your friend <b>{{ REFERRAL_COMMISION }}%</b> commission 
in wallet when you purchase and verify ezesticker.

@component('mail::button', ['url' => route('login'), 'color' => 'warning'])
Sign Up
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
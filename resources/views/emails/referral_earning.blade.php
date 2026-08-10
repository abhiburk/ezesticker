@component('mail::message')

# Hi {{ $beneficiary->name }}
@if($source == 'sender')
{{ $name }} successfully purchased and verified ezesticker after getting your referral code.
@else
Congratulations you have successfully linked your ezesticker with your mobile number through your friends referral code.        
@endif
To Thank you, we've awarded you {{ REFERRAL_COMMISION }}% commission in your wallet.

@component('mail::button', ['url' => route('account.wallet'), 'color' => 'warning'])
My Wallet
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
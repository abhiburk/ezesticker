@component('mail::message')
# Hi {{ $user->name}}

Please rate your experience with us about how do you feel using ezesticker service.

Click the link below to submit your honest feedback.

@component('mail::button', ['url' => route('feedback').'?source='. $source, 'color' => 'warning'])
Submit Feedback
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
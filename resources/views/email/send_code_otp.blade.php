@component('mail::message')
# {{ trans('log_res.otp_sent_from_instagram') }}
{{ trans('log_res.confirm_otp_sent_to_email') }} {{ $details['email'] }} :
@component('mail::panel')
{{ trans('log_res.otp') }} {{ $details['otp'] }}
@endcomponent
{{ trans('log_res.thank_you') }}
@endcomponent

@component('mail::message')
# @lang('dashboard::auth.password_subject')

@component('mail::button', ['url' => route('dashboard.password.set.index', [$params['token']])])
    {{ trans('dashboard::auth.reset') }}
@endcomponent

@lang('dashboard::auth.password_email_note')

<br>
@lang('emails.thanks'),
{!! config('app.name') !!}
@endcomponent

@extends('tpx_dashboard::layouts.auth')
@section('title', config('app.name') . ' - ' . trans('dashboard::auth.reset_title'))
@section('content')

    {!! BootForm::open()->post()->action(route('dashboard.password.reset.send'))->id('dashboard-auth-reset-password') !!}
        {{ csrf_field() }}

    {!! BootForm::email(trans('dashboard::auth.email'), 'email')->placeholder(trans('dashboard::auth.email'))->autofocus() !!}

    {!! BootForm::submit(trans('dashboard::auth.reset_password'), 'login')->addClass('btn btn-primary block full-width m-b') !!}

    <a href="{{ route('dashboard.login') }}"><small>{!!trans('dashboard::auth.login')!!}</small></a>

    {!! BootForm::close() !!}


@stop

@extends('tpx_dashboard::layouts.auth')
@section('title', config('app.name') . ' - ' . trans('dashboard::auth.reset_title'))
@section('content')

    {!! BootForm::open()->post()->action(route('dashboard.password.set.send', [$token]))->id('dashboard-auth-set-password') !!}
        {{ csrf_field() }}

    {!! BootForm::password('', 'password')->placeholder(trans('dashboard::auth.password')) !!}

    {!! BootForm::password('', 'password_confirmation')->placeholder(trans('dashboard::auth.confirm_password')) !!}

    {!! BootForm::submit(trans('dashboard::auth.save'), 'login')->addClass('btn btn-primary block full-width m-b') !!}

    <a href="{{ route('dashboard.login') }}"><small>{!!trans('dashboard::auth.login')!!}</small></a>

    {!! BootForm::close() !!}


@stop

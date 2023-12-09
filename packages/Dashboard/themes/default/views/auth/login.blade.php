@extends('tpx_dashboard::layouts.auth')
@section('title', config('app.name') . ' - ' . trans('dashboard::auth.sign_in'))
@section('content')

    {!! BootForm::open()->post()->action(route('dashboard.login.submit'))->id('dashboard-auth-login') !!}
        {{ csrf_field() }}

    {!! BootForm::email('Email', 'email')->placeholder(trans('dashboard::auth.email'))->autofocus() !!}
    {!! BootForm::password(trans('dashboard::auth.password'), 'password')->placeholder(trans('dashboard::auth.password')) !!}
    <div class="form-group">
        <div class="checkbox i-checks">
            <label> <input type="checkbox" name="remember"><i></i> {!!trans('dashboard::auth.remember_me')!!} </label>
        </div>
    </div>
    {!! BootForm::submit(trans('dashboard::auth.login'), 'login')->addClass('btn btn-primary block full-width m-b') !!}

    {!! BootForm::close() !!}

@stop

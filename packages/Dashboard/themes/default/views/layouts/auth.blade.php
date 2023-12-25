<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Packages">
    <title>@yield('title')</title>
    <link rel="icon" sizes="16x16" href="/images/favicon.png">
    <link href="/{{ config('tpx_dashboard.public_resources') }}/css/bootstrap.min.css" rel="stylesheet">
    <link href="/{{ config('tpx_dashboard.public_resources') }}/css/font-awesome.min.css" rel="stylesheet">
    <link href="/{{ config('tpx_dashboard.public_resources') }}/css/custom.css" rel="stylesheet">
    <link href="/{{ config('tpx_dashboard.public_resources') }}/css/animate.css" rel="stylesheet">
    <link href="/{{ config('tpx_dashboard.public_resources') }}/css/style.css" rel="stylesheet">
</head>
<style>
    .main-logo {
        position: relative;
        top: 3px;;
        font-family: 'Poppins';
        font-size: 26px;
        font-weight: bold;
    }

    .main-logo span {
        display: block;
        font-size: 14px;
        font-weight: normal;
        letter-spacing: 8.4px;
        position: relative;
        top: -3px;
    }
</style>

<body class="gray-bg">

<div class="middle-box text-center loginscreen  animated fadeInDown">
    <div>
        <div>
            <h1 class="logo-name main-logo">
                <a href="{{Route::has('home.page') ? route('home.page') : '/'}}">
                    @include('tpx_dashboard::partials._logo')
                </a>
            </h1>
        </div>

        @include('flash::message')

        <h3>{{ config('app.name') }}</h3>
        <br/>
        <br/>

        @yield('content')

        <p class="m-t"> <small>&copy; {!! date('Y') !!} <a href="/">{{ config('app.name') }}</a>. {!!trans('dashboard::auth.copyright')!!}</small> </p>

    </div>
</div>

<script src="/{{ config('tpx_dashboard.public_resources') }}/js/jquery-2.1.1.js"></script>
<script src="/{{ config('tpx_dashboard.public_resources') }}/js/bootstrap.min.js"></script>
<script src="/{{ config('tpx_dashboard.public_resources') }}/js/plugins/iCheck/icheck.min.js"></script>
<script>
    $(document).ready(function(){
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green'
        });
    });
</script>
</body>
</html>

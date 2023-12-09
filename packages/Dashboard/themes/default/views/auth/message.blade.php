@extends('tpx_dashboard::layouts.auth')
@section('title', config('app.name') . ' - ' . $title)
@section('content')
    <p>{!! $message !!}</p>
@stop

@extends('tpx_dashboard::layouts.master')

<?php

$action = request()->route()->getActionMethod();
$heading = [];
$heading['title'] = trans(Str::snake(request()->packageName)  . '::' . Str::snake(request()->modelName) . '.title.view');
if (isset($heading_right)) {
    $heading['heading_right'] = $heading_right;
}
?>

@include('tpx_dashboard::global.content-heading')

@section('content')

    <div class="wrapper wrapper-content">
        <div class="ibox float-e-margins">
            <div class="ibox-content shadowed">

                @include('flash::message')

                <div class="row">
                    <div class="col-lg-12">

                        @include('tpx_' . Str::snake(request()->packageName) . '::' . Str::snake(request()->modelName) . '.show')
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer-extras')
    @if (isset($scripts) && is_array($scripts))
        @foreach($scripts as $item)
            <script src="{{ $item }}"></script>
        @endforeach
    @endif
@endsection

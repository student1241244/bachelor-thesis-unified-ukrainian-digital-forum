@extends('tpx_dashboard::layouts.master')

<?php

$action = request()->route()->getActionMethod();
$heading = [];
$heading['title'] = trans(Str::snake(request()->packageName)  . '::' . Str::snake(request()->modelName) . '.title.' . $action);
?>

@include('tpx_dashboard::global.content-heading')

@section('content')

    @if(isset($locCfg['is_enabled_active_tab']) && $locCfg['is_enabled_active_tab'])
        <?php $activeTab = I18NHelper::getActiveTab($errors, $locCfg['locales']) ?>
    @endif

    <div class="wrapper wrapper-content">
        <div class="ibox float-e-margins">
            <div class="ibox-content shadowed">

                @include('flash::message')

                <div class="row">
                    <div class="col-lg-12">
                        @if($locCfg['is_enabled'])
                            @include('tpx_dashboard::global.language-tabs')
                        @endif

                        @include('tpx_' . Str::snake(request()->packageName) . '::' . Str::snake(request()->modelName) . '.form')
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('header-extras')
    @parent
    <link href="/{{ config('tpx_dashboard.public_resources') }}/redactor/redactor.min.css" rel="stylesheet">
    <link href="/{{ config('tpx_dashboard.public_resources') }}/css/plugins/drop-uploader/css/pe-icon-7-stroke.css" rel="stylesheet">
    <link href="/{{ config('tpx_dashboard.public_resources') }}/css/plugins/drop-uploader/css/drop_uploader.css" rel="stylesheet">
@stop

@section('footer-extras')
    @parent
    @include('tpx_dashboard::global.init-redactor',['id' => ['short_description', 'body']])
    @include('tpx_dashboard::dashboard.partials._uploader-modal-init')
@stop

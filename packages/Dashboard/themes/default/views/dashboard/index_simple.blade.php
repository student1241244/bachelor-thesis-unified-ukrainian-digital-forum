<?php
use Illuminate\Support\Str;

$routeCreate = Str::beforeLast(request()->route()->getName(), '.') . '.create';
$routeImport = Str::beforeLast(request()->route()->getName(), '.') . '.import';
$routeExport = Str::beforeLast(request()->route()->getName(), '.') . '.export';
?>

@extends('tpx_dashboard::layouts.master')
<?php

$heading = [];
$heading['title'] = isset($title)
    ? $title
    : trans(Str::snake(request()->packageName)  . '::' . Str::snake(request()->modelName) . '.title.index');

if (Route::has($routeCreate) && can($routeCreate)) {
    $heading['action_area'] = '<a href="' . route($routeCreate) . '" class="btn btn-primary"> ' . trans(Str::snake(request()->packageName)  . '::' . Str::snake(request()->modelName) . '.btn.add') . '</a>';
} elseif (can($routeCreate)) {
    $heading['action_area'] = '<a href="#" class="btn btn-primary js-add-'. Str::snake(request()->modelName) .'"> ' . trans(Str::snake(request()->packageName)  . '::' . Str::snake(request()->modelName) . '.btn.add') . '</a>';
}

$headingRightItems = [];
if (Route::has($routeImport) && can($routeImport)) {
    $headingRightItems[] = '<input type="button" class="btn btn-success" onclick="$(\'#modal-import\').modal(\'show\')" value="'.trans('dashboard::dashboard.import').'" />';
}
if (Route::has($routeExport) && can($routeExport) && !isset($hide_export_default)) {
    $headingRightItems[] = '<a href="'.route($routeExport).'" class="btn btn-success">'.trans('dashboard::dashboard.export').'</a>';
}

$heading['heading_right'] = isset($heading_right) ? $heading_right : implode(' ', $headingRightItems);
if (isset($row_before_table)) {
    $heading['heading_row_before_table'] = $row_before_table;
}
?>

@include('tpx_dashboard::global.content-heading')

@section('content')
    <div class="wrapper wrapper-content">
        <div class="ibox float-e-margins">
            <div class="ibox-content shadowed">
                @include('flash::message')
                @include('tpx_' . Str::snake($packageName ?? request()->packageName) . '::' . ($formView ?? Str::snake(request()->modelName) . '.form'))
            </div>
        </div>
    </div>
@endsection

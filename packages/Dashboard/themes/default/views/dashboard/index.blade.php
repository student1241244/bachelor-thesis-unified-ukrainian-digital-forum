<?php
use Illuminate\Support\Str;

$routeImport = Str::beforeLast(request()->route()->getName(), '.') . '.import';
$routeExport = Str::beforeLast(request()->route()->getName(), '.') . '.export';
?>

@extends('tpx_dashboard::layouts.master')
<?php

$heading = [];
$heading['title'] = isset($title)
    ? $title
    : trans(Str::snake(request()->packageName)  . '::' . Str::snake(request()->modelName) . '.title.index');

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
    <div class="ibox-content shadowed" style="margin-top: 20px;margin-left: 10px;">
    @include('tpx_' . Str::snake(request()->packageName) . '::' . Str::snake(request()->modelName) . '.index')
    </div>
    <style>
        .ag-action {
            margin-left: 5px;
        }
        tr .td-agrid-actions a {
            display: none;
        }
        tr:hover .td-agrid-actions a {
            display: inline-block;
        }

        .agrid input, .agrid select {
            font-weight: normal;

        }
    </style>
@endsection

@section('footer-extras')
    <script src="/vendor/dashboard/js/agrid.js"></script>
    <?php
    $flash = session()->get('flash_notification', collect([]))->first();
    ?>
    @if ($flash)
    <script>
        toastr.{{ $flash->level }}("{{ $flash->message }}")
    </script>
    @endif
@endsection

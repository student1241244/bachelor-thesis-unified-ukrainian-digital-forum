<?php
use Illuminate\Support\Str;

$routeCreate = Str::beforeLast(request()->route()->getName(), '.') . '.create';
$routeImport = Str::beforeLast(request()->route()->getName(), '.') . '.import';
$routeExport = Str::beforeLast(request()->route()->getName(), '.') . '.export';
$routeCreateParams = isset($routeCreateParams) ? $routeCreateParams : [];
?>

@extends('tpx_dashboard::layouts.master')
<?php

$heading = [];
$heading['title'] = isset($title)
    ? $title
    : trans(Str::snake(request()->packageName)  . '::' . Str::snake(request()->modelName) . '.title.index');

if (Route::has($routeCreate) && can($routeCreate)) {
    $heading['action_area'] = '<a href="' . route($routeCreate, $routeCreateParams) . '" class="btn btn-primary"> ' . trans(Str::snake(request()->packageName)  . '::' . Str::snake(request()->modelName) . '.btn.add') . '</a>';
} elseif (can($routeCreate)) {
    $heading['action_area'] = '<a href="#" class="btn btn-primary js-add-'. Str::snake(request()->modelName) .'"> ' . trans(Str::snake(request()->packageName)  . '::' . Str::snake(request()->modelName) . '.btn.add') . '</a>';
}

$headingRightItems = [];
if (Route::has($routeImport) && can($routeImport)) {
    $headingRightItems[] = '<input type="button" class="btn btn-success" onclick="$(\'#modal-import\').modal(\'show\')" value="'.trans('dashboard::dashboard.import').'" />';
}
if (Route::has($routeExport) && can($routeExport)) {
    $headingRightItems[] = '<a href="'.route($routeExport).'" class="btn btn-success">'.trans('dashboard::dashboard.export').'</a>';
}

$heading['heading_right'] = isset($heading_right) ? $heading_right : implode(' ', $headingRightItems);
if (isset($row_before_table)) {
    $heading['heading_row_before_table'] = $row_before_table;
}

?>

@include('tpx_dashboard::global.content-heading')

@section('header-extras')
    <link href="/{{ config('tpx_dashboard.public_resources') }}/css/data-tables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="/{{ config('tpx_dashboard.public_resources') }}/css/data-tables/dataTables.responsive.css" rel="stylesheet">
    @if(isset($reorder))
        <link href="/{{ config('tpx_dashboard.public_resources') }}/css/data-tables/rowReorder.bootstrap.min.css" rel="stylesheet">
    @endif
    @if(isset($dataTable) && $dataTable->withCheckboxes())
        <link href="/{{ config('tpx_dashboard.public_resources') }}/css/data-tables/dataTables.checkboxes.css" rel="stylesheet">
    @endif
@stop

@section('content')
    <div class="wrapper wrapper-content">
        <div class="ibox float-e-margins">
            <div class="ibox-content shadowed">
                @include('flash::message')

                @yield('content_index')

                @if (isset($dataTable))
                <form id="datatable-wrapper-form">
                    <div class="row">
                        <div class="col-lg-12 table-responsive table-hover">
                            {!! $dataTable->table(['class' =>'table table-striped dataTable no-footer table-hover']); !!}
                        </div>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
@endsection

@if (Route::has($routeImport) && can($routeImport))
<div id="modal-import" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{ trans('dashboard::dashboard.import') }}</h4>
            </div>
            <div class="modal-body">
                <form id="form-import" action="{{ route($routeImport) }}">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input type="file" class="form-control" name="file" id="import-file">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('dashboard::dashboard.cancel') }}</button>
                <button type="button" class="btn btn-secondary" id="btn-send-import">{{ trans('dashboard::dashboard.send') }}</button>
            </div>
        </div>

    </div>
</div>
@endif

@section('footer-extras')
    <script src="/{{ config('tpx_dashboard.public_resources') }}/js/data-tables/jquery.dataTables.min.js"></script>
    <script src="/{{ config('tpx_dashboard.public_resources') }}/js/data-tables/dataTables.bootstrap.min.js"></script>
    <script src="/{{ config('tpx_dashboard.public_resources') }}/js/data-tables/dataTables.responsive.min.js"></script>
    @if(isset($reorder))
        <script src="/{{ config('tpx_dashboard.public_resources') }}/js/data-tables/dataTables.rowReorder.min.js"></script>
    @endif
    @if(isset($dataTable) && $dataTable->withCheckboxes())
        <script src="/{{ config('tpx_dashboard.public_resources') }}/js/data-tables/dataTables.checkboxes.min.js"></script>
        {!! $dataTable->checkboxesScripts() !!}
    @endif

    @if (isset($dataTable))
    {!! $dataTable->scripts() !!}
    @endif

    @if (isset($scripts) && is_array($scripts))
        @foreach($scripts as $item)
            <script src="{{ $item }}"></script>
        @endforeach
    @endif

    @if(isset($reorder))
        <script>
            jQuery(document).ready(function ($) {
                var table = window.LaravelDataTables['{{ config('datatables-html.table.id') }}'];

                $('#{{ config('datatables-html.table.id') }}').addClass('dataTable-reorder');

                table.on('row-reorder', function (e, diff, edit) {
                    var jsonData = [];
                    var data = new FormData();

                    for (var i=0, ien = diff.length; i<ien; i++) {
                        var rowData = table.row( diff[i].node ).data();
                        jsonData.push({
                            id: rowData.id,
                            order: diff[i].newData
                        });
                    }

                    data.append('rows', JSON.stringify(jsonData));
                    data.append("_token", '{!!csrf_token()!!}');

                    $.ajax({
                        url: "{!! $reorder !!}",
                        dataType: "json",
                        cache: false,
                        contentType: false,
                        processData: false,
                        type: 'POST',
                        data: data,
                        success: function (resp) {
                            table.draw();
                        }
                    });
                });
            });
        </script>
    @endif

    <script>
        jQuery(document).ready(function ($) {
            $('.table').on('click', '.removal-confirmation-alert', function (e) {
                e.preventDefault();
                var link = $(this).attr('href');
                swal({
                        title: "{{trans('dashboard::dashboard.are_you_sure')}}",
                        text: "{{trans('dashboard::dashboard.no_recoverable')}}",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "{{trans('dashboard::dashboard.yes_delete')}}",
                        cancelButtonText: "{{trans('dashboard::dashboard.cancel')}}",
                        closeOnConfirm: false
                    },
                    function(){
                        let form = `<form id="form-destroy" action="${link}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('delete') }}
                                        <input type="submit" value="" />
                                    </form>`;
                        $('body').append(form);
                        $('#form-destroy').submit();
                    });
            });
        });
    </script>
@stop

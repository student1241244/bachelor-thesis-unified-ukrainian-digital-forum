<?php
use Illuminate\Database\Eloquent\Collection;

$action = $language->id ? route('dashboard.languages.update', [$language]) : route('dashboard.languages.store');
$labels = trans('dashboard::language.attributes');

?>

{!! BootForm::open()->action($action) !!}
 {!! BootForm::bind($language) !!}
    @method($language->id ? 'PUT' : 'POST')

    {!! BootForm::text(required_mark($labels['title']), 'title') !!}
    {!! BootForm::text(required_mark($labels['code']), 'code') !!}

    {!! BootForm::reset('<i class="fa fa-undo fa-fw"></i> ' . trans('dashboard::dashboard.reset'))->class('btn btn-sm btn-default') !!}
    {!! BootForm::submit('<i class="fa fa-save fa-fw"></i> ' . trans('dashboard::dashboard.save'))->class('btn btn-sm btn-success') !!}

{!! BootForm::close() !!}

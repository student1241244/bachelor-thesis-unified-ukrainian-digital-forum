<?php
$action = $category->id ? route('threads.categories.update', [$category]) : route('threads.categories.store');
$labels = trans('threads::category.attributes');
?>
{!! BootForm::open()
	->action($action)
	->multipart()
	->enctype('multipart/form-data')
!!}
	{!! BootForm::bind($category) !!}
	@method($category->id ? 'PUT' : 'POST')

	{!! BootForm::text($labels['title'], 'title') !!}

	{!! BootForm::reset('<i class="fa fa-undo fa-fw"></i> ' . trans('dashboard::dashboard.reset'))->class('btn btn-sm btn-default') !!}
	{!! BootForm::submit('<i class="fa fa-save fa-fw"></i> ' . trans('dashboard::dashboard.save'))->class('btn btn-sm btn-success') !!}

{!! BootForm::close() !!}


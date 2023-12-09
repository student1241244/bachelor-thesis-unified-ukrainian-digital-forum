<?php
$action = $warning->id ? route('warnings.warnings.update', [$warning]) : route('warnings.warnings.store');
$labels = trans('warnings::warning.attributes');
?>
{!! BootForm::open()
	->action($action)
	->multipart()
	->enctype('multipart/form-data')
!!}
	{!! BootForm::bind($warning) !!}
	@method($warning->id ? 'PUT' : 'POST')

	{!! BootForm::select($labels['user_id'], 'user_id', \Packages\Dashboard\App\Models\User::getList())->class('select2') !!}
	{!! BootForm::textarea($labels['body'], 'body') !!}

	{!! BootForm::reset('<i class="fa fa-undo fa-fw"></i> ' . trans('dashboard::dashboard.reset'))->class('btn btn-sm btn-default') !!}
	{!! BootForm::submit('<i class="fa fa-save fa-fw"></i> ' . trans('dashboard::dashboard.save'))->class('btn btn-sm btn-success') !!}

{!! BootForm::close() !!}


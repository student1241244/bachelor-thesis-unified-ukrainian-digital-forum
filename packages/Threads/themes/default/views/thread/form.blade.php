<?php
$action = $thread->id ? route('threads.threads.update', [$thread]) : route('threads.threads.store');
$labels = trans('threads::thread.attributes');
?>
{!! BootForm::open()
	->action($action)
	->multipart()
	->enctype('multipart/form-data')
!!}
	{!! BootForm::bind($thread) !!}
	@method($thread->id ? 'PUT' : 'POST')

	{!! BootForm::select($labels['category_id'], 'category_id', \Packages\Threads\App\Models\Category::getList())->class('select2') !!}

	@include('tpx_dashboard::dashboard.partials._file-upload', [
		'model' => $thread,
		'name' => 'image',
		'label' => $labels['image'],
		'accept' => 'image/*',
	])

	{!! BootForm::text($labels['title'], 'title') !!}
	{!! BootForm::textarea($labels['body'], 'body') !!}

	{!! BootForm::reset('<i class="fa fa-undo fa-fw"></i> ' . trans('dashboard::dashboard.reset'))->class('btn btn-sm btn-default') !!}
	{!! BootForm::submit('<i class="fa fa-save fa-fw"></i> ' . trans('dashboard::dashboard.save'))->class('btn btn-sm btn-success') !!}

{!! BootForm::close() !!}


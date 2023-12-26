<?php
$action = $question->id ? route('questions.questions.update', [$question]) : route('questions.questions.store');
$labels = trans('questions::question.attributes');
?>
{!! BootForm::open()
	->action($action)
	->multipart()
	->enctype('multipart/form-data')
!!}
	{!! BootForm::bind($question) !!}
	@method($question->id ? 'PUT' : 'POST')

	@include('tpx_dashboard::dashboard.partials._file-upload', [
		'model' => $question,
		'name' => 'images',
		'label' => $labels['images'],
		'accept' => 'image/*',
		'multiple' => true,
	])

	{!! BootForm::text($labels['user_id'], 'user_id')->value($question->user->email)->disabled() !!}
	{!! BootForm::text($labels['title'], 'title') !!}
	{!! BootForm::textarea($labels['body'], 'body') !!}

	{!! BootForm::reset('<i class="fa fa-undo fa-fw"></i> ' . trans('dashboard::dashboard.reset'))->class('btn btn-sm btn-default') !!}
	{!! BootForm::submit('<i class="fa fa-save fa-fw"></i> ' . trans('dashboard::dashboard.save'))->class('btn btn-sm btn-success') !!}

{!! BootForm::close() !!}


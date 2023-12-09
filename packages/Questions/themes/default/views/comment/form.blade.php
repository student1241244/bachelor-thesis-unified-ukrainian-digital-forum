<?php
$action = $comment->id ? route('questions.comments.update', [$comment]) : route('questions.comments.store');
$labels = trans('questions::comment.attributes');
?>
{!! BootForm::open()
	->action($action)
	->multipart()
	->enctype('multipart/form-data')
!!}
	{!! BootForm::bind($comment) !!}
	@method($comment->id ? 'PUT' : 'POST')

    {!! BootForm::text($labels['question_id'], 'question_id')->value($comment->question->title)->disabled() !!}
    {!! BootForm::text($labels['user_id'], 'user_id')->value($comment->user->email)->disabled() !!}
	{!! BootForm::textarea($labels['body'], 'body') !!}

	@include('tpx_dashboard::dashboard.partials._file-upload', [
		'model' => $comment,
		'name' => 'images',
		'label' => $labels['images'],
		'accept' => 'image/*',
		'multiple' => true,
	])


	{!! BootForm::reset('<i class="fa fa-undo fa-fw"></i> ' . trans('dashboard::dashboard.reset'))->class('btn btn-sm btn-default') !!}
	{!! BootForm::submit('<i class="fa fa-save fa-fw"></i> ' . trans('dashboard::dashboard.save'))->class('btn btn-sm btn-success') !!}

{!! BootForm::close() !!}


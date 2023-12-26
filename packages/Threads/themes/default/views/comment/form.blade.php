<?php
$action = $comment->id ? route('threads.comments.update', [$comment]) : route('threads.comments.store');
$labels = trans('threads::comment.attributes');
?>
{!! BootForm::open()
	->action($action)
	->multipart()
	->enctype('multipart/form-data')
!!}
	{!! BootForm::bind($comment) !!}
	@method($comment->id ? 'PUT' : 'POST')

	{!! BootForm::text($labels['thread_id'], 'thread_id')->value($comment->thread->title)->disabled() !!}
	{!! BootForm::textarea($labels['body'], 'body') !!}

	{!! BootForm::reset('<i class="fa fa-undo fa-fw"></i> ' . trans('dashboard::dashboard.reset'))->class('btn btn-sm btn-default') !!}
	{!! BootForm::submit('<i class="fa fa-save fa-fw"></i> ' . trans('dashboard::dashboard.save'))->class('btn btn-sm btn-success') !!}

{!! BootForm::close() !!}


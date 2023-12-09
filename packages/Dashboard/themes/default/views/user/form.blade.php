<?php
$action = $user->id ? route('dashboard.users.update', [$user]) : route('dashboard.users.store');
$labels = trans('dashboard::user.attributes');
?>

{!! BootForm::open()
        ->action($action)
        ->multipart()
        ->enctype('multipart/form-data')
!!}

 {!! BootForm::bind($user) !!}
    @method($user->id ? 'PUT' : 'POST')

    <!--
    @include('tpx_dashboard::dashboard.partials._file-upload', [
        'model' => $user,
        'name' => 'image',
        'label' => $labels['image'],
        'accept' => 'image/*',
    ])
    -->

    {!! BootForm::select(($labels['role_id']), 'role_id', \Packages\Dashboard\App\Models\Role::getList()) !!}
    {!! BootForm::text(($labels['username']), 'username') !!}
    {!! BootForm::text(($labels['email']), 'email') !!}
    {!! BootForm::text(($labels['ban_to']), 'ban_to')->class('datetimepicker form-control') !!}

    {!! BootForm::password(($labels['password']), 'password') !!}
    {!! BootForm::password(($labels['password_confirmation']), 'password_confirmation') !!}

    {!! BootForm::reset('<i class="fa fa-undo fa-fw"></i> ' . trans('dashboard::dashboard.reset'))->class('btn btn-sm btn-default') !!}
    {!! BootForm::submit('<i class="fa fa-save fa-fw"></i> ' . trans('dashboard::dashboard.save'))->class('btn btn-sm btn-success') !!}

{!! BootForm::close() !!}

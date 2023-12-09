<?php
$labels = trans('dashboard::user.attributes');
?>

<div class="row">
    <div class="col-lg-12">
        {!! BootForm::open()
                ->action(route('dashboard.account.update'))
                ->multipart()
                ->enctype('multipart/form-data')
        !!}

        {!! BootForm::bind($user) !!}
        @method('POST')

        <!--
        @include('tpx_dashboard::dashboard.partials._file-upload', [
            'model' => $user,
            'name' => 'image',
            'label' => $labels['image'],
            'accept' => 'image/*',
        ])
        -->

        {!! BootForm::text(required_mark($labels['username']), 'username', $user->username) !!}
        {!! BootForm::email(required_mark($labels['email']), 'email', $user->email) !!}

        {!! BootForm::reset('<i class="fa fa-undo fa-fw"></i> ' . trans('dashboard::dashboard.reset'))->class('btn btn-sm btn-default') !!}
        {!! BootForm::submit('<i class="fa fa-save fa-fw"></i> ' . trans('dashboard::dashboard.save'))->class('btn btn-sm btn-success') !!}

        {!! BootForm::close() !!}
    </div>
</div><br /><br />
<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header">{!! trans('dashboard::account.title.change_password') !!}</h2>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        {!! BootForm::open()->post()->action(route('dashboard.account.password')) !!}
        {!! BootForm::password(required_mark($labels['password']), 'password') !!}
        {!! BootForm::password(required_mark($labels['password_confirmation']), 'password_confirmation') !!}
        {!! BootForm::submit(trans('dashboard::account.btn.change_password'))->class('btn btn-sm btn-success') !!}
        {!! BootForm::close() !!}
    </div>
</div>


<?php
$labels = trans('clinics::clinic.attributes');
?>

<div class="row">
    <div class="col-lg-12">
        {!! BootForm::open()
                ->action(route('dashboard.clinic.update'))
                ->multipart()
                ->enctype('multipart/form-data')
        !!}

        {!! BootForm::bind($clinic) !!}
        @method('POST')

        @include('tpx_dashboard::dashboard.partials._file-upload', [
            'model' => $clinic,
            'name' => 'image',
            'label' => $labels['image'],
            'accept' => 'image/*',
        ])

        {!! BootForm::text(required_mark($labels['title']), 'title', $clinic->title) !!}

        {!! BootForm::reset('<i class="fa fa-undo fa-fw"></i> ' . trans('dashboard::dashboard.reset'))->class('btn btn-sm btn-default') !!}
        {!! BootForm::submit('<i class="fa fa-save fa-fw"></i> ' . trans('dashboard::dashboard.save'))->class('btn btn-sm btn-success') !!}

        {!! BootForm::close() !!}
    </div>
</div>

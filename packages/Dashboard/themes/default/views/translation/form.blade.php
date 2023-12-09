<?php
$action = $translation->id ? route('dashboard.translations.update', [$translation]) : route('dashboard.translations.store');
$labels = trans('dashboard::translation.attributes');
?>

{!! BootForm::open()
        ->action($action)
        ->multipart()
        ->enctype('multipart/form-data')
!!}

 {!! BootForm::bind($translation) !!}
    @method($translation->id ? 'PUT' : 'POST')

    {!! BootForm::text(($labels['group']), 'group')->disabled() !!}
    {!! BootForm::text(($labels['key']), 'key')->disabled() !!}

    <div class="tab-content">
        @foreach(config('translatable.locales') as $locale)
            <div id="tab-{{ $locale }}" class="tab-pane {{$activeTab == $locale ? 'active' : ''}}">
                {!! BootForm::textarea($labels['text'], "text[{$locale}]") !!}
            </div>
        @endforeach
    </div>


    {!! BootForm::reset('<i class="fa fa-undo fa-fw"></i> ' . trans('dashboard::dashboard.reset'))->class('btn btn-sm btn-default') !!}
    {!! BootForm::submit('<i class="fa fa-save fa-fw"></i> ' . trans('dashboard::dashboard.save'))->class('btn btn-sm btn-success') !!}

{!! BootForm::close() !!}

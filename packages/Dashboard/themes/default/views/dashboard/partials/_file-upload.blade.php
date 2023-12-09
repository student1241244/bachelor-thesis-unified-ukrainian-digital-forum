@php
    /** @var Packages\Dashboard\App\Models\Media $media */
    $collection = $collection ?? $name;
    $conversion = $conversion ?? '';
    $filenames = $filenames ?? false;

    $isSiteSettings = $model instanceof Packages\Settings\App\Models\Value;
    $tooltips = $model->getMediaTooltips($collection);
@endphp
<div class="form-group upload-wrapper" id="upload_wrapper_{{$name}}">

    @if($label)
        <label class="control-label" >{{$label}}</label>
    @endif

    <div class="previews {{$filenames ? 'with-filenames' : ''}}">
        @forelse($model->getMedia($collection) as $media)
            <div class="file-wrapper">
                @if(!$media->isImage() && !$isSiteSettings)
                    <div
                            data-delete
                            data-del-url="{{route('dashboard.media.delete', $media)}}"
                            title="{{ trans('dashboard::dashboard.delete') }}"
                            data-default="{!! $model->getImage('_default', '100x100') !!}"
                            class="thumbnail file-preview">
                        <i class="fa fa-{{$media->getFontAwesomeClass()}}"></i>
                    </div>
                    @if ($model->getMediaUrl($collection))
                        <a href="{{ $model->getMediaUrl($collection) }}" target="_blank">Download</a>
                    @endif

                @elseif($isSiteSettings && $model->type=='file')
                    <img src="{{$model->getFile($collection)}}"
                         data-delete
                         data-del-url="{{route('dashboard.media.delete', $media)}}"
                         data-default="{!! $model->getFile('_default') !!}"
                         title="{{ trans('dashboard::dashboard.delete') }}" />
                    @if ($model->getMediaUrl($collection))
                        <a href="{{ $model->getMediaUrl($collection) }}" target="_blank">Download</a>
                    @endif


                @else
                    <img src="{{$media->getUrl($conversion)}}"
                         data-delete
                         data-del-url="{{route('dashboard.media.delete', $media)}}"
                         data-default="{!! $model->getImage('_default', '100x100') !!}"
                         title="{{ trans('dashboard::dashboard.delete') }}" />



                @endif
                @if($filenames)
                    <span class="title" title="{{$media->full_name}}">{{$media->full_name}}</span>
                @endif
            </div>
        @empty
            <div class="file-wrapper">
                @if($isSiteSettings && $model->type=='file')
                    <img src="{!! $model->getFile('_default') !!}" class="img-placeholder" />
                @else
                    @if ($isSiteSettings)
                        <img src="{!! settings_image($collection) !!}" class="img-placeholder" />
                    @else
                        <img src="{!! $model->getImage('_default', '100x100') !!}" class="img-placeholder" />
                    @endif
                @endif
            </div>
        @endforelse
    </div>

    <div class="inputs"></div>

    <button type="button" class="btn btn-upload"
            data-toggle="modal" data-target="#uploadModal"
            data-name="{{$field ?? $name}}"
            data-collection="{{$collection}}"
            data-wrapper-name="{{$name}}"
            {!! !empty($label)        ? ' data-label="' . $label . '"'               : ' data-label="' . trans('dashboard::dashboard.upload') . '"' !!}
            {!! !empty($accept)       ? ' data-accept="' . $accept . '"'              : '' !!}
            {!! !empty($method)       ? ' data-method="' . $method . '"'              : '' !!}
            {!! !empty($maxfilesize)  ? ' data-maxfilesize="' . $maxfilesize . '"'    : '' !!}
            {!! !empty($layout)       ? ' data-layout="' . $layout . '"'              : '' !!}
            {!! !empty($count)        ? ' data-count="' .$count . '"'                 : '' !!}
            {!! !empty($multiple)     ? ' data-multiple="on"'                         : '' !!}>
        <i class="fa fa-upload" aria-hidden="true"></i> {{ trans('dashboard::dashboard.upload') }}</button>

    <button type="button" data-cancel="off" class="btn btn-danger">
        <i class="fa fa-times" aria-hidden="true"></i> {{ trans('dashboard::dashboard.cancel') }}
    </button>

    @if ($errors->has($collection))
        <div class="alert alert-danger">
            {{ $errors->first($collection) }}
        </div>
    @endif

</div>

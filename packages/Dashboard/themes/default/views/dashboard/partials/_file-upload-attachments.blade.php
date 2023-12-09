@php
    /** @var Packages\Dashboard\App\Models\Media $media */
    $collection = $collection ?? $name;
    $conversion = $conversion ?? '';
    $filenames = $filenames ?? false;
@endphp
<div class="form-group upload-wrapper" id="upload_wrapper_{{$name}}">

    @if($label)
        <label class="control-label" >{{$label}}</label>
    @endif

    <div class="previews {{$filenames ? 'with-filenames' : ''}}">
        @forelse($model->getMedia($collection) as $media)
            <div class="file-wrapper">
                    <img src="/vendor/dashboard/images/100x100.jpg"
                         data-delete
                         data-del-url="{{route('dashboard.media.delete', $media)}}"
                         data-default="{!! $model->getFile('_default') !!}"
                          title="{{ trans('dashboard::dashboard.delete') }}" />
                <span>{{ $media->full_name }}</span>
             </div>
        @empty
            <div class="file-wrapper">
                    <img src="/vendor/dashboard/images/100x100.jpg" class="img-placeholder" />
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
</div>


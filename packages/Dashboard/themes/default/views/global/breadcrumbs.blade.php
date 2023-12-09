<?php
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;

$routeCreate = Str::afterLast(request()->route()->getName(), '.') === 'index' ? Str::beforeLast(request()->route()->getName(), '.') . '.create' : null;

$menuItem  = (new \Packages\Dashboard\App\Services\Config\ConfigService)->getActiveMenuItem(request()->packageName, request()->modelName);
$titleIcon = array_get($menuItem, 'icon');
$iconColor = array_get($menuItem, 'color');


?>

@if (count($breadcrumbs))
    <ol class="breadcrumb">
        @foreach ($breadcrumbs as $breadcrumb)

            @if ($breadcrumb->url && !$loop->last)
                <li><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a> <i class="icon ion-ios-arrow-forward"></i> </li>
            @else
                <li>
                    <i class="{{$titleIcon}}" {!! $iconColor ? 'style="color:' .$iconColor.';"': '' !!}></i>
                    {{ $breadcrumb->title }}

                    <span style="margin-left: 20px;">
                    @if (Route::has($routeCreate) && can($routeCreate))
                        <a href="{{ route($routeCreate) }}" class="btn btn-xs btn-add">+</a>
                    @endif
                    </span>
                </li>
            @endif

        @endforeach
    </ol>
@endif

<style>
    .btn-add {
        background: #27AE60;
        border-color: #27AE60;
        box-shadow: 0px 0px 0px 1px #26a75b;
        color: #fff !important;
    }
</style>

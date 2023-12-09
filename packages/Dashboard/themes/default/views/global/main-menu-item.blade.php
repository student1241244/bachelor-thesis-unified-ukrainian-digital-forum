<?php
$isActive = NavHelper::isActive($item);
$icon = $item['icon'] ?? null;
$color = $item['color'] ?? null;
?>

@if(can($item['route']))
    <li class="{{ $isActive ? 'active' : '' }} {{$icon ? 'with-icon' : ''}}" {!! ($isActive && $color) ? 'style="border-color: '.$color.'"': '' !!}>
        @if(isset($item['children']))
            <a href="#">
                @if($icon)
                    <i class="fa {{ $icon }}" {!! $color ? 'style="color: '.$color.';"' : '' !!}></i>
                @endif
                <span class="nav-label">{!! !substr_count($item['title'], '::') ? $item['title'] : trans($item['title']) !!}</span>
                <span class="fa arrow"></span>
            </a>
            <ul class="nav nav-second-level">
                @foreach($item['children'] AS $child)
                    @include('tpx_dashboard::global.main-menu-item', ['item' => $child, 'firstLvl' => false])
                @endforeach
            </ul>
        @else
            <a href="{{ $item['url'] }}">
                @if($icon)
                    <i class="fa {{ $icon }}" {!! $color ? 'style="color: '.$color.';"' : '' !!}></i>
                @endif
                @if($firstLvl)
                    <span class="nav-label">{!! !substr_count($item['title'], '::') ? $item['title'] :  trans($item['title']) !!}</span>
                @else
                    {!! trans($item['title']) !!}
                @endif

                @if (!empty($item['badge']))
                    <sup id="badge-{{ $item['badge']['id'] }}" class="js-menu-badge" class="hidden"><span class="badge badge-not-read"></span></sup>
                @endif

            </a>
        @endif
    </li>
@endif

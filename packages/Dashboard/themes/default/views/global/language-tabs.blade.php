<?php
$list = \Packages\Dashboard\App\Models\Language::getList();
?>

@if (count($list) > 1 && isset($activeTab))
    <ul class="nav nav-tabs">
        @foreach($list as $locale => $title)
            <li class="{{$activeTab == $locale ? 'active' : ''}}">
                <a data-toggle="tab"
                   href="#tab-{{ $tabPrefix ?? '' }}{{ $locale }}">{!! $title !!}</a>
            </li>
        @endforeach
    </ul>
    <br/>
@endif

<ul class="nav navbar-top-links navbar-right">
    <li>
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <img src="{!! auth()->user()->avatar !!}" style="height: 40px; border-radius: 50%;">
            </a>
            <ul class="dropdown-menu m-t-xs">
                <li><a href="{{ route('dashboard.logout') }}">{!! trans('dashboard::auth.logout') !!}</a></li>
            </ul>
    </li>
</ul>
<ul class="nav navbar-top-links navbar-right">
    <li>
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <img src="{!! auth()->user()->getImage('image', '100x100') !!}" style="height: 40px; border-radius: 50%;">
            </a>
            <ul class="dropdown-menu m-t-xs">
                <li><a href="{{ route('dashboard.account.edit') }}">{!! trans('dashboard::auth.edit_profile') !!}</a></li>
                <li class="divider"></li>
                <li><a href="{{ route('dashboard.logout') }}">{!! trans('dashboard::auth.logout') !!}</a></li>
            </ul>
    </li>
</ul>

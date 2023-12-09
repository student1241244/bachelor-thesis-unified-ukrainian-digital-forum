<div class="row border-bottom">
    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0; {{request()->routeIs('dashboard.index') ? 'background: white;' : '' }}">
        @include('tpx_dashboard::global.navbar-header')
        @include('tpx_dashboard::global.navbar-toplinks')
    </nav>
</div>

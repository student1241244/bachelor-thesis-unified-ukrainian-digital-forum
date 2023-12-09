<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="side-menu" data-url="{{ \Illuminate\Support\Facades\Route::has('dashboard.counters') ? route('dashboard.counters') : '' }}">
            <?php $firstLvl = true;?>
            @foreach((new \Packages\Dashboard\App\Services\Config\ConfigService)->getNavigation() as $item)
                @include('tpx_dashboard::global.main-menu-item', compact('item', 'firstLvl'))
            @endforeach
        </ul>
    </div>
</nav>

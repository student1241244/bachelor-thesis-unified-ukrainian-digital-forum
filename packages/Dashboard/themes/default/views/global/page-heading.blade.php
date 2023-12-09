<div class="row wrapper page-heading">
    @yield('page_heading_top')
    <div class="col-sm-6">
        <h2>@yield('main_title')</h2>
        <div class="title-action">
            @yield('action_area')
        </div>
    </div>
    <div class="col-sm-6 text-right">
        @yield('heading_right')
    </div>
    @yield('page_heading_bottom')
</div>

@yield('heading_row_before_table')

<!DOCTYPE html>
<html>
<head>
    @include('tpx_dashboard::global.head')
    @yield('header-extras')
</head>
<body>
<div id="wrapper">
    @include('tpx_dashboard::global.main-menu')
    <div id="page-wrapper" class="gray-bg dashbard-1">

        @include('tpx_dashboard::global.nav')

        <div class="row">
            <div class="col-lg-12">
                @yield("content")
            </div>
        </div>

        @include('tpx_dashboard::global.footer')

    </div>
</div>

<div id="modal-content"
     class="modal fade"
     role="dialog"
>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: none">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body"></div>
        </div>

    </div>
</div>


@include('tpx_dashboard::global.footer-scripts')
<script>
    window._token = '{{ csrf_token() }}';
    if ($('#side-menu li li.active').length) {
        $('#side-menu li li.active').closest('li').addClass('active');
        $('#side-menu li li.active').closest('.nav').attr('class', 'nav nav-second-level collapse in');
    }
</script>
@yield("footer-extras")
@yield("modals")
</body>
</html>

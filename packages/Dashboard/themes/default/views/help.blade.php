@extends('tpx_dashboard::layouts.master')
@include('tpx_dashboard::global.content-heading')
@section('content')

    <div class="wrapper wrapper-content">
        <div class="ibox float-e-margins">
            <div class="ibox-content shadowed">
                <h3>@lang('dashboard::dashboard.help_video.login')</h3>
                <video src="/media/help/01.admin_log_in.mp4" controls></video>
                <br>
                <br>
                <br>

                <h3>@lang('dashboard::dashboard.help_video.inbox')</h3>
                <video src="/media/help/02.inbox.mp4" controls></video>
                <br>
                <br>
                <br>

                <h3>@lang('dashboard::dashboard.help_video.news')</h3>
                <video src="/media/help/03.news.mp4" controls></video>
                <br>
                <br>
                <br>

                <h3>@lang('dashboard::dashboard.help_video.static_pages')</h3>
                <video src="/media/help/04.static_pages.mp4" controls></video>
                <br>
                <br>
                <br>

                <h3>@lang('dashboard::dashboard.help_video.services')</h3>
                <video src="/media/help/05.services.mp4" controls></video>
                <br>
                <br>
                <br>

                <h3>@lang('dashboard::dashboard.help_video.products')</h3>
                <video src="/media/help/06.products.mp4" controls></video>
                <br>
                <br>
                <br>

                <h3>@lang('dashboard::dashboard.help_video.certificates')</h3>
                <video src="/media/help/07.certificates.mp4" controls></video>
                <br>
                <br>
                <br>

                <h3>@lang('dashboard::dashboard.help_video.vacancies')</h3>
                <video src="/media/help/08.vacancies.mp4" controls></video>
                <br>
                <br>
                <br>

                <h3>@lang('dashboard::dashboard.help_video.users')</h3>
                <video src="/media/help/09.users.mp4" controls></video>
                <br>
                <br>
                <br>

                <h3>@lang('dashboard::dashboard.help_video.mails')</h3>
                <video src="/media/help/10.mails.mp4" controls></video>

            </div>
        </div>
    </div>
@endsection

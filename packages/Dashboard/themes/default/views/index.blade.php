@extends('tpx_dashboard::layouts.master')
@section('title', trans('dashboard::dashboard.dashboard'))
@section('content')
    <div class="wrapper wrapper-content">


        <div class="row">

            <?php /*
                <div class="col-lg-4">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">{{trans('dashboard::dashboard.active')}}</span>
                            <h5>{{trans('dashboard::dashboard.users')}}</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins">{!!$activeUsers!!}</h1>
                            <div class="stat-percent font-bold text-info">{!!$users!!} <i class="fa fa-user" aria-hidden="true"></i></div>
                            <small>{{trans('dashboard::dashboard.total')}}</small>
                        </div>
                    </div>
                </div>



                <div class="col-lg-4 float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-danger pull-right">{{trans('dashboard::dashboard.new')}}</span>
                            <h5>{{trans('dashboard::dashboard.support')}}</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins">{!!$contacts->where('is_viewed', false)->count()!!}</h1>
                            <div class="stat-percent font-bold text-danger">{!!$contacts->count()!!} <i class="fa fa-envelope"></i></div>
                            <small>{{trans('dashboard::dashboard.total')}}</small>
                        </div>
                    </div>
                </div>
            */ ?>

        </div>


    </div>
@endsection

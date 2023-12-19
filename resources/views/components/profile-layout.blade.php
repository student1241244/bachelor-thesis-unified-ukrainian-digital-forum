<x-standard-layout-qa>
    <!--======================================
            START HERO AREA
    ======================================-->
    <section class="hero-area bg-white shadow-sm overflow-hidden pt-60px">
        <span class="stroke-shape stroke-shape-1"></span>
        <span class="stroke-shape stroke-shape-2"></span>
        <span class="stroke-shape stroke-shape-3"></span>
        <span class="stroke-shape stroke-shape-4"></span>
        <span class="stroke-shape stroke-shape-5"></span>
        <span class="stroke-shape stroke-shape-6"></span>
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="hero-content">
                        <div class="float-left">
                            <div class="media media-card align-items-center shadow-none p-0 mb-0 rounded-0 bg-transparent">
                                <div class="media-img media--img">
                                    <img src="{{$sharedData['avatar']}}" alt="avatar">
                                </div>
                                <div class="media-body">
                                    <h5>{{$sharedData['username']}}</h5>
                                    <div class="stats fs-14 fw-medium d-flex align-items-center lh-18">
                                        <span class="text-black pr-2" title="Reputation">Bonus points: </span>
                                        <span class="pr-2 d-inline-flex align-items-center" title="Gold"><span class="ball ml-1 gold"></span>{{ $sharedData['bonus_points'] }}</span>
                                    </div>
                                </div>
                            </div><!-- end media -->
                        </div>
                        @if(isset(auth()->user()->username) == $sharedData['username'])
                        <div class="float-right">
                            <div class="hero-btn-box text-right py-3">
                                <a href="/profile-settings" class="btn theme-btn theme-btn-outline theme-btn-outline-gray"><i class="la la-gear mr-1"></i> Edit Profile</a>
                            </div>
                        </div>
                        @endif
                    </div><!-- end hero-content -->
                </div><!-- end col-lg-8 -->
                <div class="col-lg-12">
                    <ul class="nav nav-tabs generic-tabs generic--tabs generic--tabs-2 mt-4" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="user-profile-tab" data-toggle="tab" href="#user-profile" role="tab" aria-controls="user-profile" aria-selected="true">Profile</a>
                        </li>
                    </ul>
                </div><!-- end col-lg-4 -->
            </div><!-- end row -->
        </div><!-- end container -->
    </section>
    <!--======================================
            END HERO AREA
    ======================================-->

    @include('warnings')

    <div class="profile-slot-content">

        {{$slot}}
    </div>
</x-standard-layout-qa>

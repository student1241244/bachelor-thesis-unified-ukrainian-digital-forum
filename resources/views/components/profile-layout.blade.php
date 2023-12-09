<x-standard-layout>
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
                                    <small class="meta d-block lh-20 pb-2">
                                        <span>United States, member since 11 years ago</span>
                                    </small>
                                    <div class="stats fs-14 fw-medium d-flex align-items-center lh-18">
                                        <span class="text-black pr-2" title="Reputation">224,110</span>
                                        <span class="pr-2 d-inline-flex align-items-center" title="Gold"><span class="ball ml-1 gold"></span>16</span>
                                        <span class="pr-2 d-inline-flex align-items-center" title="Silver"><span class="ball ml-1 silver"></span>93</span>
                                        <span class="pr-2 d-inline-flex align-items-center" title="Bronze"><span class="ball ml-1"></span>136</span>
                                    </div>
                                </div>
                                @auth
                                @if(!$sharedData['currentlyFollowing'] AND auth()->user()->username != $sharedData['username'])
                                <div>
                                    <form action="/follow/{{$sharedData['username']}}" method="POST">
                                        @csrf
                                        <button type="submit">Follow</button>
                                    </form>
                                </div>
                                @endif

                                @if($sharedData['currentlyFollowing'])
                                <div>
                                    <form action="/unfollow/{{$sharedData['username']}}" method="POST">
                                        @csrf
                                        <button type="submit">Unfollow</button>
                                    </form>
                                </div>
                                @endif
                                @endauth
                            </div><!-- end media -->
                        </div>
                        @if(auth()->user()->username == $sharedData['username'])
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
                        <li class="nav-item">
                            <a class="nav-link" id="user-activity-tab" data-toggle="tab" href="#user-activity" role="tab" aria-controls="user-activity" aria-selected="false">Activity</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="user-questions-tab" data-toggle="tab" href="#user-questions" role="tab" aria-controls="user-questions" aria-selected="false">Questions</a>
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
</x-standard-layout>

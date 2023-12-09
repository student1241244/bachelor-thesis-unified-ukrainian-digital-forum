<x-standard-layout>
    <!-- ================================
         START QUESTION AREA
================================= -->
<section class="question-area pt-40px">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="question-main-bar pb-45px">
                    <div class="filters pb-4">
                        <div class="d-flex flex-wrap align-items-center justify-content-between pb-3">
                            <h3 class="fs-22 fw-medium">All Questions</h3>
                            <a href="/ask-question" class="btn theme-btn theme-btn-sm">Ask Question</a>
                        </div>
                        <div class="d-flex flex-wrap align-items-center justify-content-between">
                            <p class="pt-1 fs-15 fw-medium lh-20">{{ $count }} questions</p>
                            <div class="filter-option-box w-10">
                                <select class="custom-select">
                                    <option value="newest" selected="selected">Newest </option>
                                    <option value="featured">Bountied (390)</option>
                                    <option value="frequent">Frequent </option>
                                    <option value="votes">Votes </option>
                                    <option value="active">Active </option>
                                    <option value="unanswered">Unanswered </option>
                                </select>
                            </div><!-- end filter-option-box -->
                        </div>
                    </div><!-- end filters -->
                    @unless($questions->isEmpty())
                    <div class="questions-snippet border-top border-top-gray">
                    @foreach($questions as $question)
                        <div class="media media-card rounded-0 shadow-none mb-0 bg-transparent py-3 px-0 border-bottom border-bottom-gray">
                            <div class="votes text-center votes-2">
                                <div class="vote-block">
                                    <span class="vote-counts d-block text-center pr-0 lh-20 fw-medium">3</span>
                                    <span class="vote-text d-block fs-13 lh-18">votes</span>
                                </div>
                                <div class="answer-block answered my-2">
                                    <span class="answer-counts d-block lh-20 fw-medium">3</span>
                                    <span class="answer-text d-block fs-13 lh-18">answers</span>
                                </div>
                                <div class="view-block">
                                    <span class="view-counts d-block lh-20 fw-medium">12</span>
                                    <span class="view-text d-block fs-13 lh-18">views</span>
                                </div>
                            </div>
                            <div class="media-body">
                                <h5 class="mb-2 fw-medium"><a href="/question-details/{{$question->id}}">{{$question->title}}</a></h5>
                                <p class="mb-2 truncate lh-20 fs-15">{{$question->body}}</p>
                                <div class="tags">
                                    <a href="#" class="tag-link">javascript</a>
                                    <a href="#" class="tag-link">bootstrap-4</a>
                                    <a href="#" class="tag-link">jquery</a>
                                    <a href="#" class="tag-link">select</a>
                                </div>
                                <div class="media media-card user-media align-items-center px-0 border-bottom-0 pb-0">
                                    <a href="user-profile.html" class="media-img d-block">
                                        <img src="{{$question->user->avatar}}" alt="avatar">
                                    </a>
                                    <div class="media-body d-flex flex-wrap align-items-center justify-content-between">
                                        <div>
                                            <h5 class="pb-1"><a href="user-profile.html">{{$question->user->username}}</a></h5>
                                            <div class="stats fs-12 d-flex align-items-center lh-18">
                                                <span class="text-black pr-2" title="Reputation score">224</span>
                                                <span class="pr-2 d-inline-flex align-items-center" title="Gold badge"><span class="ball gold"></span>16</span>
                                                <span class="pr-2 d-inline-flex align-items-center" title="Silver badge"><span class="ball silver"></span>93</span>
                                                <span class="pr-2 d-inline-flex align-items-center" title="Bronze badge"><span class="ball"></span>136</span>
                                            </div>
                                        </div>
                                        <small class="meta d-block text-right">
                                            <span class="text-black d-block lh-18">created</span>
                                            <span class="d-block lh-18 fs-12">{{$question->created_at->format('n/j/Y')}}</span>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end media -->
                    @endforeach
                    </div><!-- end questions-snippet -->
                    <div class="pager pt-30px px-3">
                    {{$questions->links()}}
                    </div>
                    @else
                    @endunless
                </div><!-- end question-main-bar -->
            </div><!-- end col-lg-9 -->
            <div class="col-lg-3">
                <div class="sidebar">
                    <div class="card card-item">
                        <div class="card-body">
                            <h3 class="fs-17 pb-3">Related Questions</h3>
                            <div class="divider"><span></span></div>
                            <div class="sidebar-questions pt-3">
                                <div class="media media-card media--card media--card-2">
                                    <div class="media-body">
                                        <h5><a href="question-details.html">Using web3 to call precompile contract</a></h5>
                                        <small class="meta">
                                            <span class="pr-1">2 mins ago</span>
                                            <span class="pr-1">. by</span>
                                            <a href="#" class="author">Sudhir Kumbhare</a>
                                        </small>
                                    </div>
                                </div><!-- end media -->
                                <div class="media media-card media--card media--card-2">
                                    <div class="media-body">
                                        <h5><a href="question-details.html">Is it true while finding Time Complexity of the algorithm [closed]</a></h5>
                                        <small class="meta">
                                            <span class="pr-1">48 mins ago</span>
                                            <span class="pr-1">. by</span>
                                            <a href="#" class="author">wimax</a>
                                        </small>
                                    </div>
                                </div><!-- end media -->
                                <div class="media media-card media--card media--card-2">
                                    <div class="media-body">
                                        <h5><a href="question-details.html">image picker and store them into firebase with flutter</a></h5>
                                        <small class="meta">
                                            <span class="pr-1">1 hour ago</span>
                                            <span class="pr-1">. by</span>
                                            <a href="#" class="author">Antonin gavrel</a>
                                        </small>
                                    </div>
                                </div><!-- end media -->
                            </div><!-- end sidebar-questions -->
                        </div>
                    </div><!-- end card -->
                    <div class="card card-item">
                        <div class="card-body">
                            <h3 class="fs-17 pb-3">Related Tags</h3>
                            <div class="divider"><span></span></div>
                            <div class="tags pt-4">
                                <div class="tag-item">
                                    <a href="#" class="tag-link tag-link-md">analytics</a>
                                    <span class="item-multiplier fs-13">
                                    <span>×</span>
                                    <span>32924</span>
                                </span>
                                </div><!-- end tag-item -->
                                <div class="tag-item">
                                    <a href="#" class="tag-link tag-link-md">computer</a>
                                    <span class="item-multiplier fs-13">
                                    <span>×</span>
                                    <span>32924</span>
                                </span>
                                </div><!-- end tag-item -->
                                <div class="tag-item">
                                    <a href="#" class="tag-link tag-link-md">python</a>
                                    <span class="item-multiplier fs-13">
                                    <span>×</span>
                                    <span>32924</span>
                                </span>
                                </div><!-- end tag-item -->
                                <div class="tag-item">
                                    <a href="#" class="tag-link tag-link-md">javascript</a>
                                    <span class="item-multiplier fs-13">
                                    <span>×</span>
                                    <span>32924</span>
                                </span>
                                </div><!-- end tag-item -->
                                <div class="tag-item">
                                    <a href="#" class="tag-link tag-link-md">c#</a>
                                    <span class="item-multiplier fs-13">
                                    <span>×</span>
                                    <span>32924</span>
                                </span>
                                </div><!-- end tag-item -->
                                <div class="collapse" id="showMoreTags">
                                    <div class="tag-item">
                                        <a href="#" class="tag-link tag-link-md">java</a>
                                        <span class="item-multiplier fs-13">
                                    <span>×</span>
                                    <span>32924</span>
                                </span>
                                    </div><!-- end tag-item -->
                                    <div class="tag-item">
                                        <a href="#" class="tag-link tag-link-md">swift</a>
                                        <span class="item-multiplier fs-13">
                                    <span>×</span>
                                    <span>32924</span>
                                </span>
                                    </div><!-- end tag-item -->
                                    <div class="tag-item">
                                        <a href="#" class="tag-link tag-link-md">html</a>
                                        <span class="item-multiplier fs-13">
                                    <span>×</span>
                                    <span>32924</span>
                                </span>
                                    </div><!-- end tag-item -->
                                    <div class="tag-item">
                                        <a href="#" class="tag-link tag-link-md">angular</a>
                                        <span class="item-multiplier fs-13">
                                    <span>×</span>
                                    <span>32924</span>
                                </span>
                                    </div><!-- end tag-item -->
                                    <div class="tag-item">
                                        <a href="#" class="tag-link tag-link-md">flutter</a>
                                        <span class="item-multiplier fs-13">
                                    <span>×</span>
                                    <span>32924</span>
                                </span>
                                    </div><!-- end tag-item -->
                                    <div class="tag-item">
                                        <a href="#" class="tag-link tag-link-md">machine-language</a>
                                        <span class="item-multiplier fs-13">
                                    <span>×</span>
                                    <span>32924</span>
                                </span>
                                    </div><!-- end tag-item -->
                                </div><!-- end collapse -->
                                <a class="collapse-btn fs-13" data-toggle="collapse" href="#showMoreTags" role="button" aria-expanded="false" aria-controls="showMoreTags">
                                    <span class="collapse-btn-hide">Show more<i class="la la-angle-down ml-1 fs-11"></i></span>
                                    <span class="collapse-btn-show">Show less<i class="la la-angle-up ml-1 fs-11"></i></span>
                                </a>
                            </div>
                        </div>
                    </div><!-- end card -->
                    {{-- <div class="ad-card">
                        <h4 class="text-gray text-uppercase fs-13 pb-3 text-center">Advertisements</h4>
                        <div class="ad-banner mb-4 mx-auto">
                            <span class="ad-text">290x500</span>
                        </div>
                    </div><!-- end ad-card --> --}}
                </div><!-- end sidebar -->
            </div><!-- end col-lg-3 -->
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end question-area -->
<!-- ================================
         END QUESTION AREA
================================= -->
</x-standard-layout>

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
                            {{-- <div class="filter-option-box w-10">
                                <select class="custom-select">
                                    <option value="newest" selected="selected">Newest </option>
                                    <option value="featured">Bountied (390)</option>
                                    <option value="frequent">Frequent </option>
                                    <option value="votes">Votes </option>
                                    <option value="active">Active </option>
                                    <option value="unanswered">Unanswered </option>
                                </select>
                            </div><!-- end filter-option-box --> --}}
                        </div>
                    </div><!-- end filters -->
                    @unless($questions->isEmpty())
                    <div class="questions-snippet border-top border-top-gray">
                    @foreach($questions as $question)
                        <div class="media media-card rounded-0 shadow-none mb-0 bg-transparent py-3 px-0 border-bottom border-bottom-gray">
                            <div class="votes text-center votes-2">
                                <div class="vote-block">
                                    <span class="vote-counts d-block text-center pr-0 lh-20 fw-medium">{{$question->votes_count}}</span>
                                    <span class="vote-text d-block fs-13 lh-18">votes</span>
                                </div>
                                <div class="answer-block answered my-2">
                                    <span class="answer-counts d-block lh-20 fw-medium">{{$question->comments->count()}}</span>
                                    <span class="answer-text d-block fs-13 lh-18">answers</span>
                                </div>
                            </div>
                            <div class="media-body">
                                <h5 class="mb-2 fw-medium"><a href="/question-details/{{$question->id}}">{{$question->title}}</a></h5>
                                <p class="mb-2 truncate lh-20 fs-15">{{$question->body}}</p>
                                <div class="media media-card user-media align-items-center px-0 border-bottom-0 pb-0">
                                    <a href="/profile/{{ $question->user->username }}" class="media-img d-block">
                                        <img src="{{$question->user->avatar}}" alt="avatar">
                                    </a>
                                    <div class="media-body d-flex flex-wrap align-items-center justify-content-between">
                                        <div>
                                            <h5 class="pb-1"><a href="/profile/{{ $question->user->username }}">{{ $question->user->username }}</a></h5>
                                            <div class="stats fs-12 d-flex align-items-center lh-18">
                                                <span class="text-black pr-2" title="Reputation score">{{ $question->user->bonus_points }} points</span>
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
                @include('sections.interesting-questions')
            </div><!-- end col-lg-3 -->
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end question-area -->
<!-- ================================
         END QUESTION AREA
================================= -->
</x-standard-layout>

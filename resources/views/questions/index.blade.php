<x-standard-layout-qa>
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
                            <h3 class="fs-22 fw-medium">
                                {{ $category->title }} Питання    
                            </h3>         
                            <a href="/ask-question" class="btn theme-btn theme-btn-sm">Задати питання</a>
                        </div>
                        <div class="d-flex flex-wrap align-items-center justify-content-between">
                            <p class="pt-1 fs-15 fw-medium lh-20">{{ $count }} запитання</p>
                        </div>
                    </div><!-- end filters -->
                    @unless($questions->isEmpty())
                    <div class="questions-snippet border-top border-top-gray">
                    @foreach($questions as $question)
                        <div class="media media-card rounded-0 shadow-none mb-0 bg-transparent py-3 px-0 border-bottom border-bottom-gray">
                            <div class="votes text-center votes-2">
                                <div class="vote-block">
                                    <span class="vote-counts d-block text-center pr-0 lh-20 fw-medium">{{$question->votes_count}}</span>
                                    <span class="vote-text d-block fs-13 lh-18">голосів</span>
                                </div>
                                <div class="answer-block answered my-2">
                                    <span class="answer-counts d-block lh-20 fw-medium">{{$question->comments->count()}}</span>
                                    <span class="answer-text d-block fs-13 lh-18">відповіді</span>
                                </div>
                            </div>
                            <div class="media-body">
                                <h5 class="mb-2 fw-medium"><a href="/question-details/{{$question->id}}">{{$question->title}}</a></h5>
                                <p class="mb-2 truncate lh-20 fs-15">{!! $question->body !!}</p>
                                <div class="media media-card user-media align-items-center px-0 border-bottom-0 pb-0">
                                    <a href="/profile/{{ $question->user->username }}" class="media-img d-block">
                                        <img src="{{$question->user->avatar}}" alt="avatar">
                                    </a>
                                    <div class="media-body d-flex flex-wrap align-items-center justify-content-between">
                                        <div>
                                            <h5 class="pb-1"><a href="/profile/{{ $question->user->username }}">{{ $question->user->username }}</a></h5>
                                            <div class="stats fs-12 d-flex align-items-center lh-18">
                                                <span class="text-black pr-2" title="Reputation score">{{ $question->user->bonus_points }} балів</span>
                                            </div>
                                        </div>
                                        <small class="meta d-block text-right">
                                            <span class="text-black d-block lh-18">створений</span>
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
<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('interesting-questions-container');
    const cacheKey = 'cachedInterestingQuestions';
    const cachedData = localStorage.getItem(cacheKey);
    const cacheTimeKey = 'interestingQuestionsCacheTime';
    const cacheTime = localStorage.getItem(cacheTimeKey);
    
    // Check if cache exists and hasn't expired (1 hour = 3600000 milliseconds)
    if (cachedData && cacheTime && (new Date().getTime() - cacheTime < 3600000)) {
        container.innerHTML = cachedData;
    } else {
        console.log('Fetching interesting questions...');
        fetch('/interesting-questions')
            .then(response => response.text())
            .then(html => {
                container.innerHTML = html;
                localStorage.setItem(cacheKey, html);
                localStorage.setItem(cacheTimeKey, new Date().getTime());
            })
            .catch(error => console.error('Error loading interesting questions:', error));
    }
});
</script>
</x-standard-layout-qa>

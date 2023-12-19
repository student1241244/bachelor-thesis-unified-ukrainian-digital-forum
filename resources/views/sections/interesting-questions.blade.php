<div id="interesting-questions-container" class="sidebar">
    <div class="card card-item">
        <div class="card-body">
            <h3 class="fs-17 pb-3"><img style="width: 10%;" src="/images/fire.gif">Interesting Questions</h3>
            <div class="divider"><span></span></div>
            <div class="sidebar-questions pt-3">
            @foreach ($interestingQuestions as $question)
                <div class="media media-card media--card media--card-2">
                    <div class="media-body">
                        <h5><a href="/question-details/{{ $question->id }}">{{ $question->title }}</a></h5>
                        <small class="meta">
                            <span class="pr-1">{{ $question->created_at->format('n/j/Y') }}</span>
                            <span class="pr-1">by</span>
                            <a href="#" class="author">{{ $question->user->username }}</a>
                        </small>
                    </div>
                </div><!-- end media -->
            @endforeach
            </div><!-- end sidebar-questions -->
        </div>
    </div><!-- end card -->
</div><!-- end sidebar -->

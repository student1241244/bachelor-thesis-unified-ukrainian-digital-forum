<x-standard-layout-qa :title="$question->title">
    <!-- ================================
             START QUESTION AREA
    ================================= -->
    <section class="question-area pt-40px pb-40px">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="question-main-bar mb-50px">
                        <div class="question-highlight">
                            <div class="media media-card shadow-none rounded-0 mb-0 bg-transparent p-0">
                                <div class="media-body">
                                    <div class="float-left">
                                        {{-- <div class="comment-avatar">
                                            <a href="/profile/{{$question->user->username}}"><img class="lazy" src="{{$question->user->avatar}}" alt="avatar" style="">
                                        </div> --}}
                                        <h5 class="fs-20"><a>{{$question->title}}</a></h5>
                                        <div class="meta d-flex flex-wrap align-items-center fs-13 lh-20 py-1">
                                            <div class="pr-3">
                                                <span>Created:</span>
                                                <span class="text-black">{{$question->created_at->format('n/j/Y')}}</span>
                                            </div>
                                            <div class="pr-3">
                                                <span class="pr-1">By:</span>
                                                <a href="/profile/{{$question->user->username}}" class="text-black">{{$question->user->username}}</a>
                                            </div>
                                            <div class="pr-3">
                                                <a href="#" class="comment-reply text-color hover-underline js-report" data-type="{{ \App\Services\ReportService::TYPE_QUESTION }}" data-id="{{ $question->id }}"><i class="la la-flag mr-1"></i>Report</a>
                                            </div>
                                            <div>
                                                @can('update', $question)
                                    <div>
                                        <a href="/question-details/{{$question->id}}/edit"><i class="la la-pencil"></i></a>
                                    <form action="/question-details/{{$question->id}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button style="border:none;color:#007bff;background-color:transparent;" type="submit"><i class="la la-trash"></i></button>
                                    </form>
                                    </div>
                                    @endcan
                                            </div>
                                        </div>
                                    </div>
                                    <div  class="float-right">
                                        <div class="hero-btn-box text-right py-3">
                                            <a href="/ask-question" class="btn theme-btn">Ask a Question</a>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end media -->
                        </div><!-- end question-highlight -->
                        <div class="question d-flex">
                            <div class="votes votes-styled w-auto">
                                <div class="vote-buttons">
                                    <button class="vote-button" aria-label="Vote up" onclick="voteQuestion({{ $question->id }}, 1)">
                                      <span class="arrow-up"></span>
                                    </button>
                                    <div class="vote-count"><span id="vote-count">{{ $question->votes_count }}</span></div>
                                </div>
                                <br>  
                                <div id="vote" class="upvotejs">
                                    <a href="{{ route('questions.bookmark', $question->id) }}" class="star {{ $isBookmarked? 'star-on' : '' }}"
                                       data-toggle="tooltip" data-placement="right" title="{{ $isBookmarked ? 'Forget this question' : 'Bookmark this question' }}"></a>
                                </div>
                            </div><!-- end votes -->
                            <div class="question-post-body-wrap flex-grow-1">
                                <div class="question-post-body">
                                    <b>{!! $question->body !!}</b>
                                </div><!-- end question-post-body -->
                                @if ($question->getMedia('images')->count())
                                    @foreach($question->getMedia('images') as $image)
                                        <a href="{{ $image->getUrl() }}" target="_blank"><img class="img-question" src="{{ $image->getUrl('300x152') }}"></a>
                                    @endforeach
                                    <br>
                                @endif
                            </div><!-- end question-post-body-wrap -->
                        </div><!-- end question -->
                        <div class="answer">
                        @if($comments->isEmpty())
                            <p class="pt-4">No comments yet. You can be the first hero!</p>
                        @else
                            @foreach ($comments as $comment)
                            <div class="subheader d-flex align-items-center justify-content-between">
                                <div class="subheader-title">
                                    <div class="float-left" style="translate: 0% 20%;">
                                        <h3 class="fs-16">Answer by: <a href="/profile/{{ $question->user->username }}">{{ $question->user->username }}</h3>
                                    </div>
                                    <div class="float-right" style="margin-left:10px;">
                                        <div class="answer-actions">
                                            <a href="#" class="comment-reply text-color hover-underline js-report" data-type="{{ \App\Services\ReportService::TYPE_QUESTION_ANSWER }}" data-id="{{ $comment->id }}"><i class="la la-flag mr-1"></i>Report</a>
                                            @if (auth()->check() && auth()->user()->id == $comment->user_id)
                                                <a href="#" data-id="{{ $comment->id }}" class="js-link-edit-answer"><i class="la la-pencil"></i></a>
                                                <a href="{{ route('questions.delete_answer', $comment) }}" onclick="return confirm('Are you sure?')"><i class="la la-trash"></i></a>
                                            @endif
                                        </div>
                                    </div>
                                </div><!-- end subheader-title -->
                            </div><!-- end subheader -->
                            <div class="answer-wrap d-flex">
                                <div class="votes votes-styled w-auto">
                                    <div class="vote-buttons">
                                        <button class="vote-button" aria-label="Vote up" onclick="voteAnswer({{$question->id}}, {{$comment->id}}, 1)">
                                          <span class="arrow-up"></span>
                                        </button>
                                        <div class="vote-count"><span id="vote-count-{{$comment->id}}">{{ $comment->votes_count }}</span></div>
                                        <button class="vote-button" aria-label="Vote down" onclick="voteAnswer({{$question->id}}, {{$comment->id}}, -1)">
                                            <span class="arrow-down"></span>
                                        </button>
                                    </div>
                                </div>
                                <div class="answer-body-wrap flex-grow-1">
                                    <div class="answer-body">
                                        <p>{{ $comment->body }}</p>
                                        @if ($comment->getMedia('images')->count())
                                            @foreach($comment->getMedia('images') as $image)
                                                <a href="{{ $image->getUrl() }}" target="_blank"><img class="img-answer" src="{{ $image->getUrl('100x100') }}"></a>
                                            @endforeach
                                            <br>
                                        @endif
                                    </div><!-- end answer-body -->
                                </div><!-- end answer-body-wrap -->
                            </div><!-- end answer-wrap -->
                            @endforeach
                        @endif
                        {{$comments->links()}}
                        </div>
                        <br>
                    <div class="post-form">
                        <form class="row pb-3">
                        </form>
                        <form method="post" class="pt-3" id="answer-form" action="{{ route('questions.post_answer', $question->id) }}">
                            @csrf
                            <div class="input-box">
                                <label class="fs-14 text-black lh-20 fw-medium">Body</label>
                                <div class="form-group">
                                    <textarea class="form-control form--control form-control-sm fs-13 user-text-editor" name="body" rows="6"
                                              placeholder="Your answer here..."></textarea>
                                </div>
                            </div>
                            <div class="input-box">
                                <label class="fs-14 text-black fw-medium">Image (Maximum 6 image. Not more than 2048 KB)</label>
                                <div class="form-group">
                                    <div class="file-upload-wrap file-upload-layout-2">
                                        <input type="file" name="images[]" class="file-upload-input" multiple>
                                        <span class="file-upload-text d-flex align-items-center justify-content-center"><i class="la la-cloud-upload mr-2 fs-24"></i>Drop files here or click to upload.</span>
                                    </div>
                                </div>
                            </div><!-- end input-box -->
                            <button class="btn theme-btn theme-btn-sm" type="submit">Post Your Answer</button>
                        </form>
                    </div>
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

<div class="modal fade modal-container" id="modal-edit-answer" tabindex="-1" role="dialog" aria-labelledby="replyModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header align-items-center">
                <h5 class="modal-title" id="replyModalTitle">Updating Answer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="la la-times"></span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" class="pt-3" id="update-answer-form" action="">
                    @csrf
                    <div class="input-box">
                        <label class="fs-14 text-black lh-20 fw-medium">Body</label>
                        <div class="form-group">
                                    <textarea class="form-control form--control form-control-sm fs-13 user-text-editor" name="body" rows="6"
                                              placeholder="Your answer here..."></textarea>
                        </div>
                    </div>
                    <div class="input-box">
                        <label class="fs-14 text-black fw-medium">Image</label>
                        <div class="form-group js-images-list row">

                        </div>
                        <div class="form-group">
                            <div class="file-upload-wrap file-upload-layout-2">
                                <input type="file" name="images[]" class="file-upload-input" multiple>
                                <span class="file-upload-text d-flex align-items-center justify-content-center"><i class="la la-cloud-upload mr-2 fs-24"></i>Drop files here or click to upload.</span>
                            </div>
                        </div>
                    </div><!-- end input-box -->
                    <button class="btn theme-btn theme-btn-sm" type="submit">Update Your Answer</button>
                </form>

            </div>
        </div>
    </div>
</div>


<script>
function voteQuestion(questionId, vote) {
    console.log("Vote: " + vote); // Add this line for debugging
    $.ajax({
        type: "POST",
        url: "/question-details/" + questionId + "/vote",
        data: {
            _token: "{{csrf_token()}}",
            vote: parseInt(vote)
        },
        success: function(response) {
            // Update the vote count on the page
            $('#vote-count').text(response.newVoteCount);
        },
        error: function(xhr, status, error) {
            console.error(error);
            alert('Error: ' + 'You are not logged in');
            window.location.href = '/signin';
        }
    });
}
function voteAnswer(questionId, answerId, vote) {
    console.log("Vote for Answer" + answerId + ": " + vote); // Add this line for debugging
    $.ajax({
        type: "POST",
        url: "/question-details/" + questionId + "/" + answerId + "/vote",
        data: {
            _token: "{{csrf_token()}}",
            vote: parseInt(vote)
        },
        success: function(response) {
            // Update the vote count on the page
            $('#vote-count-' + answerId).text(response.newVoteCount);
        },
        error: function(xhr, status, error) {
            console.error(error);
            alert('Error: ' + 'You are not logged in');
            window.location.href = '/signin';
        }
    });
}
</script>
<script src="/js/upvote.vanilla.js"></script>
<script src="/js/upvote-script.js"></script>
</x-standard-layout-qa>
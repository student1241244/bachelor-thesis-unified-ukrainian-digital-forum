<x-standard-layout :title="$question->title">
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
                                        <h5 class="fs-20"><a href="question-details.html">{{$question->title}}</a></h5>
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
                                    <button class="vote-button" aria-label="Vote up" onclick="voteQuestion({{$question->id}}, 1)">
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
                            </div><!-- end question-post-body-wrap -->
                        </div><!-- end question -->
                        <div class="answer">
                        @if($comments->isEmpty())
                            <p>No comments yet.</p>
                        @else
                            @foreach ($comments as $comment)
                            <div class="subheader d-flex align-items-center justify-content-between">
                                <div class="subheader-title">
                                    <div class="float-left" style="translate: 0% 20%;">
                                        <h3 class="fs-16">Answer </h3>
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
                                        <button class="vote-button" aria-label="Vote up" onclick="voteAnswer({{$question->id}}, 1)">
                                          <span class="arrow-up"></span>
                                        </button>
                                        <div class="vote-count"><span id="vote-count">{{ $question->votes_count }}</span></div>
                                        <button class="vote-button" aria-label="Vote down">
                                            <span class="arrow-down"></span>
                                          </button>
                                    </div>
                                </div>
                                <div class="answer-body-wrap flex-grow-1">
                                    <div class="answer-body">
                                        <p>{{ $comment->body }}</p>
                                        @if ($comment->getMedia('images')->count())
                                            @foreach($comment->getMedia('images') as $image)
                                                <a href="{{ $image->getUrl() }}" target="_blank"><img src="{{ $image->getUrl('100x100') }}"></a>
                                            @endforeach
                                            <br>
                                        @endif
                                    </div><!-- end answer-body -->
                                </div><!-- end answer-body-wrap -->
                            </div><!-- end answer-wrap -->
                            @endforeach
                        @endif
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
                                <label class="fs-14 text-black fw-medium">Image</label>
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
                <div class="sidebar">
                    <div class="card card-item">
                        <div class="card-body">
                            <h3 class="fs-17 pb-3">Related Questions</h3>
                            <div class="divider"><span></span></div>
                            <div class="sidebar-questions pt-3">
                                <div class="media media-card media--card media--card-2">
                                    <div class="media-body">
                                        <h5><a href="question-details.html">How to select the dom element with event.target</a></h5>
                                        <small class="meta">
                                            <span class="pr-1">2 mins ago</span>
                                            <span class="pr-1">. by</span>
                                            <a href="#" class="author">Sudhir Kumbhare</a>
                                        </small>
                                    </div>
                                </div><!-- end media -->
                                <div class="media media-card media--card media--card-2">
                                    <div class="media-body">
                                        <h5><a href="question-details.html">How can you cut an onion without crying?</a></h5>
                                        <small class="meta">
                                            <span class="pr-1">48 mins ago</span>
                                            <span class="pr-1">. by</span>
                                            <a href="#" class="author">wimax</a>
                                        </small>
                                    </div>
                                </div><!-- end media -->
                                <div class="media media-card media--card media--card-2">
                                    <div class="media-body">
                                        <h5><a href="question-details.html">How to change the behavior of dropdown buttons in HTML</a></h5>
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
                    <div class="ad-card">
                        <h4 class="text-gray text-uppercase fs-13 pb-3 text-center">Advertisements</h4>
                        <div class="ad-banner mb-4 mx-auto">
                            <span class="ad-text">290x500</span>
                        </div>
                    </div><!-- end ad-card -->
                </div><!-- end sidebar -->
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
            alert('Error: ' + error.message);
        }
    });
}
</script>
</x-standard-layout>
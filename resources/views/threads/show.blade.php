<x-standard-layout>

    <section class="hero-area pattern-bg-2 bg-white shadow-sm overflow-hidden pt-50px pb-50px">
        <span class="stroke-shape stroke-shape-1"></span>
        <span class="stroke-shape stroke-shape-2"></span>
        <span class="stroke-shape stroke-shape-3"></span>
        <span class="stroke-shape stroke-shape-4"></span>
        <span class="stroke-shape stroke-shape-5"></span>
        <span class="stroke-shape stroke-shape-6"></span>
        <div class="container">
            <div class="hero-content">
                <ul class="breadcrumb-list pb-2">
                    <li><a href="/">Home</a><span><svg xmlns="http://www.w3.org/2000/svg" height="19px" viewBox="0 0 24 24" width="19px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6-6-6z"/></svg></span></li>
                    <li><a href="{{ route('threads.index') }}">Threads</a><span><svg xmlns="http://www.w3.org/2000/svg" height="19px" viewBox="0 0 24 24" width="19px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6-6-6z"/></svg></span></li>
                    <li>{{ $thread->title }}</li>
                </ul>
                <h2 class="section-title">{{ $thread->title }}</h2>
                <div class="media media-card align-items-center shadow-none p-0 mb-0 rounded-0 mt-4 bg-transparent">
                    <div class="media-body">
                        <small class="meta d-block lh-20">
                            <span class="mr-2">{{ $thread->created_at->format('M d, Y') }}</span>
                            <span class="mr-2 fs-15">.</span>
                            <a href="#comments" class="page-scroll text-gray"><i class="la la-comment mr-1"></i>{{ $countComments }}</a>

                            <a href="#" class="comment-reply text-color hover-underline js-report" data-type="{{ \App\Services\ReportService::TYPE_THREAD }}" data-id="{{ $thread->id }}"><i class="la la-flag mr-1"></i>Report</a>
                        </small>
                    </div>
                </div>
            </div><!-- end hero-content -->
        </div><!-- end container -->
    </section><!-- end hero-area -->
    <!--======================================
            END HERO AREA
    ======================================-->

    <!-- ================================
             START BLOG AREA
    ================================= -->
    <section class="blog-area pt-80px pb-80px">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card card-item">
                        <div class="card-body">
                        {{ $thread->body }}
                        </div><!-- end card-body -->
                    </div><!-- end card -->
                    <div class="card card-item">
                        <div class="card-body">
                            <h4 class="pb-3 fs-20">{{ $countComments }} Comments</h4>
                            <ul class="comments-list pt-3" id="comments">
                            @foreach($comments as $comment)
                                <li class="mb-3">
                                    <div class="comment-body pt-0">
                                        <span class="comment-separated">-</span>
                                        <span class="comment-date text-gray">{{ $comment->created_at->diffForHumans() }}</span>
                                        <p class="comment-text pt-1 pb-2 lh-22">{{ $comment->body }}</p>
                                        <a href="#" class="comment-reply text-color hover-underline js-report" data-type="{{ \App\Services\ReportService::TYPE_THREAD_COMMENT }}" data-id="{{ $comment->id }}"><i class="la la-flag mr-1"></i>Report</a>
                                    </div>
                                </li>
                             @endforeach
                            </ul>
                        </div><!-- end card-body -->
                    </div><!-- end card -->

                    <form method="post" class="card card-item" id="comment-form" action="{{ route('threads.add_comment', $thread->id) }}">
                        @csrf
                        <div class="card-body row">
                            <div class="form-group col-lg-12">
                                <h4 class="fs-20">Leave a Comment</h4>
                            </div><!-- end form-group -->
                            <div class="form-group col-lg-12">
                                <textarea class="form-control form--control" name="body" rows="5" placeholder="Your comment here..."></textarea>
                            </div><!-- end form-group -->
                            <div class="form-group col-lg-12 mb-0">
                                <button class="btn theme-btn" type="submit">Post Comment </button>
                            </div><!-- end form-group -->
                        </div><!-- end card-body -->
                    </form>

                </div><!-- end col-lg-8 -->
            </div><!-- end row -->
        </div><!-- end container -->
    </section><!-- end blog-area -->


</x-standard-layout>

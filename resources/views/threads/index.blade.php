<x-standard-layout>



    <!--======================================
            START HERO AREA
    ======================================-->
    <section class="hero-area pattern-bg-2 bg-white shadow-sm overflow-hidden pt-50px pb-50px">
        <span class="stroke-shape stroke-shape-1"></span>
        <span class="stroke-shape stroke-shape-2"></span>
        <span class="stroke-shape stroke-shape-3"></span>
        <span class="stroke-shape stroke-shape-4"></span>
        <span class="stroke-shape stroke-shape-5"></span>
        <span class="stroke-shape stroke-shape-6"></span>
        <div class="container">
            <div class="hero-content text-center">
                <h2 class="section-title pb-3">Threads</h2>
                <ul class="breadcrumb-list">
                    <li><a href="/">Home</a><span><svg xmlns="http://www.w3.org/2000/svg" height="19px" viewBox="0 0 24 24" width="19px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6-6-6z"/></svg></span></li>
                    <li>Threads</li>
                </ul>
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

                @foreach($threads as $thread)
                <div class="col-lg-4 responsive-column-half">
                    <div class="card card-item hover-y">
                        <a href="{{ route('threads.show', $thread->id) }}" class="card-img">
                            <img class="lazy" src="{{ $thread->getImageorNull('image', '590x300') }}" data-src="{{ $thread->getImageorNull('image', '590x300') }}" alt="{{ $thread->title }}">
                        </a>
                        <div class="card-body pt-0">
                            <a href="#" class="card-link">{{ $thread->category->title }}</a>
                            <h5 class="card-title fw-medium"><a href="{{ route('threads.show', $thread->id) }}">{{ $thread->title }}</a></h5>
                            <div class="media media-card align-items-center shadow-none p-0 mb-0 rounded-0 mt-4 bg-transparent">
                                <div class="media-body">
                                    <small class="meta d-block lh-20">
                                        <span>{{ $thread->created_at->format('M d, Y') }}</span>
                                    </small>
                                </div>
                            </div>
                        </div><!-- end card-body -->
                    </div><!-- end card -->
                </div><!-- end col-lg-4 -->
                @endforeach

            </div><!-- end row -->

            <div class="pager text-center pt-30px">
                {!! $threads->links() !!}
            </div>

        </div><!-- end container -->
    </section><!-- end blog-area -->



</x-standard-layout>

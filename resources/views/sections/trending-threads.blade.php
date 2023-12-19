<div id="trending-threads-container">
    <h3 class="section-title pb-3 fs-20"><img style="width:2%;" src="/images/fire.gif">Trending threads:</h3>
    <div class="hero-content text-center pt-20px" style="display:flex;">
        @foreach($trendingThreads as $trendingThread)
            <a href="/threads-{{ $trendingThread->id }}" class="cat-item d-flex align-items-center justify-content-between mb-3 hover-y">
                <span class="cat-title">{{ $trendingThread->title }}</span>
                <span class="cat-number"><i class="la la-angle-right collapse-icon"></i></span>
            </a>
        @endforeach    
    </div><!-- end hero-content -->
</div>
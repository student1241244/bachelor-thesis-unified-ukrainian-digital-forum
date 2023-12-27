<div>
    <div class="card-body">
        <h4 class="pb-3 fs-20">{{ $countComments }} Comments</h4>
        <ul class="comments-list pt-3" id="comments">
            @foreach($comments as $comment)
            <li class="mb-3">
                <div class="comment-body pt-0">
                    <span class="comment-separated">Anonymous</span>
                    @if($comment['is_passcode_user'])
                        <span class="checkmark-icon"><img src="/images/check1.png"></span>
                    @endif
                    <span class="comment-separated"> - </span>
                    <span class="comment-date text-gray">{{ \Carbon\Carbon::parse($comment['created_at'])->diffForHumans() }}</span>
                    <span class="comment-date text-gray">#{{ $comment['id'] }}</span>
                    <p class="comment-text pt-1 pb-2 lh-22">{{ $comment['body'] }}</p>
                    <a href="#" class="comment-reply text-color hover-underline js-report" data-type="{{ \App\Services\ReportService::TYPE_THREAD_COMMENT }}" data-id="{{ $comment['id'] }}"><i class="la la-flag mr-1"></i>Звіт</a>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
    @if ($hasMorePages)
    <div class="mt-2 mb-12 p-2 flex justify-center">
        <button wire:click="loadMore" class="btn theme-btn">
            Load More
        </button>
    </div>
    @endif
</div>

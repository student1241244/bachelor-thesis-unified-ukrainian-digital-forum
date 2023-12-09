<?php
use App\Models\Question;
use App\Models\Comment;
use Packages\Threads\App\Models\Thread;
use Packages\Threads\App\Models\Comment as ThreadComment;

$data = [
    [
        'title' => 'Questions for today',
        'count' => Question::query()->where('created_at', '>=', date('Y-m-d 00:00:00'))->count(),
    ],
    [
        'title' => 'Questions for the last week',
        'count' => Question::query()->where('created_at', '>=', date('Y-m-d H:i:s', strtotime('-1 week')))->count(),
    ],
    [
        'title' => 'Questions for the last month',
        'count' => Question::query()->where('created_at', '>=', date('Y-m-d H:i:s', strtotime('-1 month')))->count(),
    ],
    [
        'title' => 'Questions for the last year',
        'count' => Question::query()->where('created_at', '>=', date('Y-m-d H:i:s', strtotime('-1 year')))->count(),
    ],
    //
    [
        'title' => 'Questions Comments for today',
        'count' => Comment::query()->where('created_at', '>=', date('Y-m-d 00:00:00'))->count(),
    ],
    [
        'title' => 'Questions Comments for the last week',
        'count' => Comment::query()->where('created_at', '>=', date('Y-m-d H:i:s', strtotime('-1 week')))->count(),
    ],
    [
        'title' => 'Questions Comments for the last month',
        'count' => Comment::query()->where('created_at', '>=', date('Y-m-d H:i:s', strtotime('-1 month')))->count(),
    ],
    [
        'title' => 'Questions Comments for the last year',
        'count' => Comment::query()->where('created_at', '>=', date('Y-m-d H:i:s', strtotime('-1 year')))->count(),
    ],
    ////
    [
        'title' => 'Threads for today',
        'count' => Thread::query()->where('created_at', '>=', date('Y-m-d 00:00:00'))->count(),
    ],
    [
        'title' => 'Threads for the last week',
        'count' => Thread::query()->where('created_at', '>=', date('Y-m-d H:i:s', strtotime('-1 week')))->count(),
    ],
    [
        'title' => 'Threads for the last month',
        'count' => Thread::query()->where('created_at', '>=', date('Y-m-d H:i:s', strtotime('-1 month')))->count(),
    ],
    [
        'title' => 'Threads for the last year',
        'count' => Thread::query()->where('created_at', '>=', date('Y-m-d H:i:s', strtotime('-1 year')))->count(),
    ],
    [
        'title' => 'Threads Comments for today',
        'count' => ThreadComment::query()->where('created_at', '>=', date('Y-m-d 00:00:00'))->count(),
    ],
    [
        'title' => 'Threads Comments for the last week',
        'count' => ThreadComment::query()->where('created_at', '>=', date('Y-m-d H:i:s', strtotime('-1 week')))->count(),
    ],
    [
        'title' => 'Threads Comments for the last month',
        'count' => ThreadComment::query()->where('created_at', '>=', date('Y-m-d H:i:s', strtotime('-1 month')))->count(),
    ],
    [
        'title' => 'Threads Comments for the last year',
        'count' => ThreadComment::query()->where('created_at', '>=', date('Y-m-d H:i:s', strtotime('-1 year')))->count(),
    ],
];
?>

<div class="row">
    @foreach($data as $item)
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <p>{{ $item['title'] }}</p>
                    <h4>{{ $item['count'] }}</h4>
                </div>
            </div>
        </div>
    @endforeach
</div>



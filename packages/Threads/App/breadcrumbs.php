<?php
use Packages\Threads\App\Models\Category;
use Packages\Threads\App\Models\Thread;
use Packages\Threads\App\Models\Comment;

// Threads > Categories
Breadcrumbs::for('threads.categories.index', function ($trail) {
    $trail->parent('dashboard.dashboard.index');
    $trail->push(trans('threads::category.breadcrumbs.index'), route('threads.categories.index'));
});

// Threads > Categories > Create
Breadcrumbs::for('threads.categories.create', function ($trail) {
    $trail->parent('threads.categories.index');
    $trail->push(trans('threads::category.breadcrumbs.create'), route('threads.categories.create'));
});

// Threads > Categories > Edit
Breadcrumbs::for('threads.categories.edit', function ($trail, Category $category) {
    $trail->parent('threads.categories.index');
    $trail->push(trans('threads::category.breadcrumbs.update') . ' #' . $category->id, route('threads.categories.edit', $category));
});

// Threads > Threads
Breadcrumbs::for('threads.threads.index', function ($trail) {
    $trail->parent('dashboard.dashboard.index');
    $trail->push(trans('threads::thread.breadcrumbs.index'), route('threads.threads.index'));
});

// Threads > Threads > Create
Breadcrumbs::for('threads.threads.create', function ($trail) {
    $trail->parent('threads.threads.index');
    $trail->push(trans('threads::thread.breadcrumbs.create'), route('threads.threads.create'));
});

// Threads > Threads > Edit
Breadcrumbs::for('threads.threads.edit', function ($trail, Thread $thread) {
    $trail->parent('threads.threads.index');
    $trail->push(trans('threads::thread.breadcrumbs.update') . ' #' . $thread->id, route('threads.threads.edit', $thread));
});

// Threads > Comments
Breadcrumbs::for('threads.comments.index', function ($trail) {
    $trail->parent('dashboard.dashboard.index');
    $trail->push(trans('threads::comment.breadcrumbs.index'), route('threads.comments.index'));
});

// Threads > Comments > Create
Breadcrumbs::for('threads.comments.create', function ($trail) {
    $trail->parent('threads.comments.index');
    $trail->push(trans('threads::comment.breadcrumbs.create'), route('threads.comments.create'));
});

// Threads > Comments > Edit
Breadcrumbs::for('threads.comments.edit', function ($trail, Comment $comment) {
    $trail->parent('threads.comments.index');
    $trail->push(trans('threads::comment.breadcrumbs.update') . ' #' . $comment->id, route('threads.comments.edit', $comment));
});


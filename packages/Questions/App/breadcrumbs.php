<?php
use App\Models\Question;
use App\Models\Comment;

// Questions > Questions
Breadcrumbs::for('questions.questions.index', function ($trail) {
    $trail->parent('dashboard.dashboard.index');
    $trail->push(trans('questions::question.breadcrumbs.index'), route('questions.questions.index'));
});

// Questions > Questions > Create
Breadcrumbs::for('questions.questions.create', function ($trail) {
    $trail->parent('questions.questions.index');
    $trail->push(trans('questions::question.breadcrumbs.create'), route('questions.questions.create'));
});

// Questions > Questions > Edit
Breadcrumbs::for('questions.questions.edit', function ($trail, Question $question) {
    $trail->parent('questions.questions.index');
    $trail->push(trans('questions::question.breadcrumbs.update') . ' #' . $question->id, route('questions.questions.edit', $question));
});

// Questions > Comments
Breadcrumbs::for('questions.comments.index', function ($trail) {
    $trail->parent('dashboard.dashboard.index');
    $trail->push(trans('questions::comment.breadcrumbs.index'), route('questions.comments.index'));
});

// Questions > Comments > Create
Breadcrumbs::for('questions.comments.create', function ($trail) {
    $trail->parent('questions.comments.index');
    $trail->push(trans('questions::comment.breadcrumbs.create'), route('questions.comments.create'));
});

// Questions > Comments > Edit
Breadcrumbs::for('questions.comments.edit', function ($trail, Comment $comment) {
    $trail->parent('questions.comments.index');
    $trail->push(trans('questions::comment.breadcrumbs.update') . ' #' . $comment->id, route('questions.comments.edit', $comment));
});


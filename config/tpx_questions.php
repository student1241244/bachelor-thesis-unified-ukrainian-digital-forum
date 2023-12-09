<?php
return [
    'id' => 'Questions',
    'protected_records' => [
    ],
	'navigation' => [
		'questions::question' => [
			'title'    => 'questions::question.title.menu',
			'route'    => 'questions.questions.index',
			'icon'     => 'fa fa-question fa-fw',
			'color'    => '#069',
			'rank'     => 10,
		],
		'questions::comment' => [
			'title'    => 'questions::comment.title.menu',
			'route'    => 'questions.comments.index',
			'icon'     => 'fa fa-reply fa-fw',
			'color'    => '#069',
			'rank'     => 10,
		],
	],
	'permissions' => [
		'questions' => ['index' => ['admin', 'moderator'], 'update' => ['admin', 'moderator'], 'destroy' => ['admin', 'moderator']],
		'comments' => ['index' => ['admin', 'moderator'], 'update' => ['admin', 'moderator'], 'destroy' => ['admin', 'moderator']],
	],
];

<?php
return [
    'id' => 'Questions',
    'protected_records' => [
    ],
	'navigation' => [
		'questions::question' => [
			'title'    => 'questions::question.title.menu',
			'route'    => 'questions.questions.index',
			'icon'     => 'fa fa-folder fa-fw',
			'color'    => '#999000',
			'rank'     => 10,
		],
		'questions::comment' => [
			'title'    => 'questions::comment.title.menu',
			'route'    => 'questions.comments.index',
			'icon'     => 'fa fa-folder fa-fw',
			'color'    => '#999000',
			'rank'     => 10,
		],
	],
	'permissions' => [
		'questions' => '*',
		'comments' => '*',
	],
];

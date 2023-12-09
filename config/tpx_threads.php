<?php
return [
    'id' => 'Threads',
    'protected_records' => [
    ],
	'navigation' => [
		/**
        'threads::category' => [
			'title'    => 'threads::category.title.menu',
			'route'    => 'threads.categories.index',
			'icon'     => 'fa fa-folder fa-fw',
			'color'    => '#999000',
			'rank'     => 10,
		],
        */
		'threads::thread' => [
			'title'    => 'threads::thread.title.menu',
			'route'    => 'threads.threads.index',
			'icon'     => 'fa fa-folder fa-fw',
			'color'    => '#999000',
			'rank'     => 10,
		],
		'threads::comment' => [
			'title'    => 'threads::comment.title.menu',
			'route'    => 'threads.comments.index',
			'icon'     => 'fa fa-folder fa-fw',
			'color'    => '#999000',
			'rank'     => 10,
		],
	],
	'permissions' => [
		'categories' => [],
		'threads' => ['index' => ['admin', 'moderator'], 'update' => ['admin', 'moderator'], 'destroy' => ['admin', 'moderator']],
		'comments' => ['index' => ['admin', 'moderator'], 'update' => ['admin', 'moderator'], 'destroy' => ['admin', 'moderator']],
	],
];

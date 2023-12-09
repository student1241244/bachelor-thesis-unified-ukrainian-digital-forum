<?php
return [
    'id' => 'Stories',
    'protected_records' => [
    ],
	'navigation' => [
		'stories::category' => [
			'title'    => 'stories::category.title.menu',
			'route'    => 'stories.categories.index',
			'icon'     => 'fa fa-folder fa-fw',
			'color'    => '#999000',
			'rank'     => 10,
		],
		'stories::thread' => [
			'title'    => 'stories::thread.title.menu',
			'route'    => 'stories.threads.index',
			'icon'     => 'fa fa-folder fa-fw',
			'color'    => '#999000',
			'rank'     => 10,
		],
		'stories::comment' => [
			'title'    => 'stories::comment.title.menu',
			'route'    => 'stories.comments.index',
			'icon'     => 'fa fa-folder fa-fw',
			'color'    => '#999000',
			'rank'     => 10,
		],
	],
	'permissions' => [
		'categories' => '*',
		'threads' => '*',
		'comments' => '*',
	],
];

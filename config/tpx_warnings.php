<?php
return [
    'id' => 'Warnings',
    'protected_records' => [
    ],
	'navigation' => [
		'warnings::warning' => [
			'title'    => 'warnings::warning.title.menu',
			'route'    => 'warnings.warnings.index',
			'icon'     => 'fa fa-warning fa-fw',
			'color'    => 'orange',
			'rank'     => 100,
		],
	],
	'permissions' => [
		'warnings' => ['index' => ['admin', 'moderator'], 'destroy' => ['admin', 'moderator'], 'create' => ['admin', 'moderator']],
	],
];

<?php
return [
    'id' => 'Settings',
    'protected_records' => [
    ],
	'navigation' => [
		'settings::settings' => [
			'title'    => 'settings::settings.title.menu',
			'route'    => 'settings.settings.index',
			'icon'     => 'fa fa-warning fa-fw',
			'color'    => 'red',
			'rank'     => 100,
		],
	],
	'permissions' => [
		'settings' => ['index' => ['admin', 'moderator'], 'destroy' => ['admin', 'moderator'], 'create' => ['admin', 'moderator']],
	],
];

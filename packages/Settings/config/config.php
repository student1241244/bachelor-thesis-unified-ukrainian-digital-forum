<?php
return [
    'id' => 'Settings',
    'protected_records' => [
    ],
	'navigation' => [
		'settings::settings' => [
			'title'    => 'settings::settings.title.menu',
			'route'    => 'settings.settings.index',
			'icon'     => 'fa fa-folder fa-fw',
			'color'    => '#999000',
			'rank'     => 10,
		],
	],
	'permissions' => [
		'settings' => '*',
	],
];

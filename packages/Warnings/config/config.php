<?php
return [
    'id' => 'Warnings',
    'protected_records' => [
    ],
	'navigation' => [
		'warnings::warning' => [
			'title'    => 'warnings::warning.title.menu',
			'route'    => 'warnings.warnings.index',
			'icon'     => 'fa fa-folder fa-fw',
			'color'    => '#999000',
			'rank'     => 10,
		],
	],
	'permissions' => [
		'warnings' => '*',
	],
];

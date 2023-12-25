<?php

use Products\Models\Product;
use Services\Models\Service;

return [
    'id' => 'Dashboard',
    'vendor' => 'Lemyk',
    /*
    |--------------------------------------------------------------------------
    | Default Template
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default template used for database pages.
    |
    */
    'title' => 'Dashboard',

    'version' => '1',

    'mini_title' => env('APP_NAME_SHORT'),

    'company_name' => env('APP_NAME'),

    'default_template' => 'default',

    'public_resources' => 'vendor/dashboard',

    'registration' => false,

    'activations' => true,

    'email_notifications' => true,

    'publish_views' => false,

    'social_login' => false,

    'localization' => [
        'is_enabled'            => true,
        'is_enabled_active_tab' => true,
        'languages'             => [
            'en' => 'English',
        ],
    ],

    'datepicker'       => [
        'js'  => [
            'format' => 'dd.mm.yyyy',
        ],
        'php' => [
            'format' => 'd.m.Y',
        ],
    ],
    'placeholders-url' => '/vendor/dashboard/images/',

    'protected_records' => [
        'role' => [
            'selector' => 'slug',
            'records'  => ['admin'],
        ],
        'user' => [
            'selector' => 'id',
            'records'  => ['1'],
            'except'   => [
                'edit',
            ],
        ],
        /*
        'page' => [
            'selector' => 'slug',
            'except'   => [
                'edit',
            ],
            'records'  => [
                'home',
            ],
        ],
        */
    ],

    'navigation' => [
        'dashboard::user' => [
            'title'    => 'dashboard::user.title.menu',
            'route'    => 'dashboard.users.index',
            'icon'     => 'fa fa-user fa-fw',
            'color'    => '#BB6BD9',
            'rank'     => 0,
        ],
        'dashboard::role' => [
            'title'    => 'dashboard::role.title.menu',
            'route'    => 'dashboard.roles.index',
            'icon'     => '	fa fa-group',
            'color'    => '#BB6BD9',
            'rank'     => 1,
        ],
        'dashboard::language' => [
            'title'    => 'dashboard::language.title.menu',
            'route'    => 'dashboard.languages.index',
            'icon'     => '	fa fa-flag fa-fw',
            'color'    => '#6bd9c0',
            'rank'     => 2,
        ],
        'dashboard::translation' => [
            'title'    => 'dashboard::translation.title.menu',
            'route'    => 'dashboard.translations.index',
            'icon'     => 'fa fa-language fa-fw',
            'color'    => '#6F76CF',
            'rank'     => 3,
        ],
    ],

    'permissions' => [
        'users' => '*',
        'roles' => '*',
        'languages' => '*',
        'translation' => ['index', 'update', 'import', 'export'],
    ],

    'seeders' => [
        'user' => [
            'email' => 'admin@admin.com',
            'password' => 'admin@',
        ],
    ],
    'route' => [
        'prefix' => 'dashboard',
    ],
    'translation' => [
        'editable_groups' => ['front'],
    ],
    'access' => [
        'roles' => ['admin'],
    ],

    'search' => [
        'models' => [
            [
                'class' => '\Packages\Dashboard\App\Models\User',
                'icon' => '',
                'permission' => 'dashboard.users.index',
                'group' => 'access',
            ],
            [
                'class' => '\Packages\Dashboard\App\Models\Role',
                'icon' => '',
                'permission' => 'dashboard.roles.index',
                'group' => 'access',
            ],
            [
                'class' => '\Packages\Dashboard\App\Models\Translation',
                'icon' => '',
                'permission' => 'dashboard.translations.index',
                'group' => 'content',
            ],
        ],
        'static' => [
            [
                'icon' => '',
                'permission' => 'dashboard.users.index',
                'group' => 'access',
            ],
            [
                'icon' => '',
                'permission' => 'dashboard.users.create',
                'group' => 'access',
            ],
            [
                'icon' => '',
                'permission' => 'dashboard.roles.index',
                'group' => 'access',
            ],
            [
                'icon' => '',
                'permission' => 'dashboard.roles.create',
                'group' => 'access',
            ],
            [
                'icon' => '',
                'permission' => 'dashboard.translations.index',
                'group' => 'content',
            ]
        ],
    ],


];

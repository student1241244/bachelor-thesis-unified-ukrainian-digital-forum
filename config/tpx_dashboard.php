<?php
/**
 * Part ot the LLC Dashboard extension.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the LLC PSL License.
 *
 * This source file is subject to the LLC PSL License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    LLC Dashboard extension
 * @version    0.1
 * @license    LLC
 * @copyright  (c) 2011-2020, LLC
 * @link       http://digitalp.co
 */

use Products\Models\Product;
use Services\Models\Service;

return [
    'id' => 'Dashboard',
    'vendor' => 'LLC',
    /*
    |--------------------------------------------------------------------------
    | Default Template
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default template used for database pages.
    |
    */
    'title' => 'Dashboard',

    'version' => '0.2',

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
        'dashboard::dashboard' => [
            'title'    => 'dashboard::dashboard.title.menu',
            'route'    => 'dashboard.dashboard.index',
            'icon'     => 'fa fa-bar-chart fa-fw',
            'color'    => '#069',
            'rank'     => 0,
        ],
        'dashboard::user' => [
            'title'    => 'dashboard::user.title.menu',
            'route'    => 'dashboard.users.index',
            'icon'     => 'fa fa-user fa-fw',
            'color'    => '#EB5757',
            'rank'     => 1,
        ],
        /*
        'dashboard::translation' => [
            'title'    => 'dashboard::translation.title.menu',
            'route'    => 'dashboard.translations.index',
            'icon'     => 'fa fa-language fa-fw',
            'color'    => '#6F76CF',
            'rank'     => 3,
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
         */
    ],

    'permissions' => [
        'users' => ['index', 'update', 'create', 'destroy'],
        'account' => ['edit', 'update', 'password'],
        'dashboard' => ['index' => ['admin', 'moderator']],
    ],


    'seeders' => [
        'user' => [
            'email' => 'admin@admin.com',
            'password' => '123123',
        ],
    ],
    'route' => [
        'prefix' => 'dashboard',
    ],
    'translation' => [
        'editable_groups' => ['front'],
    ],
    'access' => [
        'roles' => ['admin', 'moderator'],
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
                'permission' => 'dashboard.translation.index',
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
                'permission' => 'dashboard.translation.index',
                'group' => 'content',
            ]
        ],
    ],


];

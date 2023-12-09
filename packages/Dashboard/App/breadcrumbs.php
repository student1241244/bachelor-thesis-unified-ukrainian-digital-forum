<?php
use Packages\Dashboard\App\Models\{
    User,
    Role,
    Language
};

// Dashboard
Breadcrumbs::for('dashboard.dashboard.index', function ($trail) {
    $trail->push(trans('dashboard::dashboard.dashboard'), route('dashboard.dashboard.index'));
});

// Dashboard > Users
Breadcrumbs::for('dashboard.users.index', function ($trail) {
    $trail->parent('dashboard.dashboard.index');
    $trail->push(trans('dashboard::user.breadcrumbs.index'), route('dashboard.users.index'));
});

// Dashboard > Users > Create
Breadcrumbs::for('dashboard.users.create', function ($trail) {
    $trail->parent('dashboard.users.index');
    $trail->push(trans('dashboard::user.breadcrumbs.create'), route('dashboard.users.create'));
});

// Dashboard > Users > Edit
Breadcrumbs::for('dashboard.users.edit', function ($trail, User $user) {
    $trail->parent('dashboard.users.index');
    $trail->push($user->email, route('dashboard.users.edit', $user));
});

/**--------------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------------
----------------------------------------------------------------------------------------------------------- */

// Dashboard > Roles
Breadcrumbs::for('dashboard.roles.index', function ($trail) {
    $trail->parent('dashboard.dashboard.index');
    $trail->push(trans('dashboard::role.breadcrumbs.index'), route('dashboard.roles.index'));
});

// Dashboard > Roles > Create
Breadcrumbs::for('dashboard.roles.create', function ($trail) {
    $trail->parent('dashboard.roles.index');
    $trail->push(trans('dashboard::role.breadcrumbs.create'), route('dashboard.roles.create'));
});

// Dashboard > Roles > Edit
Breadcrumbs::for('dashboard.roles.edit', function ($trail, Role $role) {
    $trail->parent('dashboard.roles.index');
    $trail->push($role->title, route('dashboard.roles.edit', $role));
});


/**--------------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------------
----------------------------------------------------------------------------------------------------------- */
// Dashboard > Languages
Breadcrumbs::for('dashboard.languages.index', function ($trail) {
    $trail->parent('dashboard.dashboard.index');
    $trail->push(trans('dashboard::language.breadcrumbs.index'), route('dashboard.languages.index'));
});

// Dashboard > Languages > Create
Breadcrumbs::for('dashboard.languages.create', function ($trail) {
    $trail->parent('dashboard.languages.index');
    $trail->push(trans('dashboard::language.breadcrumbs.create'), route('dashboard.languages.create'));
});

// Dashboard > Languages > Edit
Breadcrumbs::for('dashboard.languages.edit', function ($trail, Language $language) {
    $trail->parent('dashboard.languages.index');
    $trail->push($language->title, route('dashboard.languages.edit', $language));
});


/**--------------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------------
----------------------------------------------------------------------------------------------------------- */

// Dashboard > Edit Account
Breadcrumbs::for('dashboard.account.edit', function ($trail) {
    $trail->parent('dashboard.dashboard.index');
    $trail->push(trans('dashboard::account.breadcrumbs.edit'), route('dashboard.account.edit'));
});

// Dashboard > Translations
Breadcrumbs::for('dashboard.translations.index', function ($trail) {
    $trail->parent('dashboard.dashboard.index');
    $trail->push(trans('dashboard::translation.breadcrumbs.index'), route('dashboard.translations.index'));
});

// Dashboard > Translations
Breadcrumbs::for('dashboard.translations.edit', function ($trail, \Packages\Dashboard\App\Models\Translation $translation) {
    $trail->parent('dashboard.translations.index');
    $trail->push(trans('dashboard::translation.breadcrumbs.update'), route('dashboard.translations.edit', $translation));
});

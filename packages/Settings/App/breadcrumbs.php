<?php
use Packages\Settings\App\Models\Settings;

// Settings > Settings
Breadcrumbs::for('settings.settings.index', function ($trail) {
    $trail->parent('dashboard.dashboard.index');
    $trail->push(trans('settings::settings.breadcrumbs.index'), route('settings.settings.index'));
});

// Settings > Settings > Create
Breadcrumbs::for('settings.settings.create', function ($trail) {
    $trail->parent('settings.settings.index');
    $trail->push(trans('settings::settings.breadcrumbs.create'), route('settings.settings.create'));
});

// Settings > Settings > Edit
Breadcrumbs::for('settings.settings.edit', function ($trail, Settings $settings) {
    $trail->parent('settings.settings.index');
    $trail->push(trans('settings::settings.breadcrumbs.update') . ' #' . $settings->id, route('settings.settings.edit', $settings));
});
<?php
use Packages\Settings\App\Models\Settings;

// Settings > Settings
Breadcrumbs::for('settings.settings.index', function ($trail) {
    $trail->parent('dashboard.dashboard.index');
    $trail->push(trans('settings::settings.breadcrumbs.index'), route('settings.settings.index'));
});

// Settings > Settings
Breadcrumbs::for('admin.settings.pagespeed', function ($trail) {
    $trail->parent('dashboard.dashboard.index');
    $trail->push(trans('settings::settings.breadcrumbs.index'), route('settings.settings.index'));
});
<?php
use Packages\Warnings\App\Models\Warning;

// Warnings > Warnings
Breadcrumbs::for('warnings.warnings.index', function ($trail) {
    $trail->parent('dashboard.dashboard.index');
    $trail->push(trans('warnings::warning.breadcrumbs.index'), route('warnings.warnings.index'));
});

// Warnings > Warnings > Create
Breadcrumbs::for('warnings.warnings.create', function ($trail) {
    $trail->parent('warnings.warnings.index');
    $trail->push(trans('warnings::warning.breadcrumbs.create'), route('warnings.warnings.create'));
});

// Warnings > Warnings > Edit
Breadcrumbs::for('warnings.warnings.edit', function ($trail, Warning $warning) {
    $trail->parent('warnings.warnings.index');
    $trail->push(trans('warnings::warning.breadcrumbs.update') . ' #' . $warning->id, route('warnings.warnings.edit', $warning));
});


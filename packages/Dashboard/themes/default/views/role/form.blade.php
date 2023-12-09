<?php
use Illuminate\Database\Eloquent\Collection;

if ($role->permissions instanceof Collection) {
    $role->permissions = $role->permissions->pluck('id')->toArray();
}

$action = $role->id ? route('dashboard.roles.update', [$role]) : route('dashboard.roles.store');
$labels = trans('dashboard::role.attributes');

?>

{!! BootForm::open()->action($action) !!}
 {!! BootForm::bind($role) !!}
    @method($role->id ? 'PUT' : 'POST')

    {!! BootForm::text(required_mark($labels['title']), 'title') !!}
    {!! BootForm::text(required_mark($labels['slug']), 'slug') !!}
    {!! BootForm::select($labels['permissions'], 'permissions', \Packages\Dashboard\App\Models\Permission::get()->pluck('slug', 'id')->toArray())
        ->class('select2')
        ->multiple()
    !!}

    {!! BootForm::reset('<i class="fa fa-undo fa-fw"></i> ' . trans('dashboard::dashboard.reset'))->class('btn btn-sm btn-default') !!}
    {!! BootForm::submit('<i class="fa fa-save fa-fw"></i> ' . trans('dashboard::dashboard.save'))->class('btn btn-sm btn-success') !!}

{!! BootForm::close() !!}

<?php

use Illuminate\Database\Seeder;
use Packages\Dashboard\App\Models\{
    Role,
    Permission
};
use Packages\Dashboard\App\Services\Config\ConfigService;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::where('slug', Role::SLUG_ADMIN)->first();
        $permissionIds = [];
        foreach ((new ConfigService)->getPermissions() as $slug) {
            $attr = compact('slug');
            $permission = Permission::firstOrCreate($attr, $attr);
            $permissionIds[] = $permission->id;
        }
        $role->permissions()->sync($permissionIds);
    }
}

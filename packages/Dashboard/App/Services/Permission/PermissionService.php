<?php

namespace Packages\Dashboard\App\Services\Permission;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Packages\Dashboard\App\Models\Permission;
use Packages\Dashboard\App\Models\Role;
use Packages\Dashboard\App\Services\Config\ConfigService;

class PermissionService
{
    private static $permissions;

    /**
     * @param string $permission
     * @return bool
     */
    public function can(string $permission): bool
    {
        $skip = [
            'dashboard.logout',
            'dashboard.index',
            'dashboard.media.redactorjs',
            'dashboard.media.delete',
            'dashboard.media.download',
            'dashboard.counters',
        ];

        if (in_array($permission, $skip)) {
            return true;
        }

        $permissions = $this->getUserItems();

        // edit -> update
        // store -> create
        $map = [
            'edit' => 'update',
            'store' => 'create',
        ];
        $action = Str::afterLast($permission, '.');
        if (isset($map[$action])) {
            $permission = str_replace($action, $map[$action], $permission);
        }

        $mapping = $this->getMapping();
        if (isset($mapping[$permission])) {
            $permission = $mapping[$permission];
        }

        return in_array($permission, $permissions);
    }

    /**
     * @return array
     */
    public function getMapping(): array
    {
        return (new ConfigService())->getPermissionsMapping();
    }

    /**
     * @param int $role_id
     * @return array
     */
    public function getRoleItems(int $role_id): array
    {
        return Permission::select([DB::raw('permissions.slug')])
            ->leftJoin('permission_role', 'permissions.id', 'permission_role.permission_id')
            ->where('permission_role.role_id', $role_id)
            ->get()
            ->pluck('slug')
            ->toArray();
    }

    /**
     * @return array
     */
    public function getUserItems(): array
    {
        if (self::$permissions === null) {
            self::$permissions = $this->getRoleItems(auth()->user()->role_id);
        }

        return self::$permissions;
    }

    public function sync()
    {
        $dataRoleSlugPermissions = [];
        foreach ((new ConfigService())->getPermissions() as $slug => $slugRoles) {
            $attr = compact('slug');
            $permission = Permission::firstOrCreate($attr, $attr);
            foreach ($slugRoles as $slugRole) {
                $dataRoleSlugPermissions[$slugRole][] = $permission->id;
            }
        }

        foreach ($dataRoleSlugPermissions as $slug => $permissionIds) {
            $role = Role::where('slug', $slug)->first();
            if ($role) {
                $role->permissions()->sync($permissionIds);
            }
        }
    }

}

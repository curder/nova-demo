<?php
namespace Database\Seeders;

use App\Enums\PermissionsEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\PermissionRegistrar;
use Curder\NovaPermission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $this->refresh(); // 刷新权限
        $this->freshCache(); // 清空缓存
        $this->generatePermissions(); // 生成权限
    }

    protected function generatePermissions()
    {
        collect($this->getPermissions())->each(function ($item, $group) {
            // create permissions for each collection item
            collect($item)->each(function ($permission) use ($group) {
                Permission::factory()->create(['group' => $group, 'name' => $permission]);
            });
        });
    }

    protected function refresh(): void
    {
        // refresh all prev permissions.
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Permission::truncate();
        DB::table(config('permission.table_names.role_has_permissions'))->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    protected function freshCache(): void
    {
        // Reset cached roles and permissions
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    protected function getPermissions()
    {
        return [
            PermissionsEnum::USERS => [
                PermissionsEnum::MANAGER_USERS,
                PermissionsEnum::VIEW_USERS,
                PermissionsEnum::CREATE_USERS,
                PermissionsEnum::UPDATE_USERS,
                PermissionsEnum::DELETE_USERS,
                PermissionsEnum::RESTORE_USERS,
                PermissionsEnum::FORCE_DELETE_USERS,
                PermissionsEnum::PERMISSION_ATTACH_ANY_USERS,
                PermissionsEnum::PERMISSION_ATTACH_USERS,
                PermissionsEnum::PERMISSION_DETACH_USERS,
            ],
            PermissionsEnum::ROLES => [
                PermissionsEnum::MANAGER_ROLES,
                PermissionsEnum::VIEW_ROLES,
                PermissionsEnum::CREATE_ROLES,
                PermissionsEnum::UPDATE_ROLES,
                PermissionsEnum::DELETE_ROLES,
                PermissionsEnum::RESTORE_ROLES,
                PermissionsEnum::FORCE_DELETE_ROLES,
                PermissionsEnum::ROLE_ATTACH_ANY_USERS,
                PermissionsEnum::ROLE_ATTACH_USERS,
                PermissionsEnum::ROLE_DETACH_USERS,
            ],
            PermissionsEnum::PERMISSIONS => [
                PermissionsEnum::MANAGER_PERMISSIONS,
                PermissionsEnum::VIEW_PERMISSIONS,
//                PermissionsEnum::CREATE_PERMISSIONS,
//                PermissionsEnum::UPDATE_PERMISSIONS,
                PermissionsEnum::DELETE_PERMISSIONS,
                PermissionsEnum::RESTORE_PERMISSIONS,
                PermissionsEnum::FORCE_DELETE_PERMISSIONS,
                PermissionsEnum::PERMISSION_ATTACH_ANY_ROLES,
                PermissionsEnum::PERMISSION_ATTACH_ROLES,
                PermissionsEnum::PERMISSION_DETACH_ROLES,
            ],
        ];
    }
}

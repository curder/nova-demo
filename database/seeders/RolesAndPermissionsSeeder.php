<?php
namespace Database\Seeders;

use App\Models\User;
use App\Enums\RolesEnum;
use App\Enums\PermissionsEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Curder\NovaPermission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Curder\NovaPermission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() : void
    {
        // 1. refresh exists table
        $this->refreshTables();

        // 2. Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 3. create permissions for each collection item
        $this->getPermissions()->each(
            fn($item, $group) => collect($item)->each(
                fn($permission) => Permission::create(['group' => $group, 'name' => $permission])
            )
        );

        // 4. Create roles and assign permissions
        collect(RolesEnum::getInstances())
            ->each(fn(RolesEnum $item) => Role::create(['name' => $item->value]))
            ->each(
                fn(RolesEnum $item) =>
                Role::findByName($item->value)->givePermissionTo(RolesEnum::permissions($item->value))
            )->each(
                fn(RolesEnum $role) => RolesEnum::users($role->value)->each(
                    fn($email) => User::where('email', $email)->first()->assignRole($role->value)
                )
            );
    }

    /**
     *
     */
    protected function refreshTables() : void
    {
        DB::beginTransaction();
        if (!app()->environment('testing')) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        DB::table(config('permission.table_names.model_has_permissions'))->truncate();
        DB::table(config('permission.table_names.role_has_permissions'))->truncate();
        DB::table(config('permission.table_names.model_has_roles'))->truncate();
        DB::table(config('permission.table_names.permissions'))->truncate();
        DB::table(config('permission.table_names.roles'))->truncate();
        if (!app()->environment('testing')) {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
        DB::commit();
    }


    protected function getPermissions(): Collection
    {
        return collect([
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
                PermissionsEnum::DELETE_PERMISSIONS,
                PermissionsEnum::RESTORE_PERMISSIONS,
                PermissionsEnum::FORCE_DELETE_PERMISSIONS,
                PermissionsEnum::PERMISSION_ATTACH_ANY_ROLES,
                PermissionsEnum::PERMISSION_ATTACH_ROLES,
                PermissionsEnum::PERMISSION_DETACH_ROLES,
            ],

            PermissionsEnum::MENUS => [
                PermissionsEnum::MANAGER_MENUS,
                PermissionsEnum::VIEW_MENUS,
                PermissionsEnum::CREATE_MENUS,
                PermissionsEnum::UPDATE_MENUS,
                PermissionsEnum::DELETE_MENUS,
            ],
        ]);
    }
}

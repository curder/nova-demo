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
        collect(RolesEnum::cases())
            ->each(fn(RolesEnum $item) => Role::create(['name' => $item->value]))
            ->each(
                fn(RolesEnum $item) =>
                Role::findByName($item->value)->givePermissionTo(RolesEnum::permissions($item->value))
            )
            ->each(
                fn(RolesEnum $role) => $role->users()->each(
                    fn($email) => User::where('email', $email)->first()->assignRole($role->value)
                )
            );
    }

    /**
     *
     */
    protected function refreshTables() : void
    {
//        DB::beginTransaction();

        if (config('database.default') !== 'sqlite') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        DB::table(config('permission.table_names.model_has_permissions'))->truncate();
        DB::table(config('permission.table_names.role_has_permissions'))->truncate();
        DB::table(config('permission.table_names.model_has_roles'))->truncate();
        DB::table(config('permission.table_names.permissions'))->truncate();
        DB::table(config('permission.table_names.roles'))->truncate();

        if (config('database.default') !== 'sqlite') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

//        DB::commit();
    }


    protected function getPermissions(): Collection
    {
        return collect([
            PermissionsEnum::USERS->value => [
                PermissionsEnum::MANAGER_USERS->value,
                PermissionsEnum::VIEW_USERS->value,
                PermissionsEnum::CREATE_USERS->value,
                PermissionsEnum::UPDATE_USERS->value,
                PermissionsEnum::DELETE_USERS->value,
                PermissionsEnum::RESTORE_USERS->value,
                PermissionsEnum::FORCE_DELETE_USERS->value,
                PermissionsEnum::PERMISSION_ATTACH_ANY_USERS->value,
                PermissionsEnum::PERMISSION_ATTACH_USERS->value,
                PermissionsEnum::PERMISSION_DETACH_USERS->value,
            ],
            PermissionsEnum::ROLES->value => [
                PermissionsEnum::MANAGER_ROLES->value,
                PermissionsEnum::VIEW_ROLES->value,
                PermissionsEnum::CREATE_ROLES->value,
                PermissionsEnum::UPDATE_ROLES->value,
                PermissionsEnum::DELETE_ROLES->value,
                PermissionsEnum::RESTORE_ROLES->value,
                PermissionsEnum::FORCE_DELETE_ROLES->value,
                PermissionsEnum::ROLE_ATTACH_ANY_USERS->value,
                PermissionsEnum::ROLE_ATTACH_USERS->value,
                PermissionsEnum::ROLE_DETACH_USERS->value,
            ],
            PermissionsEnum::PERMISSIONS->value => [
                PermissionsEnum::MANAGER_PERMISSIONS->value,
                PermissionsEnum::VIEW_PERMISSIONS->value,
                PermissionsEnum::DELETE_PERMISSIONS->value,
                PermissionsEnum::RESTORE_PERMISSIONS->value,
                PermissionsEnum::FORCE_DELETE_PERMISSIONS->value,
                PermissionsEnum::PERMISSION_ATTACH_ANY_ROLES->value,
                PermissionsEnum::PERMISSION_ATTACH_ROLES->value,
                PermissionsEnum::PERMISSION_DETACH_ROLES->value,
            ],

            PermissionsEnum::MENUS->value => [
                PermissionsEnum::MANAGER_MENUS->value,
                PermissionsEnum::VIEW_MENUS->value,
                PermissionsEnum::CREATE_MENUS->value,
                PermissionsEnum::UPDATE_MENUS->value,
                PermissionsEnum::DELETE_MENUS->value,
            ],
        ]);
    }
}

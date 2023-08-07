<?php

namespace Database\Seeders;

use App\Enums;
use App\Models;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (! app()->environment('testing')) {
            // 1. refresh exists table
            $this->refreshTables();
            // 2. Reset cached roles and permissions
            app()[PermissionRegistrar::class]->forgetCachedPermissions();
        }

        // 3. create permissions for each collection item
        $this->getPermissions()->each(
            fn ($item, $group) => collect($item)->each(
                fn ($permission) => Models\Permission::create(['name' => $permission])
            )
        );

        // 4. Create roles and assign permissions
        collect(Enums\Role::cases())
            ->each(fn (Enums\Role $item) => Models\Role::create(['name' => $item->value]))
            ->each(
                fn (Enums\Role $item) => Models\Role::findByName($item->value)->givePermissionTo(Enums\Role::permissions($item->value))
            )
            ->each(
                fn (Enums\Role $role) => $role->users()->each(
                    fn ($email) => Models\User::query()->where('email', $email)->first()->assignRole($role->value)
                )
            );
    }

    protected function refreshTables(): void
    {
        // DB::beginTransaction();

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

        // DB::commit();
    }

    protected function getPermissions(): Collection
    {
        return collect([
            Enums\Permission::Users->value => [
                Enums\Permission::ManagerUsers->value,
                Enums\Permission::ViewUsers->value,
                Enums\Permission::CreateUsers->value,
                Enums\Permission::UpdateUsers->value,
                Enums\Permission::DeleteUsers->value,
                Enums\Permission::RestoreUsers->value,
                Enums\Permission::ForceDeleteUsers->value,
                Enums\Permission::PermissionAttachAnyUsers->value,
                Enums\Permission::PermissionAttachUsers->value,
                Enums\Permission::PermissionDetachUsers->value,
            ],
            Enums\Permission::Roles->value => [
                Enums\Permission::ManagerRoles->value,
                Enums\Permission::ViewRoles->value,
                Enums\Permission::CreateRoles->value,
                Enums\Permission::UpdateRoles->value,
                Enums\Permission::DeleteRoles->value,
                Enums\Permission::RestoreRoles->value,
                Enums\Permission::ForceDeleteRoles->value,
                Enums\Permission::RoleAttachAnyUsers->value,
                Enums\Permission::RoleAttachUsers->value,
                Enums\Permission::RoleDetachUsers->value,
            ],
            Enums\Permission::Permissions->value => [
                Enums\Permission::ManagerPermissions->value,
                Enums\Permission::ViewPermissions->value,
                Enums\Permission::PermissionAttachAnyRoles->value,
                Enums\Permission::PermissionAttachRoles->value,
                Enums\Permission::PermissionDetachRoles->value,
            ],

            Enums\Permission::Menus->value => [
                Enums\Permission::ManagerMenus->value,
                Enums\Permission::ViewMenus->value,
                Enums\Permission::CreateMenus->value,
                Enums\Permission::UpdateMenus->value,
                Enums\Permission::DeleteMenus->value,
            ],

            Enums\Permission::Settings->value => [
                Enums\Permission::ViewLogs->value,
            ],
        ]);
    }
}

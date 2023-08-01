<?php

namespace Database\Seeders;

use App\Enums\PermissionsEnum;
use App\Enums\RolesEnum;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
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
                fn ($permission) => Permission::create(['name' => $permission])
            )
        );

        // 4. Create roles and assign permissions
        collect(RolesEnum::cases())
            ->each(fn (RolesEnum $item) => Role::create(['name' => $item->value]))
            ->each(
                fn (RolesEnum $item) => Role::findByName($item->value)->givePermissionTo(RolesEnum::permissions($item->value))
            )
            ->each(
                fn (RolesEnum $role) => $role->users()->each(
                    fn ($email) => User::query()->where('email', $email)->first()->assignRole($role->value)
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
            PermissionsEnum::Users->value => [
                PermissionsEnum::ManagerUsers->value,
                PermissionsEnum::ViewUsers->value,
                PermissionsEnum::CreateUsers->value,
                PermissionsEnum::UpdateUsers->value,
                PermissionsEnum::DeleteUsers->value,
                PermissionsEnum::RestoreUsers->value,
                PermissionsEnum::ForceDeleteUsers->value,
                PermissionsEnum::PermissionAttachAnyUsers->value,
                PermissionsEnum::PermissionAttachUsers->value,
                PermissionsEnum::PermissionDetachUsers->value,
            ],
            PermissionsEnum::Roles->value => [
                PermissionsEnum::ManagerRoles->value,
                PermissionsEnum::ViewRoles->value,
                PermissionsEnum::CreateRoles->value,
                PermissionsEnum::UpdateRoles->value,
                PermissionsEnum::DeleteRoles->value,
                PermissionsEnum::RestoreRoles->value,
                PermissionsEnum::ForceDeleteRoles->value,
                PermissionsEnum::RoleAttachAnyUsers->value,
                PermissionsEnum::RoleAttachUsers->value,
                PermissionsEnum::RoleDetachUsers->value,
            ],
            PermissionsEnum::Permissions->value => [
                PermissionsEnum::ManagerPermissions->value,
                PermissionsEnum::ViewPermissions->value,
                PermissionsEnum::PermissionAttachAnyRoles->value,
                PermissionsEnum::PermissionAttachRoles->value,
                PermissionsEnum::PermissionDetachRoles->value,
            ],

            PermissionsEnum::Menus->value => [
                PermissionsEnum::ManagerMenus->value,
                PermissionsEnum::ViewMenus->value,
                PermissionsEnum::CreateMenus->value,
                PermissionsEnum::UpdateMenus->value,
                PermissionsEnum::DeleteMenus->value,
            ],

            PermissionsEnum::Settings->value => [
                PermissionsEnum::ViewLogs->value,
            ],
        ]);
    }
}

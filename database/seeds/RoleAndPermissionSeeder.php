<?php

use App\Enums\PermissionsEnum;
use App\Enums\RolesEnum;
use App\Models\Auth\Permission;
use App\Models\Auth\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->assignPermissionToRole(); // 给角色赋权
        $this->giveUserToRoles(); // 将用户添加到角
    }

    protected function assignPermissionToRole()
    {
        // 超级管理员
        $superRole = Role::whereName(RolesEnum::SUPER_ADMIN_MANAGER)->first();
        $superRole->givePermissionTo(Permission::all()); // 给予所有权限

        // 编辑
        $saleRole = Role::whereName(RolesEnum::EDITOR_MANAGER)->first();
        $saleRole->givePermissionTo([
            PermissionsEnum::VIEW_USERS
        ]);
    }

    protected function giveUserToRoles()
    {
        collect(app(RoleSeeder::class)->getRoles())->each(function ($items, $role_name) {
            collect($items)->each(function ($item) use ($role_name) {
                $user = User::whereEmail($item['email'])->first();
                if (!$user) {
                    $user = factory(User::class)->create($item);
                }

                $user->assignRole($role_name);
            });
        });
    }
}

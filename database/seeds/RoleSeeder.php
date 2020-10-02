<?php
namespace Database\Seeders;

use App\Models\User;
use App\Enums\RolesEnum;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Curder\NovaPermission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $this->refresh(); // 刷新角色
        $this->freshCache(); // 清空缓存
        $this->generateRoles(); // 生成角色
    }

    protected function generateRoles()
    {
        $roles = $this->getRoles();

        collect(array_keys($roles))->each(function ($role) {
            Role::create(['name' => $role]);
        });

        collect($roles)->each(function ($items, $role_name) {
            collect($items)->each(function ($item) use ($role_name) {
                $user = User::whereEmail($item['email'])->first();
                if (!$user) {
                    $user = factory(User::class)->create($item);
                }

                $user->assignRole($role_name);
            });
        });
    }

    public function getRoles()
    {
        return [
            RolesEnum::SUPER_ADMIN_MANAGER => [
                [
                    'name' => RolesEnum::SUPER_ADMIN_MANAGER,
                    'email' => RolesEnum::SUPER_ADMIN_MANAGER.'@example.com',
                    'password' => Hash::make('aaaaaa'),
                    'email_verified_at' => now(),
                    'remember_token' => Str::random(10),
                ],
            ],
            RolesEnum::EDITOR_MANAGER => [
                [
                    'name' => RolesEnum::EDITOR_MANAGER,
                    'email' => RolesEnum::EDITOR_MANAGER.'@example.com',
                    'password' => Hash::make('aaaaaa'),
                    'email_verified_at' => now(),
                    'remember_token' => Str::random(10),
                ],
            ],
        ];
    }

    protected function refresh(): void
    {
        // refresh all prev permissions.
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Role::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    protected function freshCache(): void
    {
        // Reset cached roles and permissions
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}

<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum UserEnum: string
{
    case Super = 'super@example.com';
    case Example = 'example@example.com';

    public function can(PermissionEnum $permission): bool
    {
        return $this->hasPermissions()->containsStrict('value', $permission->value);
    }

    public function role(): array
    {
        return match ($this) {
            self::Super => [RoleEnum::SuperAdmin],
            self::Example => [RoleEnum::Content],
        };
    }

    /**
     * 是否是超级用户
     */
    public function isSuperAdmin(): bool
    {
        return $this === self::Super;
    }

    public function canImpersonate(): bool
    {
        return $this === self::Super;
    }

    public function hasPermissions(): Collection
    {
        return collect($this->role())
            ->flatMap(callback: fn (RoleEnum $role) => $role->permissions())
            ->merge($this->additionalPermissions());
    }

    /**
     * 用户除在角色下额外权限
     */
    public function additionalPermissions(): array
    {
        return match ($this) {
            self::Super => [
                //
            ],
            self::Example => [
                //
            ],
        };
    }
}

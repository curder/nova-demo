<?php

namespace App\Traits\Models;

use App\Enums;
use Laravel\Nova\Auth\Impersonatable;

/**
 * @property string $email
 */
trait InteractsWithUser
{
    use Impersonatable;

    /**
     * 判断用户是否拥有对应权限
     */
    public function allow(Enums\PermissionEnum $enum): ?bool
    {
        return $this->enumInstance()?->can($enum) ?? false;
    }

    /**
     * 是否是超级用户
     */
    public function isSuperAdmin(): ?bool
    {
        return $this->enumInstance()?->isSuperAdmin() ?? false;
    }

    /**
     * 获取对应 UserEnum 实例
     */
    private function enumInstance(): ?Enums\UserEnum
    {
        return Enums\UserEnum::tryFrom($this->email);
    }

    /**
     * 是否允许用户模拟其它用户登录
     */
    public function canImpersonate(): bool
    {
        return $this->enumInstance()?->canImpersonate() ?? false;
    }
}

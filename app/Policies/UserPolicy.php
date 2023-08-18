<?php

namespace App\Policies;

use App\Enums;
use App\Models;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class UserPolicy.
 */
class UserPolicy
{
    use HandlesAuthorization;

    /**
     * 用户列表权限
     */
    public function viewAny(Models\User $user): bool
    {
        return $user->allow(Enums\PermissionEnum::ManagerUsers);
    }

    /**
     * 用户详情页面权限
     */
    public function view(Models\User $user, Models\User $model): bool
    {
        return $user->allow(Enums\PermissionEnum::ViewUsers);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Models\User $user): bool
    {
        return false;
    }

    public function replicate(Models\User $user, Models\User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Models\User $user, Models\User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Models\User $user, Models\User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Models\User $user, Models\User $model): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        } else {
            if ($model->isSuperAdmin()) { // 普通管理员不允许编辑超级管理员
                return false;
            }
        }

        return $user->allow(Enums\PermissionEnum::UpdateUsers);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Models\User $user, Models\User $model): bool
    {
        return false;
    }
}

<?php

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Models\Menu as MenuModel;
use App\Models\User as UserModel;
use Illuminate\Auth\Access\HandlesAuthorization;

class MenuPolicy
{
    use HandlesAuthorization;

    /**
     * @param UserModel $user
     * @param string $ability
     *
     * @return bool|null
     */
    public function before(UserModel $user, $ability)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any videos.
     *
     * @param UserModel $user
     * @return bool
     */
    public function viewAny(UserModel $user): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::MANAGER_MENUS);
    }

    /**
     * Determine whether the user can view the video.
     *
     * @param UserModel $user
     * @param MenuModel $menuModel
     * @return bool
     */
    public function view(UserModel $user, MenuModel $menuModel): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::VIEW_MENUS);
    }

    /**
     * Determine whether the user can create videos.
     *
     * @param UserModel $user
     * @return bool
     */
    public function create(UserModel $user): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::CREATE_MENUS);
    }

    /**
     * Determine whether the user can update the video.
     *
     * @param UserModel $user
     * @param MenuModel $menuModel
     * @return bool
     */
    public function update(UserModel $user, MenuModel $menuModel): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::UPDATE_MENUS);
    }

    /**
     * Determine whether the user can delete the video.
     *
     * @param UserModel $user
     * @param MenuModel $menuModel
     * @return bool
     */
    public function delete(UserModel $user, MenuModel $menuModel): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::DELETE_MENUS);
    }
}

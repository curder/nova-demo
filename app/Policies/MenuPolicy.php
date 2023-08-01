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
     * @param  string  $ability
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
     */
    public function viewAny(UserModel $user): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::ManagerMenus->value);
    }

    /**
     * Determine whether the user can view the video.
     */
    public function view(UserModel $user, MenuModel $menuModel): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::ViewMenus->value);
    }

    /**
     * Determine whether the user can create videos.
     */
    public function create(UserModel $user): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::CreateMenus->value);
    }

    /**
     * Determine whether the user can update the video.
     */
    public function update(UserModel $user, MenuModel $menuModel): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::UpdateMenus->value);
    }

    /**
     * Determine whether the user can delete the video.
     */
    public function delete(UserModel $user, MenuModel $menuModel): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::DeleteMenus->value);
    }
}

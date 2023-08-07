<?php

namespace App\Policies;

use App\Enums;
use App\Models;
use Illuminate\Auth\Access\HandlesAuthorization;

class Menu
{
    use HandlesAuthorization;

    /**
     * @param  string  $ability
     * @return bool|null
     */
    public function before(Models\User $user, $ability)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any videos.
     */
    public function viewAny(Models\User $user): bool
    {
        return $user->hasPermissionTo(Enums\PermissionsEnum::ManagerMenus->value);
    }

    /**
     * Determine whether the user can view the video.
     */
    public function view(Models\User $user, Models\Menu $menu): bool
    {
        return $user->hasPermissionTo(Enums\PermissionsEnum::ViewMenus->value);
    }

    /**
     * Determine whether the user can create videos.
     */
    public function create(Models\User $user): bool
    {
        return $user->hasPermissionTo(Enums\PermissionsEnum::CreateMenus->value);
    }

    /**
     * Determine whether the user can update the video.
     */
    public function update(Models\User $user, Models\Menu $menu): bool
    {
        return $user->hasPermissionTo(Enums\PermissionsEnum::UpdateMenus->value);
    }

    /**
     * Determine whether the user can delete the video.
     */
    public function delete(Models\User $user, Models\Menu $menu): bool
    {
        return $user->hasPermissionTo(Enums\PermissionsEnum::DeleteMenus->value);
    }
}

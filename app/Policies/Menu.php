<?php

namespace App\Policies;

use App\Enums;
use App\Models;
use Illuminate\Auth\Access\HandlesAuthorization;

class Menu
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any videos.
     */
    public function viewAny(Models\User $user): bool
    {
        return $user->hasPermissionTo(Enums\Permission::ManagerMenus->value);
    }

    /**
     * Determine whether the user can view the video.
     */
    public function view(Models\User $user, Models\Menu $menu): bool
    {
        return $user->hasPermissionTo(Enums\Permission::ViewMenus->value);
    }

    /**
     * Determine whether the user can create videos.
     */
    public function create(Models\User $user): bool
    {
        return $user->hasPermissionTo(Enums\Permission::CreateMenus->value);
    }

    /**
     * Determine whether the user can update the video.
     */
    public function update(Models\User $user, Models\Menu $menu): bool
    {
        return $user->hasPermissionTo(Enums\Permission::UpdateMenus->value);
    }

    /**
     * Determine whether the user can delete the video.
     */
    public function delete(Models\User $user, Models\Menu $menu): bool
    {
        return $user->hasPermissionTo(Enums\Permission::DeleteMenus->value);
    }
}

<?php

namespace App\Policies;

use App\Enums;
use App\Models;
use Illuminate\Auth\Access\HandlesAuthorization;

class MenuPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any videos.
     */
    public function viewAny(Models\User $user): bool
    {
        return $user->allow(Enums\PermissionEnum::ManagerMenus);
    }

    /**
     * Determine whether the user can view the video.
     */
    public function view(Models\User $user, Models\Menu $menu): bool
    {
        return $user->allow(Enums\PermissionEnum::ViewMenus);
    }

    /**
     * Determine whether the user can create videos.
     */
    public function create(Models\User $user): bool
    {
        return $user->allow(Enums\PermissionEnum::CreateMenus);
    }

    /**
     * Determine whether the user can update the video.
     */
    public function update(Models\User $user, Models\Menu $menu): bool
    {
        return $user->allow(Enums\PermissionEnum::UpdateMenus);
    }

    /**
     * Determine whether the user can delete the video.
     */
    public function delete(Models\User $user, Models\Menu $menu): bool
    {
        return $user->allow(Enums\PermissionEnum::DeleteMenus);
    }
}

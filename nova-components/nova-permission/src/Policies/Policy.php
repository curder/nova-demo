<?php

namespace Curder\NovaPermission\Policies;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class Policy.
 */
class Policy
{
    use HandlesAuthorization;

    /**
     * @param $user
     * @param $ability
     *
     * @return bool
     */
    public function before($user, $ability)
    {
        /* @var \App\Models\User $user */
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     *
     * @return bool
     *
     * @throws \Exception
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create'.static::getKey());
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  $user
     *
     * @return mixed
     */
    public function delete($user, $model)
    {
        /* @var \App\Models\User $user */
        return $user->hasPermissionTo('delete'.static::getKey());
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  $user
     *
     * @return mixed
     */
    public function forceDelete($user, $model)
    {
        /* @var \App\Models\User $user */
        return $user->hasPermissionTo('forceDelete'.static::getKey());
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  $user
     *
     * @return mixed
     */
    public function restore($user, $model)
    {
        /* @var \App\Models\User $user */
        return $user->hasPermissionTo('restore'.static::getKey());
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  $user
     * @param $model
     *
     * @return mixed
     */
    public function update($user, $model)
    {
        /* @var \App\Models\User $user */
        return $user->hasPermissionTo('update'.static::getKey());
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  $user
     * @param $model
     *
     * @return mixed
     */
    public function view($user, $model)
    {
        /* @var \App\Models\User $user */
        return $user->hasPermissionTo('view'.static::getKey());
    }

    /**
     * @param $user
     *
     * @return bool
     */
    public function viewAny($user)
    {
        /* @var \App\Models\User $user */
        return $user->hasPermissionTo('manager'.static::getKey());
    }

    /**
     * @return mixed
     */
    public static function getKey()
    {
        return static::$key;
    }
}

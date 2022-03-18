<?php

namespace Curder\NovaPermission\Policies;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class Policy.
 */
class Policy
{
    use HandlesAuthorization;

    protected static string $key = '';

    /**
     * @param User $user
     * @param string $ability
     *
     * @return null|bool
     */
    public function before($user, $ability)
    {
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
     * @param User  $user
     * @param Model $model
     *
     * @return bool
     */
    public function delete($user, $model)
    {
        return $user->hasPermissionTo('delete'.static::getKey());
    }
    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Model $model
     *
     * @return mixed
     */
    public function forceDelete($user, $model)
    {
        return $user->hasPermissionTo('forceDelete'.static::getKey());
    }
    /**
     * Determine whether the user can restore the model.
     *
     * @param  User  $user
     * @param Model $model
     *
     * @return bool
     */
    public function restore($user, $model)
    {
        return $user->hasPermissionTo('restore'.static::getKey());
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Model $model
     *
     * @return bool
     */
    public function update($user, $model)
    {
        return $user->hasPermissionTo('update'.static::getKey());
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Model $model
     *
     * @return bool
     */
    public function view($user, $model)
    {
        return $user->hasPermissionTo('view'.static::getKey());
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    public function viewAny($user)
    {
        return $user->hasPermissionTo('manager'.static::getKey());
    }

    /**
     * @return string
     */
    public static function getKey()
    {
        return static::$key;
    }
}

<?php

namespace Curder\NovaPermission\Models;

/**
 * Trait SyncRole.
 */
trait SyncRole
{
    public static function bootSyncRole(): void
    {
        static::saving(function ($model) {

            if ($model->getAttributeValue('roles')) {
                $roleIds = collect($model->roles)->filter(function ($role) {
                    return $role;
                })->keys()->toArray();

                $model->roles()->sync($roleIds);
                unset($model->attributes['roles']);
            }
        });
    }
}

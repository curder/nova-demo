<?php

namespace Curder\NovaPermission\Models;

/**
 * Trait SyncRoleAndPermission.
 */
trait SyncRoleAndPermission
{
    public static function bootSyncRoleAndPermission(): void
    {
        static::saving(function ($model) {
            if ($model->getAttributeValue('roles')) {
                $roleIds = collect($model->roles)->filter()->keys()->toArray();
                $model->syncRoles($roleIds);

                unset($model->attributes['roles']);
            }

            if ($model->getAttributeValue('permissions')) {
                $permissionIds = collect($model->permissions)->filter()->keys()->toArray();
                $model->syncPermissions($permissionIds);

                unset($model->attributes['permissions']);
            }
        });
    }
}

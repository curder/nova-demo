<?php

namespace Curder\NovaPermission\Models;

use Database\Factories\PermissionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Permission as SpatiePermission;

/**
 * @property string $name
 * @property string $group
 */
class Permission extends SpatiePermission
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @return \Database\Factories\PermissionFactory
     */
    protected static function newFactory(): PermissionFactory
    {
        return PermissionFactory::new();
    }
}

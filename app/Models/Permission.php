<?php

namespace App\Models;

use Database\Factories\PermissionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as SpatiePermission;

/**
 * @property string $name
 * @property string $group
 */
class Permission extends SpatiePermission
{
    use HasFactory;

    /**
     * @return \Database\Factories\PermissionFactory
     */
    protected static function newFactory(): PermissionFactory
    {
        return PermissionFactory::new();
    }
}

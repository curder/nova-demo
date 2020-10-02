<?php

namespace Curder\NovaPermission\Models;

use Database\Factories\PermissionFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use HasFactory, SoftDeletes;

    /**
     * @return \Database\Factories\PermissionFactory
     */
    protected static function newFactory() : PermissionFactory
    {
        return PermissionFactory::new();
    }
}

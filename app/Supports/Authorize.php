<?php

namespace App\Supports;

use App\Enums;
use Closure;
use Illuminate\Http\Request;

class Authorize
{
    public static function canSeeMenus(): Closure
    {
        return static::hasPermission(Enums\Permission::ManagerMenus);
    }

    public static function canSeeLogs(): Closure
    {
        return static::hasPermission(Enums\Permission::ViewLogs);
    }

    public static function canSeeBackups(): Closure
    {
        return fn (Request $request) => $request->user()->isSuperAdmin();
    }

    private static function hasPermission(Enums\Permission $enum): Closure
    {
        return fn (Request $request) => $request->user()->hasPermissionTo($enum->value);
    }
}

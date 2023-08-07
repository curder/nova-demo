<?php

namespace App\Supports;

use App\Enums;
use Closure;
use Illuminate\Http\Request;

class Authorize
{
    public static function canSeeMenus(): Closure
    {
        return fn (Request $request) => $request->user()->hasPermissionTo(Enums\Permission::ManagerMenus->value);
    }

    public static function canSeeLogs(): Closure
    {
        return fn ($request) => $request->user()->hasPermissionTo(Enums\Permission::ViewLogs->value);
    }

    public static function canSeeBackups(): Closure
    {
        return fn (Request $request) => $request->user()->isSuperAdmin();
    }
}

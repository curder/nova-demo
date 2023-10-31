<?php

namespace App\Supports;

use Closure;
use App\Enums;
use Illuminate\Http\Request;

class Authorize
{
    public static function canSeeMenus(): Closure
    {
        return function (Request $request) {
            if (self::isSuperAdmin()($request)) {
                return true;
            }

            return self::allow(Enums\PermissionEnum::ManagerMenus)
                && \Outl1ne\MenuBuilder\Models\Menu::query()->count() > 0;
        };
    }

    public static function canSeeLogs(): Closure
    {
        return self::allow(Enums\PermissionEnum::ViewLogs);
    }

    public static function canSeeBackups(): Closure
    {
        return self::isSuperAdmin();
    }

    private static function isSuperAdmin(): Closure
    {
        return fn (Request $request) => $request->user()->isSuperAdmin();
    }

    private static function allow(Enums\PermissionEnum $enum): Closure
    {
        return fn (Request $request) => $request->user()->allow($enum);
    }
}

<?php

namespace App\Supports;

use App\Nova;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;

class Menu
{
    public static function main(): Closure
    {
        return fn (Request $request) => [
            self::mainSection()->icon('document-text')->collapsable(),
            self::systemSection()->icon('cog')->collapsable(),
        ];
    }

    public static function user(): Closure
    {
        return function (Request $request, \Laravel\Nova\Menu\Menu $menu) {
            return $menu->append([
                MenuItem::externalLink(__('password-reset::password-reset.ResetPassword'), self::url('password-reset')),
            ]);
        };
    }

    private static function mainSection(): MenuSection
    {
        return MenuSection::make(__('Main Section'), [
            //                MenuItem::resource(AdPicture::class),
            //                MenuItem::resource(Post::class)
            //                    ->withBadge(badgeCallback: fn () => \App\Models\Post::query()->count(), type: 'success'),
            //                MenuItem::resource(\App\Nova\Category::class)
            //                    ->withBadge(badgeCallback: fn () => Category::query()->count()),
            MenuItem::externalLink(__('menus.label'), self::url('menus'))->canSee(Authorize::canSeeMenus()),
            //                MenuItem::externalLink(__('MetaSeo'), self::url('/settings/meta-seo'))
            //                    ->canSee(fn (NovaRequest $request) => $request->user()->hasPermissionTo(PermissionsEnum::meta_seo_settings->value)),
            //                MenuItem::externalLink(__('URLs'), self::url('/settings/urls'))
            //                    ->canSee(fn (NovaRequest $request) => $request->user()->hasPermissionTo(PermissionsEnum::meta_seo_settings->value)),
        ]);
    }

    private static function url(string $path): string
    {
        return Str::of(config('nova.path'))->finish('/')->append($path)->toString();
    }

    private static function systemSection(): MenuSection
    {
        return MenuSection::make(__('System Section'), [
            MenuItem::externalLink(__('Backups'), self::url('backups'))->canSee(Authorize::canSeeBackups()),
            MenuItem::externalLink(__('Logs'), self::url('logs'))->withBadge(self::logsCount())->canSee(Authorize::canSeeLogs()),
            MenuItem::resource(Nova\User::class),
            MenuItem::resource(Nova\Role::class),
            MenuItem::resource(Nova\Permission::class),
        ]);
    }

    private static function logsCount(): Closure
    {
        return fn () => (string) collect(Storage::disk('logs')->files())->filter(fn (string $log) => Str::endsWith($log, '.log'))->values()->count();
    }
}

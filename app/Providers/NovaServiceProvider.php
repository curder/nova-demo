<?php

namespace App\Providers;

use App\Enums\PermissionsEnum;
use App\Nova\Permission;
use App\Nova\Role;
use App\Nova\User;
use App\Policies\PermissionPolicy;
use App\Policies\RolePolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Outl1ne\MenuBuilder\MenuBuilder;
use Spatie\BackupTool\BackupTool;
use Vyuldashev\NovaPermission\NovaPermissionTool;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        parent::boot();

        Nova::withoutNotificationCenter();

        $logs_count = collect(Storage::disk('logs')->files())->filter(fn ($log) => Str::endsWith($log, '.log'))->values()->count();

        Nova::mainMenu(callback: fn (Request $request) => [
            MenuSection::make(__('Main Section'), [
                //                MenuItem::resource(AdPicture::class),
                //                MenuItem::resource(Post::class)
                //                    ->withBadge(badgeCallback: fn () => \App\Models\Post::query()->count(), type: 'success'),
                //                MenuItem::resource(\App\Nova\Category::class)
                //                    ->withBadge(badgeCallback: fn () => Category::query()->count()),
                MenuItem::externalLink(__('menus.label'), config('nova.path').'/menus')
                    ->canSee(fn (Request $request) => $request->user()->hasPermissionTo(PermissionsEnum::ManagerMenus->value)),
                //                MenuItem::externalLink(__('MetaSeo'), config('nova.path').'/settings/meta-seo')
                //                    ->canSee(fn (NovaRequest $request) => $request->user()->hasPermissionTo(PermissionsEnum::meta_seo_settings->value)),
                //                MenuItem::externalLink(__('URLs'), config('nova.path').'/settings/urls')
                //                    ->canSee(fn (NovaRequest $request) => $request->user()->hasPermissionTo(PermissionsEnum::meta_seo_settings->value)),
            ])->icon('document-text')->collapsable(),

            MenuSection::make(__('System Section'), [
                MenuItem::externalLink(__('Backups'), config('nova.path').'/backups')
                    ->canSee(fn (Request $request) => $request->user()->isSuperAdmin()),
                MenuItem::externalLink(__('Logs'), config('log-viewer.route_path'))
                    ->withBadge(fn () => (string) $logs_count)
                    ->canSee(fn ($request) => $request->user()->hasPermissionTo(PermissionsEnum::ViewLogs->value)),
                MenuItem::resource(User::class),
                MenuItem::resource(Role::class),
                MenuItem::resource(Permission::class),
            ])->icon('cog')->collapsable(),
        ]);
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
            ->withAuthenticationRoutes()
            ->withPasswordResetRoutes()
            ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     */
    protected function gate(): void
    {
        Gate::define('viewNova', function ($user) {
            return true;
        });
    }

    /**
     * Get the cards that should be displayed on the default Nova dashboard.
     */
    protected function cards(): array
    {
        return [];
    }

    /**
     * Get the extra dashboards that should be displayed on the Nova dashboard.
     */
    protected function dashboards(): array
    {
        return [];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     */
    public function tools(): array
    {
        return [
            NovaPermissionTool::make()
                ->roleResource(Role::class)
                ->permissionResource(Permission::class)
                ->rolePolicy(RolePolicy::class)
                ->permissionPolicy(PermissionPolicy::class),
            MenuBuilder::make(),
            BackupTool::make()->canSee(fn ($request) => $request->user()->isSuperAdmin()),
        ];
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        Nova::footer(fn () => '');
        Nova::initialPath('/resources/users'); // https://nova.laravel.com/docs/4.0/installation.html#brand-logo
    }
}

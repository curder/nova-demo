<?php

namespace App\Providers;

use App\Nova\Permission;
use App\Nova\Role;
use App\Policies\PermissionPolicy;
use App\Policies\RolePolicy;
use App\Supports\Menu;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Mastani\NovaPasswordReset\PasswordReset;
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

        Nova::withBreadcrumbs();
        Nova::withoutGlobalSearch();
        Nova::withoutNotificationCenter();
        Nova::mainMenu(callback: Menu::main());
        Nova::userMenu(userMenuCallback: Menu::user());
    }

    /**
     * Register the Nova routes.
     */
    protected function routes(): void
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
            BackupTool::make(),
            PasswordReset::make(),
        ];
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        Nova::initialPath('/resources/users'); // https://nova.laravel.com/docs/4.0/installation.html#brand-logo
        Nova::footer(fn () => '<p class="text-center">Powered by <a class="link-default" href="https://github.com/curder">Curder</a></p>');
    }
}

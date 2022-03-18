<?php

namespace Curder\NovaPermission;

use Curder\NovaPermission\Policies\PermissionPolicy;
use Curder\NovaPermission\Policies\RolePolicy;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Nova;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Curder\NovaPermission\Http\Middleware\Authorize;

/**
 * Class ToolServiceProvider
 *
 * @package Curder\NovaPermission
 */
class ToolServiceProvider extends ServiceProvider
{
    /**
     * Component identifier name.
     *
     * @var string
     */
    public static $name = 'nova-permission';
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', self::$name);
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', self::$name);

        $this->app->booted(function () {
            $this->routes();
        });

        Gate::policy(config('permission.models.permission'), PermissionPolicy::class);
        Gate::policy(config('permission.models.role'), RolePolicy::class);

        Nova::serving(function (ServingNova $event) {
            Nova::translations(self::getTranslations());
        });
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova', Authorize::class])
                ->prefix('nova-vendor/' . self::$name)
                ->group(__DIR__.'/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Get the translation keys from file.
     *
     * @return array
     */
    private static function getTranslations(): array
    {
        $translationFile = resource_path('lang/vendor/'.static::$name.'/'.app()->getLocale().'.json');
        if (!is_readable($translationFile)) {
            $translationFile = __DIR__.'/../resources/lang/'.app()->getLocale().'.json';
            if (!is_readable($translationFile)) {
                return [];
            }
        }
        return json_decode(file_get_contents($translationFile), true);
    }
}

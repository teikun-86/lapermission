<?php

namespace AzizSama\LaPermission;

use AzizSama\LaPermission\Console\Commands\AssignPermission;
use AzizSama\LaPermission\Console\Commands\AssignRole;
use AzizSama\LaPermission\Console\Commands\CreatePermission;
use AzizSama\LaPermission\Console\Commands\CreateRole;
use AzizSama\LaPermission\Console\Commands\PermissionList;
use AzizSama\LaPermission\Console\Commands\RemoveRole;
use AzizSama\LaPermission\Console\Commands\RoleList;
use AzizSama\LaPermission\Middleware\PermissionMiddleware;
use AzizSama\LaPermission\Middleware\RoleMiddleware;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class LaPermissionServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations'),
            __DIR__.'/Config/lapermission.php' => config_path('lapermission.php'),
        ], 'lapermission-setup');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerBladeDirectives();
        $this->commands([
            CreatePermission::class,
            CreateRole::class,
            AssignRole::class,
            AssignPermission::class,
            RemoveRole::class,
            RoleList::class,
            PermissionList::class,
        ]);
        $this->registerMiddlewares();
        $this->registerGuard();
    }

    /**
     * Register blade directives
     * 
     * @return void
     */
    public function registerBladeDirectives()
    {
        Blade::directive('role', function ($expression) {
            if(is_array($expression))
            {
                if(auth()->user())
                {
                    if(auth()->user())
                    {

                    }
                }
                $res = false;
            }
            else
            {
                $res = false;
            }
            return "<?php if($res) { ?>";
        });

        Blade::directive('endRole', function () {
            return "<?php } ?>";
        });
    }

    /**
     * Register Middlewares
     */
    public function registerMiddlewares()
    {
        $kernel = $this->app->make(Router::class);
        $kernel->aliasMiddleware('role', RoleMiddleware::class);
        $kernel->aliasMiddleware('permission', PermissionMiddleware::class);
    }

    /**
     * Register guard
     */
    public function registerGuard()
    {
        Config::set('auth.guards.role', [
            'driver' => 'session',
            'provider' => 'users'
        ]);
        Config::set('auth.guards.permission', [
            'driver' => 'session',
            'provider' => 'users'
        ]);
    }
}
<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider {

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/';
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
        $this->mapWebDashboardRoutes();
        $this->mapWebIndexRoutes();
        $this->mapDatabaseRoutes();
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    protected function mapWebDashboardRoutes()
    {
        Route::middleware(["web", "auth", "status", "role:admin|super-admin"])
            ->group(base_path('routes/dashboard/user/web.php'));
        Route::middleware(["web", "auth", "status", "role:admin|super-admin"])
            ->group(base_path('routes/dashboard/material/web.php'));
        Route::middleware(["web", "auth", "status", "role:admin|super-admin"])
            ->group(base_path('routes/dashboard/course/web.php'));
        Route::middleware(["web", "auth", "status", "role:admin|super-admin"])
            ->group(base_path('routes/dashboard/bundle/web.php'));
        Route::middleware(["web", "auth", "status", "role:admin|super-admin"])
            ->group(base_path('routes/dashboard/media/web.php'));
    }

    protected function mapWebIndexRoutes()
    {
        route::middleware(['web', "auth", "status"])
            ->group(base_path('routes/index/discussion/web.php'));
        route::middleware(['web', "auth", "status"])
            ->group(base_path('routes/index/home/web.php'));

    }

    protected function mapDatabaseRoutes()
    {

        route::middleware(['web', "auth", "role:super-admin"])
            ->group(base_path('routes/database/checkDB.php'));
    }

}

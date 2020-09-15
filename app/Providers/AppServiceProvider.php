<?php

namespace App\Providers;

use App\Http\View\Composers\RoleComposer;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;


class AppServiceProvider extends ServiceProvider
{
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
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(["admin.users.*","admin.users.userCreate"],RoleComposer::class);

		Carbon::setLocale(env('LOCALE', 'el_GR'));
		
		Paginator::useBootstrap();
    }
}

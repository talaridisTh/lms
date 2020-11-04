<?php

namespace App\Providers;

use App\Http\View\Composers\OptionComposer;
use App\Http\View\Composers\RoleComposer;
use App\Option;
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
        View::composer(['layouts.app',"home"],OptionComposer::class);

        Carbon::setLocale(env('LOCALE', 'el_GR'));

		Paginator::useBootstrap();
    }
}

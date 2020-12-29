<?php

namespace App\Providers;

use App\Http\View\Composers\OptionComposer;
use App\Http\View\Composers\RoleComposer;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use League\Glide\Responses\LaravelResponseFactory;
use League\Glide\ServerFactory;
use League\Glide\Server;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Server::class, function($app) {

			$filesystem = $app->make("Illuminate\Contracts\Filesystem\Filesystem");

			return ServerFactory::create([
				'response' => new LaravelResponseFactory(app('request')),
            	'source' => $filesystem->getDriver(),
            	'cache' => $filesystem->getDriver(),
            	'cache_path_prefix' => '.cache',
            	'base_url' => 'img',
			]);

		});
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['*',"*"],OptionComposer::class);

        Carbon::setLocale(env('LOCALE', 'el_GR'));

		Paginator::useBootstrap();
    }
}

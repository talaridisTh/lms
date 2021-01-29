<?php

namespace App\Providers;


use App\Http\View\Composers\MailComposer;
use App\Http\View\Composers\OptionComposer;
use App\Http\View\Composers\NotificationComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
		View::composer('index.*', OptionComposer::class);
        View::composer('index.*', NotificationComposer::class);
    }
}

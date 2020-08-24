<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LoginSuccessful
{

    public function __construct()
    {
        //
    }


    public function handle($event)
    {
        //

        $event->subject = "login";
        $event->description = "Login successful";

        activity( $event->subject)
            ->by($event->user)
            ->log($event->description);
    }
}

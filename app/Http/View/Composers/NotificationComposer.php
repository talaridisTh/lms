<?php

namespace App\Http\View\Composers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NotificationComposer {

    public function compose(View $view)
    {
        if (Auth::check()) {
            $notify = null;
            $notifyTask = null;
            if (auth()->user()->getRoleNames()[0] == "student") {
                $notify = auth()->user()->courses()->with("announcement")
                    ->get()->pluck("announcement")->collapse()
                    ->collect()->where("read_at", null)->count();
            }
            if (auth()->user()->getRoleNames()[0] != "student") {
                $notifyTask = auth()->user()->courses()->whereHas("homeworks")
                    ->with("homeworks")->get()->pluck("homeworks")->collapse()->where("seen_at", null)->count();
            }
            $view->with(['notify' => $notify, 'notifyTask' => $notifyTask]);
        }
    }

}

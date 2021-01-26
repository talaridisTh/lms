<?php

namespace App\Http\View\Composers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NotificationComposer {

    public function compose(View $view)
    {
        if (Auth::check()) {
            $notify = auth()->user()->courses()->with("announcement")
                ->get()->pluck("announcement")
                ->flatten()->where("read_at", "=", null)->map(function ($item) {
                    return $item->load("comments")->where("user_id", "!=", auth()->id())->get();
                })->flatten()->isNotEmpty();
            $view->with("notify", $notify);
        }
    }

}

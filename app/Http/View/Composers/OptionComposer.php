<?php

namespace App\Http\View\Composers;

use App\Course;
use App\Option;
use App\User;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class OptionComposer {

    public function compose(View $view)
    {

        $option = [
            "title" => Option::whereName("title")->first()->value,
            "copyright" => Option::whereName("copyright")->first()->value,
            "logo" => Option::whereName("logo")->first()->value,
            "description" => Option::whereName("description")->first()->value,
            "terms" => Option::whereName("terms")->first()->value,
            "privacyPolicy" => Option::whereName("privacyPolicy")->first()->value,
            "cookiePolicy" => Option::whereName("cookiePolicy")->first()->value,
            "contactInfo" => get_object_vars(json_decode(Option::whereName("contactInfo")->first()->value)),
            "social" => get_object_vars(json_decode(Option::whereName("social")->first()->value)),
        ];



        $view->with('option', $option);
    }

}

<?php

namespace App\Http\View\Composers;

use App\Course;
use App\Media;
use App\Option;
use App\User;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class OptionComposer {

    public function compose(View $view)
    {

        $option = [
            "title" => Option::whereName("Title")->first() ? Option::whereName("Title")->first()->value : "",
            "copyright" => Option::whereName("Copyright")->first() ? Option::whereName("Copyright")->first()->value : "",
            "logo" => Option::whereName("Logo")->first() ? Option::whereName("Logo")->first()->value : "",
            "description" => Option::whereName("Description")->first() ? Option::whereName("Description")->first()->value : "",
            "terms" => Option::whereName("Terms")->first() ? Option::whereName("Terms")->first()->value : "",
            "privacyPolicy" => Option::whereName("Privacy Policy")->first() ? Option::whereName("Privacy Policy")->first()->value : "",
            "cookiePolicy" => Option::whereName("Cookie Policy")->first() ? Option::whereName("Cookie Policy")->first()->value : "",
            "contactInfo" => Option::whereName("Contact Info")->first() ? Option::whereName("Contact Info")->first()->value : "",
            "social" =>   Option::whereName("Social")->first() ? Option::whereName("Social")->first()->value : "",
        ];



        $view->with('option', $option);
    }

}

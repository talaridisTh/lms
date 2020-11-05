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

//        $test =  get_object_vars(json_decode(Option::whereName("contactInfo")->first()!=null ?  Option::whereName("contactInfo")->first()->value:"{}" ));
//       dd($test["city"]!=null?$test["city"]:"");
        $option = [
            "title" => Option::whereName("title")->first() ? Option::whereName("title")->first()->value : "",
            "copyright" => Option::whereName("copyright")->first() ? Option::whereName("copyright")->first()->value : "",
            "logo" => Option::whereName("logo")->first() ? Option::whereName("logo")->first()->value : "",
            "description" => Option::whereName("description")->first() ? Option::whereName("description")->first()->value : "",
            "terms" => Option::whereName("terms")->first() ? Option::whereName("terms")->first()->value : "",
            "privacyPolicy" => Option::whereName("privacyPolicy")->first() ? Option::whereName("privacyPolicy")->first()->value : "",
            "cookiePolicy" => Option::whereName("cookiePolicy")->first() ? Option::whereName("cookiePolicy")->first()->value : "",
            "contactInfo" => Option::whereName("contactInfo")->first() ? Option::whereName("contactInfo")->first()->value : "",
            "social" =>   Option::whereName("social")->first() ? Option::whereName("social")->first()->value : "",
        ];

        $view->with('option', $option);
    }

}

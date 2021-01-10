<?php

namespace App\Http\View\Composers;

use App\Models\Option;
use Illuminate\View\View;

class OptionComposer {

    public function compose(View $view)
    {
        $title = Option::where("name", "Title")->first()->value
            ?? "Darkpony Digital";

        $description = Option::where("name", "Description")->first()->value
            ?? "Demo Project";

        $logo = Option::where("name", "Logo")->first()->value
            ?? "/images/darkpony-logo.png";

        $copyright = Option::where("name", "Copyright")->first()->value
            ?? "DARKPONY. ALL RIGHTS RESERVED";

        $contactInfo = Option::where("name", "Contact Info")->first()->value
            ?? json_encode([
                "city" => "Θεσσαλονίκη",
                "address" => "Μακεδονίας 40",
                "zipCode" => "55535",
                "phone" => "+30 2313 008705",
                "fax" => "+30 2313 008705",
                "email" => "info@darkpony.com"
            ]);

        $social = Option::select("value")->where("name", "Social")->first()->value
            ?? json_encode([
                "facebook" => "https://www.facebook.com/Darkpony.Digital/",
                "twitter" => "https://twitter.com/darkponyltd",
                "linkedIn" => "https://www.linkedin.com/company/darkpony-digital/",
                "fourSquare" => "https://foursquare.com/v/darkpony/54c3442a498e342726b93ec6"
            ]);

        $options = (object) [
            "title" => $title,
            "copyright" => $copyright,
            "logo" => $logo,
            "description" => $description,
            "contactInfo" => json_decode($contactInfo),
            "social" =>   json_decode($social),
            "seen"=>auth()->user() ?json_decode(auth()->user()->seen):""
        ];

        $view->with("options", $options);
    }

}

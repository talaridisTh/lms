<?php

namespace Database\Seeders;

use App\Models\Option;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Option::create([
            "name" => "Title",
            "value" => "Darkpony",
            "slug" => "title"
        ]);

        Option::create([
            "name" => "Copyright",
            "value" => "DARKPONY. ALL RIGHTS RESERVED",
            "slug" => "copyright"
        ]);

        Option::create([
            "name" => "Logo",
            "value" => "/storage/images/2020.11/logo.png",
            "slug" => "logo"
        ]);

        Option::create([
            "name" => "Description",
            "value" => "",
            "slug" => "description"
        ]);

        Option::create([
            "name" => "Terms of Use",
            "value" => "",
            "slug" => "terms-of-use"
        ]);

        Option::create([
            "name" => "Privacy Policy",
            "value" => "",
            "slug" => "privacy-policy"
        ]);

        Option::create([
            "name" => "Cookie Policy",
            "value" => "",
            "slug" => "cookie-policy"
        ]);

        Option::create([
            "name" => "Contact Info",
            "value" => json_encode([
                
                "city" => "Θεσσαλονίκη",
                "address" => "Μακεδονίας 40",
                "zipCode" => "55535",
                "phone" => "+30 2313 008705",
                "fax" => "+30 2313 008705",
                "email" => "info@darkpony.com"
                
            ]),
            "slug" => "contact-info"
        ]);

        Option::create([
            "name" => "Social",
            "value" => json_encode([
                "facebook" => "https://www.facebook.com/Darkpony.Digital/",
                "twitter" => "https://twitter.com/darkponyltd",
                "linkedIn" => "https://www.linkedin.com/company/darkpony-digital/",
				"instagram" => "",
				"youtube" => ""
            ]),
            "slug" => "social"
        ]);

        Option::create([
            "name" => "Course Templates",
            "value" => json_encode([
                "course-default" => [
                    "abbr" => "course-default",
                    "title" => "Default",
                    "views" => [
                        "backend" => "admin.courses.course",
                        "frontend" => "index.courses.template-1.courseProfile"
                    ]
                ],
                "course-alternative" => [
                    "abbr" => "course-alternative",
                    "title" => "Alternative",
                    "views" => [
                        "backend" => "admin.courses.course",
                        "frontend" => "index.courses.template-2.courseProfile"
                    ]
                ]
            ]),
            "slug" => "course-templates"
        ]);

        Option::create([
            "name" => "Image Dimensions",
            "value" => json_encode([
                "thumbnail" => [
                    "style" => [
                        "w" => 400,
                        "h" => 400,
                        "fit" => "crop"
                    ]
                ],
                "card-small" => [
                    "style" => [
                        "w" => 400,
                        "h" => 225,
                        "fit" => "crop"
                    ]
                ],
                "card-medium" => [
                    "style" => [
                        "w" => 600,
                        "h" => 377,
                        "fit" => "crop"
                    ]
                ],
                "rounded-small" => [
                    "style" => [
                        "w" => 100,
                        "h" => 100,
                        "fit" => "crop"
                    ]
                ],
                "rounded-medium" => [
                    "style" => [
                        "w" => 200,
                        "h" => 200,
                        "fit" => "crop"
                    ]
                ]
            ]),
            "slug" => "image-dimensions"
        ]);

        Option::create([
            "name" => "Index Carousels",
            "value" => json_encode([
                "primary" => [
                    "models" => [],
                    "status" => 0
                ],
                "secondary" => [
                    "models" => [],
                    "status" => 0
                ]
            ]),
            "slug" => "index-carousels"
        ]);

    }
}

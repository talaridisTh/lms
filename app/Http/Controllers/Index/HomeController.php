<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Material;
use App\Models\Option;
use Carbon\Carbon;

class HomeController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Material $material)
    {
        $arrayBanners = json_decode(Option::where("name", "Index Carousels")->pluck("value")->first());
        $arrayBanners = collect($arrayBanners);

//        dd($arrayBanners);
        return view("index.home", compact("arrayBanners"));

    }

    public function updateAnnouncementMessage()
    {
        $test = auth()->user()->courses()->with("announcement")
            ->get()->pluck("announcement")
            ->flatten()->each(function ($annou) {

                $annou->read_at = Carbon::now();
                $annou->save();

            });

        return response()->json(auth()->user());
    }

    public function test()
    {

        $course = Course::find(3);
        dd($course->users()->whereHas("roles", function ($role) {
            $role->where("name", "!=", "student");
        })->get()->unique("id"));
//        $models = User::all();
//        foreach ($models as $model) {
////            $model->update(["dark_mode", false]);
//            Message::create([
//                "type" => "user",
//                "id" => $model->id,
//                "from_id" => $model->id,
//                "to_id" => 1,
//                "body" => 'Καλησπέρα ',
//            ]);
//        }
//
//        return;
//        $models = User::all();
//        $models->each(function ($item) {
//            $item->update(
//                ['seen' => '{
//                    "seen_message": 0,
//                     "seen_task": 0
//                    }'
//                ]);
//            $item->update(["dark_mode" => 1]);
//            $item->update(["name" => $item->first_name . " " . $item->last_name]);
//        });
    }

}

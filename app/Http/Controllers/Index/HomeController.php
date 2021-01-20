<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\Option;
use App\Models\User;
use Schema;

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

    public function updateSeenMessage()
    {
        auth()->user()->update(["seen->seen_message" => 0]);

        return response()->json(auth()->user());
    }

    public function updateTaskMessage()
    {
        auth()->user()->update(["seen->seen_task" => 0]);

        return response()->json(auth()->user());
    }

    public function test()
    {

        $models = User::all();
        $models->each(function ($item) {
            $item->update(
                ['seen' => '{
                    "seen_message": 0,
                     "seen_task": 0
                    }'
                ]);
            $item->update(["dark_mode" => 1]);
            $item->update(["name" => $item->first_name . " " . $item->last_name]);
        });

    }

}

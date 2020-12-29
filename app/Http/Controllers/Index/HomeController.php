<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Material;
use App\Models\Option;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Schema;

class HomeController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Material $material)
    {

        $arrayBanners = json_decode(Option::where("name","Index Carousels")->pluck("value")->first());
        $arrayBanners = collect($arrayBanners);

        return view("tailwind-home", compact("arrayBanners"));
    }

//    public function createLinkStore(Request $request)
//    {
//
//        $user = User::find($request->user_id);
//        $tempUrl = URL::temporarySignedRoute('link', now()->addMinutes(240));
//        $data = [
//            "course_id" => $request->course_id,
//        ];
//        $user->guest()->attach($data, ['user_link' => $tempUrl]);
//
//        return redirect(route('user.showLinks'))->with('create', "Το Url δημιουργήθηκε");
//    }
//
//    public function showLinks()
//    {
//
//        $userCurent = auth()->user()->guest;
//        $usersOnlyAdmin = User::all()->map(function ($user) {
//            if ($user->guest()->exists())
//            {
//                return $user->guest;
//            }
//        })
//            ->reject(function ($name) {
//                return empty($name);
//            });
//        $usersLeft = [];
//        foreach (User::all() as $user)
//        {
//
//            if ($user->guest()->exists())
//            {
////
//                if (count($user->guest) > 1)
//                {
//                    foreach ($user->guest as $u)
//                    {
//                        array_push($usersLeft, $this->left($u->pivot->created_at));
//                    }
//                } else
//                {
//
//                    array_push($usersLeft, $this->left($user->guest[0]->pivot->created_at));
//                }
//            }
//        }
//        foreach ($usersOnlyAdmin as $user)
//        {
//            foreach ($user as $u)
//            {
//                $date = Carbon::now()->subMinutes(240);
//                if ($u->pivot->created_at < $date)
//                {
//                    $u->pivot->delete();
//                }
////
//            }
//        }
//
//        return view("index.guest.view-links", compact("userCurent", "usersOnlyAdmin", "usersLeft"));
//    }
//
//    public function left($hour)
//    {
//
//        $minutes = Carbon::now()->diffInMinutes($hour, false) + 240;
//        $zero = new DateTime();
//        $offset = new DateTime('@' . $minutes * 60);
//        $diff = $zero->diff($offset);
//
//        return $diff->format('Απομένουν %h Ωρες, %i Λεπτα');
//    }

    public function test()
    {

//        $url = '/storage/files/2020.12/zoom216.pdf';
//        $datos = file_get_contents($url);
        $file = storage_path('app/public/files/2020.12/zoom216.pdf');

//
    }

}

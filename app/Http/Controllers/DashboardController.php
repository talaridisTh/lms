<?php

namespace App\Http\Controllers;

use App\Course;
use App\User;
use App\Bundle;
use App\Material;
use Carbon\Carbon;
use DateTime;
use Facade\FlareClient\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class DashboardController extends Controller
{

    public function index()
    {
        return view('admin.overview.overviewMain');
	}

	public function dashboardSearch(Request $request) {

		$users = User::where(function($query) use ($request) {

			$query->where("last_name", "LIKE", "%$request->search%")
				->orWhere("first_name", "LIKE", "%$request->search%")
				->orWhere("email", "LIKE", "%$request->search%")
				->orWhere("phone", "LIKE", "%$request->search%")->get();

		})->get();

		$materials = Material::where(function($query) use ($request) {

			$unwatned = ["Video", "Link", "Announcement", "Section"];

			$query->where("title", "LIKE", "%$request->search%")
				->whereNotIn("type", $unwatned)->get();

		})->get();

		$courses = Course::where("title", "LIKE", "%$request->search%")->get();
		$bundles = Bundle::where("title", "LIKE", "%$request->search%")->get();

		$totalCount = $users->count() + $materials->count() + $courses->count() + $bundles->count();

		if ( $users->count() == 1 && $totalCount == 1 ) {

			return redirect( "/dashboard/users/".$users->first()->slug );

		}
		elseif ( $materials->count() == 1 && $totalCount == 1 ) {

			return redirect( "/dashboard/material/".$materials->first()->slug );

		}
		elseif ( $courses->count() == 1 && $totalCount == 1 ) {

			return redirect( "/dashboard/course/".$courses->first()->slug );

		}
		elseif ( $bundles->count() == 1 && $totalCount == 1 ) {

			return redirect( "/dashboard/bundle/".$bundles->first()->slug );

		}
		else {
			$data = [
				"search" => $request->search,
				'users' => $users,
				'materials' => $materials,
				'courses' => $courses,
				'bundles' => $bundles,
				'totalCount' => $totalCount
			];

			return View("admin/searchResults")->with($data);
		}

	}

    public function createLink()
    {

        $partners = User::getPartner();
        $courses = Course::orderBy("id", 'asc')->get();

        return view("create-link", compact("partners", "courses"));
    }

    public function createLinkStore(Request $request)
    {

        $user = User::find($request->user_id);
        $tempUrl = URL::temporarySignedRoute('link', now()->addMinutes(240));
        $data = [
            "course_id" => $request->course_id,
        ];
        $user->guest()->attach($data, ['user_link' => $tempUrl]);

        return redirect(route('user.showLinks'))->with('create', "Το Url δημιουργήθηκε");
    }

    public function showLinks()
    {

        $userCurent = auth()->user()->guest;
        $usersOnlyAdmin = User::all()->map(function ($user) {
            if ($user->guest()->exists())
            {
                return $user->guest;
            }
        })
            ->reject(function ($name) {
                return empty($name);
            });
        $usersLeft = [];
        foreach (User::all() as $user)
        {

            if ($user->guest()->exists())
            {
//
                if (count($user->guest) > 1)
                {
                    foreach ($user->guest as $u)
                    {
                        array_push($usersLeft, $this->left($u->pivot->created_at));
                    }
                } else
                {

                    array_push($usersLeft, $this->left($user->guest[0]->pivot->created_at));
                }
            }
        }
        foreach ($usersOnlyAdmin as $user)
        {
            foreach ($user as $u)
            {
                $date = Carbon::now()->subMinutes(240);
                if ($u->pivot->created_at < $date)
                {
                    $u->pivot->delete();
                }
//
            }
        }

        return view("view-links", compact("userCurent", "usersOnlyAdmin", "usersLeft"));
    }

    public function left($hour)
    {

        $minutes = Carbon::now()->diffInMinutes($hour, false) + 240;
        $zero = new DateTime('@0');
        $offset = new DateTime('@' . $minutes * 60);
        $diff = $zero->diff($offset);

        return $diff->format('Απομένουν %h Ωρες, %i Λεπτα');
    }


}

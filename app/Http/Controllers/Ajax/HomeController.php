<?php

namespace App\Http\Controllers\Ajax;

use App\Course;
use App\Http\Controllers\Controller;
use App\Material;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class HomeController extends Controller {

    //
    public function createLink()
    {

        $partners = User::getPartner();
        $courses = Course::orderBy("id", 'asc')->get();


        return view("index.guest.create-link", compact("partners", "courses"));
    }


    public function guestCourse(Request $request)
    {


        $partnerName = User::findOrFail($request->userId)->first_name;
        $guestUser = User::whereFirstName($partnerName . "-guest")->first();
        $courses = User::findOrFail($request->userId)->courses;

        if ($guestUser)
        {

            $courseGuest = $guestUser->courses;
            $materialGuest = $guestUser->guestMaterial;


            return view("index.guest.guest-course", compact('courses', "courseGuest", "materialGuest","guestUser"));
        }

        return view("index.guest.guest-course", compact('courses'));
    }

    public function guestInstructor(Request $request)
    {

        $instructor = User::findOrFail($request->userId);

        return view("index.guest.guest-instructor", compact('instructor'));
    }

    public function guestInstructorCourse(Request $request)
    {

        $courses = Course::findOrFail($request->courseId);

        return view("index.guest.guest-instructor-course", compact('courses'));
    }

    public function guestInstructorMaterial(Request $request)
    {

        $materials = Material::findOrFail($request->materialId);

        return view("index.guest.guest-instructor-material", compact('materials'));
    }

    public function createGuestUser(Request $request)
    {

//        dd($request->all());
        $partner = User::findOrFail($request->userId);
        static $counter = 0;
        if (!User::where("first_name", $partner->first_name . '-guest')->exists())
        {

            $user = User::create([
                "first_name" => $partner->first_name . '-guest',
                "slug" => Str::slug($partner->first_name.$partner->last_name, '-'),
                "last_name" => $partner->last_name . '-guest',
                "email" => $partner->email . rand(1, 9999),
                "phone" => $partner->phone,
                "cover" => $partner->cover,
                "password" => "password",
            ])->assignRole("guest");
        } else
        {
            $user = User::where("first_name", $partner->first_name . '-guest')->first();
        }

        $partner->guest()->detach($user);
        $partner->guest()->attach($user->id, ['user_link' => "/guest/temp/link/" . $user->slug]);

        $user->guestMaterial()->detach();
        foreach ($request->materialId as $data)
        {
            $user->guestMaterial()->attach($data["material"],["course_id"=>$data["courses"]]);

        }


        $user->courses()->update(["status" => 1]);
        $user->courses()->sync($request->courseId);


//        $user->guestMaterial()->sync([$request->materialId => ['course_id' => 2]]);
    }

    public function tempLink($user)
    {

        $urlEnd = array_slice(explode('/', url()->current()), - 1)[0];
        $user = User::where("slug", $urlEnd)->firstOrFail();
        if ($user->getRoleNames()[0] == "guest")
        {
            Auth::login($user);


            return redirect(route("index.courses", $urlEnd));
        } else
        {
            abort(404);
        }
    }

}

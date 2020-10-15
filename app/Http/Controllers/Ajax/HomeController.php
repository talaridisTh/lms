<?php

namespace App\Http\Controllers\Ajax;

use App\Course;
use App\Http\Controllers\Controller;
use App\Material;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    //
    public function guestCourse(Request $request)
    {

        $courses = User::findOrFail($request->userId)->courses;



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


        $partner = User::findOrFail($request->userId);
        $guestEmail = "";

        static $counter = 0;



        $user = User::create([
            "first_name"=>$partner->first_name.'-guest',
            "slug"=>Str::slug($partner->last_name, '-'),
            "last_name"=>$partner->last_name.'-guest',
            "email"=>$partner->email.rand(1,9999),
            "phone"=>$partner->phone,
            "cover"=>$partner->cover,
            "password"=>"password",

        ])->assignRole("guest");

        $user->courses()->sync($request->courseId);
        $user->courses()->update(["status"=>1]);

        $user->materials()->sync($request->materialId);
        $user->materials()->update(["status"=>1]);

    }
}

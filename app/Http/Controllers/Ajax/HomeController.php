<?php

namespace App\Http\Controllers\Ajax;

use App\Course;
use App\Http\Controllers\Controller;
use App\Material;
use App\User;
use Illuminate\Http\Request;

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
}

<?php

namespace App\Http\Controllers\Index;

use App\Course;
use App\Http\Controllers\Controller;
use App\Topic;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    //
    public function show(Course $course)
    {

        $topics = [];
       foreach (auth()->user()->courses as $course){
//           $topics =Course::with('topics')->find($course->id)->topics()->pluck("title")->toArray();
             array_push($topics,Course::with('topics',"materials")->find($course->id)->topics()->pluck("title")->toArray());
       }

        $colectTopics = collect($topics);

//       dd(Course::with('topics')->find($course->id)->topics()->get());



        dump(Course::with('topics')->find($course->id)->topics()->with("materials")->get());

        $arrayTopics = array_unique($colectTopics->flatten()->toArray(), SORT_REGULAR);


        return view("courses.courses",compact("arrayTopics"));
    }

    public function userCourse(Course $course)
    {


        $topics = Course::with('topics')->find($course->id)->topics()->pluck("title")->toArray();

        $lastMaterial = $course->materials()->orderBy("priority")->wherePivotIn("status",[1])->get();;

        $allMaterial = $course->materials()->orderBy("priority")->wherePivotIn("status",[1])->get();



        return view("courses.courseProfile",compact('course',"lastMaterial","topics","allMaterial"));

    }
}

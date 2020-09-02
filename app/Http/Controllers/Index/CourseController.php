<?php

namespace App\Http\Controllers\Index;

use App\Course;
use App\Http\Controllers\Controller;
use App\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    //
    public function show(Course $course)
    {

        $topics = [];

        if (request()->ajax()){

            return Topic::with("courses")->whereIn("id",[$topic])->first()->courses()->whereIn("id",[$course])->get();
        }

       foreach (auth()->user()->courses as $course){
//           $topics =Course::with('topics')->find($course->id)->topics()->pluck("title")->toArray();
             array_push($topics,Course::with('topics',"materials")->find($course->id)->topics()->pluck("title","id")->toArray());
       }
//


        $arrayTopics=  collect($topics)->mapWithKeys(function($q) {
            return $q;
        });

//        dd($arrayTopics);






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

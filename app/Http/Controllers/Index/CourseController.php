<?php

namespace App\Http\Controllers\Index;

use App\Course;
use App\Http\Controllers\Controller;
use App\Option;
use App\Topic;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class CourseController extends Controller {

    //
    public function show(Course $course)
    {

        $topics = [];
        foreach (auth()->user()->courses as $course)
        {
//           $topics =Course::with('topics')->find($course->id)->topics()->pluck("title")->toArray();
            array_push($topics, Course::with('topics', "materials")->find($course->id)->topics()->pluck("title", "id")->toArray());
        }
//
        $arrayTopics = collect($topics)->mapWithKeys(function ($q) {
            return $q;
        });

        if (request()->idsTopic == "reset" || !request()->ajax())
        {
            $allCourses = auth()->user()->courses;

            return view("index.courses.courses", [
                'arrayTopics' => $arrayTopics,
                'allCourses' => $allCourses]);
        } else
        {

            $queryAllCourse = DB::table('courses')
                ->select("courses.*")
                ->join("course_user", "course_user.course_id", "=", "courses.id")
                ->join("topicables", "topicables.topicable_id", "=", "courses.id")
                ->join("topics", "topicables.topic_id", "=", "topics.id")
                ->where('course_user.user_id', "=", auth()->user()->id)
                ->where("topicables.topicable_type", "like", '%Course%')
                ->where("topics.id", "=", request()->idsTopic)
                ->get();
//
            $allCourses = $queryAllCourse->map(function ($test) {
                return Course::whereIn('id', [$test->id])->get();
            });

            return view("index.courses.courses", [
                'arrayTopics' => $arrayTopics,
                'allCourses' => $allCourses->flatten(1)]);
        }
    }

    public function userCourse(Course $course)
    {



        $topics = Course::with('topics')->find($course->id)->topics()->pluck("title")->toArray();
        $lastMaterial = $course->materials()
            ->where("type", "!=", "Announcement")
            ->orderBy("priority")
            ->wherePivotIn("status", [1])->get();

        if(auth()->user()->getRoleNames()[0]==="guest"){
//            dd(auth()->user()->guestMaterial()->get());

            $allMaterial = auth()->user()->guestMaterial()
                ->where("type", "!=", "Announcement")
                ->wherePivotIn("course_id", [$course->id])
                ->get();
        }
        else{
            $allMaterial = $course->materials()
                ->where("type", "!=", "Announcement")
                ->orderBy("priority")
                ->wherePivotIn("status", [1])->get();
        }



        $announcements = $course->materials()
            ->where("type", "Announcement")
            ->orderBy("priority")
            ->wherePivotIn("status", [1])->get();


        $option = Option::all();


<<<<<<< HEAD
//        $view = json_decode($test->last()->value,true)[$course->templ
//ate]["views"]["frontend"];



=======
//         $view = json_decode($test->last()->value,true)[$course->template]["views"]["frontend"];


>>>>>>> 81dd2d23b300a7e4fbc9159e2e4b14115fc4adf2
        return view($course->template, compact('course', "lastMaterial", "topics", "allMaterial", "announcements"));
    }

    public function watchlistCourse(Request $request)
    {


        $watchlist = User::findOrFail($request->userId)
            ->watchlistCourse()->where('watchlistable_id', $request->modelId)->first();
        if (isset($watchlist))
        {

            User::findOrFail($request->userId)
                ->watchlistCourse()
                ->detach($request->modelId);

            return response("remove");
        } else
        {
            User::findOrFail($request->userId)
                ->watchlistCourse()
                ->sync($request->modelId, false);

            return response("add");
        }
    }

}

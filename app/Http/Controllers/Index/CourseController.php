<?php

namespace App\Http\Controllers\Index;

use App\Models\Course;
use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\Post;
use App\Traits\hasComments;
use App\Models\User;
use App\Traits\UrlCreator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class CourseController extends Controller {

    use hasComments, UrlCreator;

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
        $post = Post::where("title", $course->title)->first();
        $topics = Course::with('topics')->find($course->id)->topics()->pluck("title")->toArray();
        $lastMaterial = $course->materials()
            ->where("type", "!=", "Announcement")
            ->orderBy("priority")
            ->wherePivotIn("status", [1])->get();
        if (auth()->user()->getRoleNames()[0] === "guest")
        {
//            dd(auth()->user()->guestMaterial()->get());
            $allMaterial = auth()->user()->guestMaterial()
                ->where("type", "!=", "Announcement")
                ->wherePivotIn("course_id", [$course->id])
                ->get();
        } else
        {
            $allMaterial = $course->materials()
                ->where("type", "!=", "Announcement")
                ->orderBy("priority")
                ->wherePivotIn("status", [1])->get();
        }
        $announcements = $course->materials()
            ->where("type", "Announcement")
            ->orderBy("priority")
            ->wherePivotIn("status", [1])->get();

        return view($course->template, compact('course', "lastMaterial", "topics", "allMaterial", "announcements", "post"));
    }

    public function showCourse(Course $course)
    {
        $user = auth()->user();
        $lessons = $user->courses()->with("materials")->get()->pluck("materials")->flatten()->whereIn("type", ["Lesson", "Video", "Link","PDF"])->unique("slug");
        $countMaterial = $user->courses()->wherehas("materials")->get()->pluck("materials")->flatten()->where("type", "Section")->map(function ($material) {
            return count($material->chapters);
        })->toArray();

        return view("index.courses.template-1.courseProfile", [
            "course" => Course::find(2),
            "lessons" => $lessons,
            "announcements" => $user->courses()->with("materials")->get()->pluck("materials")->flatten()->where("type", "Announcement")->unique("slug"),
            "sections" => $user->courses()->wherehas("materials")->get()->pluck("materials")->flatten()->where("type", "Section")->unique("slug"),
            "sumMaterial" => array_sum($countMaterial) + count($lessons),
            "curator" => User::FindOrFail(isset($course->user_id) ? $course->user_id : User::where("first_name", "Υδρόγειος")->first()->id),
            "fields" => $this->getFieldsCourse($course)
        ]);
    }

    public function showMaterial(Course $course, Material $material)
    {

        return view("tailwind-course-material", [
            "material" => $material,
            "fields" => $this->getFieldsMaterial($material)
        ]);
    }

    public function userCourses()
    {


        return view("tailwind-user-courses",[
            "courses"=>auth()->user()->courses
        ]);
    }

    private function getFieldsMaterial(Material $course)
    {
        $courseFields = $course->fields;
        $fields = new stdClass();
        foreach (json_decode($courseFields) as $key => $field)
        {

            if (isset($course["$key"]) && $field)
            {
                $fields->$key = $field;
            } else
            {
                $fields->$key = 0;
            }
        }
        if ($course->media->where("type", 0)->isNotEmpty())
        {
            $fields->media = 1;
        } else
        {
            $fields->media = 0;
        }
        if ($course->media->where("type", 1)->isNotEmpty())
        {
            $fields->file = 1;
        } else
        {
            $fields->file = 0;
        }

        return $fields;
    }

    private function getFieldsCourse(Course $course)
    {
        $courseFields = $course->fields;
        $fields = new stdClass();
        foreach (json_decode($courseFields) as $key => $field)
        {

            if (isset($course["$key"]) && $field)
            {
                $fields->$key = $field;
            } else
            {
                $fields->$key = 0;
            }
        }
        if ($course->media->where("type", 0)->isNotEmpty())
        {
            $fields->media = 1;
        } else
        {
            $fields->media = 0;
        }
        if ($course->media->where("type", 1)->isNotEmpty())
        {
            $fields->file = 1;
        } else
        {
            $fields->file = 0;
        }

        return $fields;
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

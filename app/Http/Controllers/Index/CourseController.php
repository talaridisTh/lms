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
    public function showCourse(Course $course)
    {

        $user = auth()->user();
        $sections = $user->courses()->where("courses.id", $course->id)->wherehas("activeMaterials")->get()->pluck("activeMaterials")->flatten()->where("type", "Section")->unique("slug");
        $materials = $this->getMaterial($user, $sections, $course);

        return view("index.courses.template-1.courseProfile", [
            "course" => Course::find($course->id),
            "lessons" => $materials["lessons"],
            "announcements" => $user->courses()->where("courses.id", $course->id)->with("activeMaterials")->get()->pluck("activeMaterials")->flatten()->where("type", "Announcement")->unique("slug"),
            "sections" => $sections,
            "sumMaterial" => count($materials["section"]) + count($materials["lessons"]),
            "curator" => User::FindOrFail(isset($course->user_id) ? $course->user_id : User::where("first_name", "Υδρόγειος")->first()->id),
            "fields" => $this->getFieldsCourse($course),
            "countSection" => 0,
            "isSectionExist" => $materials["section"]->flatten()
        ]);
    }

    public function showMaterial(Course $course, Material $material)
    {

        return view("index.courses.template-1.course-material", [
            "material" => $material,
            "fields" => $this->getFieldsMaterial($material)
        ]);
    }

    public function userCourses()
    {
        $courses = auth()->user()->courses;
        $user = auth()->user();
        $countLessons = [];
        foreach ($courses as $course)
        {
            $sections = $user
                ->courses()
                ->where("courses.id", $course->id)->wherehas("activeMaterials")->get()
                ->pluck("activeMaterials")->flatten()->where("type", "Section")->unique("slug");
            $materials = $this->getMaterial($user, $sections, $course);
            $countMaterial = count($materials["section"]) + count($materials["lessons"]);
            $countLessons[$course->slug] = ["lesson"=>$countMaterial,"extra-file"=>$course->media()->where("type",1)->count()];
        }


        return view("index.users.user-courses", [
            "courses" => $courses,
            "countLessons"=>$countLessons
        ]);
    }

//todo  na ta allaksw auta
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

    private function getMaterial($user, $sections, $course)
    {
        $lessons = $user->courses()->where("courses.id", $course->id)->with("activeMaterials")->get()->pluck("activeMaterials")->flatten()->whereIn("type", ["Lesson", "Video", "Link", "PDF"])->unique("slug");
        $countMaterial = $user->courses()->where("courses.id", $course->id)->wherehas("activeMaterials")->get()->pluck("activeMaterials")->flatten()->where("type", "Section")->map(function ($material) {
            return count($material->chapters);
        })->toArray();
        $isSectionExist = $sections->map(function ($section) {
            if ($section->activeChapters->isNotEmpty())
            {
                return $section->activeChapters;
            }
        })->reject(function ($name) {
            return empty($name);
        });

        return ["lessons" => $lessons, "section" => $isSectionExist];
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

<?php

namespace App\Http\Controllers\Index;

use App\Models\Course;
use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\Post;
use App\Traits\HasComments;
use App\Models\User;
use App\Traits\UrlCreator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class CourseController extends Controller {

    use HasComments, UrlCreator;

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
            "fields" => $this->getFields($course),
            "countSection" => 0,
            "isSectionExist" => $materials["section"]->flatten()
        ]);
    }

    public function showMaterial(Course $course, Material $material)
    {

        if($material->type =="Video"){
            $material->update(["fields"=>null]);
        }
        if($material->type =="PDF"){
            $description = isset(json_decode($material->fields)->description)?1:0;
            $material->update(["fields"=>["description"=>$description]]);

        }
        if($material->type =="Lesson"){
            $fields = [
                "summary" => isset(json_decode($material->fields)->summary)?json_decode($material->fields)->summary:0,
                "description" => isset(json_decode($material->fields)->description)?json_decode($material->fields)->description:0,
                "content" => isset(json_decode($material->fields)->content)?json_decode($material->fields)->content:0,
                "script" => isset(json_decode($material->fields)->script)?json_decode($material->fields)->script:0,
            ];

            $fieldsEncode = json_encode($fields);
            $material->update(["fields"=>$fieldsEncode]);

        }
        return view("index.courses.template-1.course-material", [
            "curator" => User::FindOrFail(isset($course->user_id) ? $course->user_id : User::where("first_name", "Υδρόγειος")->first()->id),
            "material" => $material,
            "fields" => $this->getFields($material)
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
            $countLessons[$course->slug] = ["lesson" => $countMaterial, "extra-file" => $course->media()->where("type", 1)->count()];
        }

        return view("index.users.user-courses", [
            "courses" => $courses,
            "countLessons" => $countLessons
        ]);
    }

    private function getFields($course)
    {

        if($course->type =="Video"){
            return ;
        }
        elseif($course->type =="PDF"){
            $courseFields = json_encode($course->fields);

        }
        else{
            $courseFields = $course->fields;

        }


//        dd($courseFields);
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

}

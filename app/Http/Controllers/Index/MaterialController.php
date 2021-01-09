<?php

namespace App\Http\Controllers\Index;

use App\Models\Course;
use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\Post;
use App\Traits\HasComments;
use App\Models\User;
use Illuminate\Http\Request;
use stdClass;

class MaterialController extends Controller {

    use HasComments;

    public function material(Course $course, Material $material)
    {
        $course = Course::find(1);
        $material = Material::find(1);




        $user = auth()->user();
        $sections = $user->courses()->where("courses.id", $course->id)->wherehas("activeMaterials")->get()->pluck("activeMaterials")->flatten()->where("type", "Section")->unique("slug");
        $materials = $this->getMaterial($user, $sections, $course);

        return view("index.materials.index-material", [
            "course" => Course::find($course->id),
            "material" => $material,
            "lessons" => $materials["lessons"],
            "announcements" => $user->courses()->where("courses.id", $course->id)->with("activeMaterials")->get()->pluck("activeMaterials")->flatten()->where("type", "Announcement")->unique("slug"),
            "sections" => $sections,
            "sumMaterial" => count($materials["section"]) + count($materials["lessons"]),
            "curator" => User::FindOrFail(isset($course->user_id) ? $course->user_id : User::where("first_name", "Υδρόγειος")->first()->id),
            "fields" => $this->getFields($material),
            "countSection" => 0,
            "isSectionExist" => $materials["section"]->flatten()
        ]);
    }

    private function getFields($course)
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

}

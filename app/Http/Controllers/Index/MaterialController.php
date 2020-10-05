<?php

namespace App\Http\Controllers\Index;

use App\Course;
use App\CourseMaterial;
use App\Http\Controllers\Controller;
use App\Material;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaterialController extends Controller {

    public function show(Course $course, Material $materials)
    {
        $icons = [
            "mp3" => "mdi-music-clef-treble",
            "pdf" => "mdi-file-pdf-outline text-danger",
            "doc" => "mdi-file-document-outline text-teal",
            "odt" => "mdi-file-document-outline text-teal",
            "rtf" => "mdi-file-document-outline text-teal",
            "xl" => "mdi-file-table-box text-success",
            "ods" => "mdi-file-table-box text-success",
            "pp" => "mdi-file-powerpoint-outline text-orange",
            "odp" => "mdi-file-powerpoint-outline text-orange",
            "zip" => "mdi-folder-zip-outline text-warning",
        ];


        $priority = $materials->priority($materials->id, $course->id);
        $materialPriority = $course->materials->where('id', $materials->id)->first()->getOriginal()["pivot_priority"];
        $MaterialsOrderByPriority = Course::MaterialsOrderByPriority($course->id);
        $nextMaterial = Course::nextMaterial($course->id, $materialPriority);
        $prevMaterial = Course::prevMaterial($course->id, $materialPriority);
        $announcements = $course->materials()->where("type", "Announcement")->orderBy("priority")->wherePivotIn("status", [1])->get();
        $sections = $course->materials()
            ->where("type", "Section")
            ->orderBy("priority")
            ->wherePivotIn("status", [1])->get();


        return view("index.materials.material-index",
            compact("announcements","priority", "materials", "course", "MaterialsOrderByPriority", "nextMaterial", "prevMaterial","icons"));
    }

    public function dummyPage(Material $materials)
    {

        return view("index.materials.dummy-material", compact('materials'));
    }

//    ajax controler
    public function watchlistMaterial(Request $request)
    {

        $watchlist = User::findOrFail($request->userId)
            ->watchlistMaterial()->where('watchlistable_id', $request->modelId)->first();

        if (isset($watchlist))
        {

            User::findOrFail($request->userId)
                ->watchlistMaterial()
                ->detach($request->modelId);

            return response("remove");
        }else{

            User::findOrFail($request->userId)
                ->watchlistMaterial()
                ->sync($request->modelId, false);
            return response("add");

        }

    }



    public function addWitchlist(Request $request)
    {


        $user =  auth()->user();

        $watchlist = $user
            ->witchlist()
            ->where('material_id',$request->materialId)
            ->where('course_id',$request->courseId)
            ->first();

        if (isset($watchlist))
        {

            $user->witchlist()->detach($watchlist);
            return response("remove");
        }else{

            $user->witchlist()->attach($request->materialId,["course_id"=>$request->courseId]);
            return response("add");
        }



    }

}

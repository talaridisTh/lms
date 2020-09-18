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

        $allMaterial = $course->materials()->orderBy("priority")->wherePivotIn("status", [1])->get();
        $priority = $materials->priority($materials->id, $course->id);
        $materialPriority = $course->materials->where('id', $materials->id)->first()->getOriginal()["pivot_priority"];
        $MaterialsOrderByPriority = Course::MaterialsOrderByPriority($course->id);
        $nextMaterial = Course::nextMaterial($course->id, $materialPriority);
        $prevMaterial = Course::prevMaterial($course->id, $materialPriority);

        return view("index.materials.material-index", compact("priority", "materials", "course", "MaterialsOrderByPriority", "nextMaterial", "prevMaterial"));
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

}

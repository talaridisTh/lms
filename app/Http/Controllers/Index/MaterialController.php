<?php

namespace App\Http\Controllers\Index;

use App\Course;
use App\CourseMaterial;
use App\Http\Controllers\Controller;
use App\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaterialController extends Controller
{

    public function show(Course $course, Material $materials)
    {

        $allMaterial = $course->materials()->orderBy("priority")->wherePivotIn("status",[1])->get();

        $priority = $materials->priority($materials->id,$course->id);

        $materialPriority = $course->materials->where('id', $materials->id)->first()->getOriginal()["pivot_priority"];

        $MaterialsOrderByPriority = Course::MaterialsOrderByPriority($course->id);

        $nextMaterial = Course::nextMaterial($course->id,$materialPriority);

        $prevMaterial = Course::prevMaterial($course->id,$materialPriority);



        return view("index.materials.material-index",compact("priority","materials","course","MaterialsOrderByPriority","nextMaterial","prevMaterial"));
    }



}

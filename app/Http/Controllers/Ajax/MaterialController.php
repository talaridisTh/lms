<?php

namespace App\Http\Controllers\Ajax;

use App\Course;
use App\CourseMaterial;
use App\DataTables\MaterialsDataTable;
use App\Http\Controllers\Controller;
use App\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller {

    public function index(MaterialsDataTable $dataTable)
    {

        return $dataTable->render('materials.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Material $material)
    {
        //
    }

    public function edit(Material $material)
    {
        //
    }

    public function update(Request $request, Material $material)
    {
        //
    }

    public function destroy(Material $material)
    {
        //
    }

    public function toggleStatus(Material $material, Request $request)
    {

        $material->status = $request->state;
        $material->save();
    }

    public function materialTypes()
    {

        return Material::select('type')->distinct('type')->get();
    }

    public function uploadDescImages(Request $request)
    {

        $allowedTypes = ["image/png", "image/jpeg"];
        $files = [];
        foreach ($request->file as $key => $image)
        {
            if ($image->isValid())
            {
                if (in_array($image->getClientMimeType(), $allowedTypes))
                {
                    if ($image->getSize() <= 512000)
                    {
                        $id = md5($image->getClientOriginalName());
                        $path = Storage::disk('public')->put("materials/$request->id/descriptionImages", $image);
                        $files["file-" . $key] = [
                            "url" => url("/storage/$path"),
                            "id" => $id
                        ];
                    }
                }
            }
        }
        echo json_encode($files);
    }

    public function uploadContentImages(Request $request)
    {

        $allowedTypes = ["image/png", "image/jpeg"];
        $files = [];
        foreach ($request->file as $key => $image)
        {
            if ($image->isValid())
            {
                if (in_array($image->getClientMimeType(), $allowedTypes))
                {
                    if ($image->getSize() <= 512000)
                    {
                        $id = md5($image->getClientOriginalName());
                        $path = Storage::disk('public')->put("materials/$request->id/contentImages", $image);
                        $files["file-" . $key] = [
                            "url" => url("/storage/$path"),
                            "id" => $id
                        ];
                    }
                }
            }
        }
        echo json_encode($files);
    }

    public function addContent(Request $request)
    {

        $pattern = "/[^a-z0-9\x{0370}-\x{03FF}]/mu";
        $material = new Material;
        $material->title = $request->title;
        $material->subtitle = $request->subtitle;
        $material->type = $request->type;
        $material->status = $request->state;
        $material->slug = preg_replace($pattern, "-", mb_strtolower($request->title));
        if ($request->type == "Video")
        {
            $material->video_link = $request->video;
        } elseif ($request->type == "Link")
        {
            $material->file = $request->link;
        }
        $material->save();
        CourseMaterial::incrementPriority($request->courseId, $request->priority);
        Course::find($request->courseId)->materials()
            ->attach($material->id, ["status" => $request->state, "priority" => $request->priority + 1]);
    }

    public function destroyMultipleMaterials(Request $request)
    {

        Material::whereIn('id', $request->material_id)->delete();
    }

    public function addMaterialMultiple(Request $request)
    {

        $course = Course::findOrFail($request->course_id);
        $course->materials()->syncWithoutDetaching($request->material_id);
    }

    public function changeStatusMultiple(Request $request)
    {

        foreach ($request->material_id as $material_id)
        {
            $material = Material::findOrFail($material_id);
            if ($request->status == "on")
            {
                $material->active = true;
                $material->save();
            } else
            {
                $material->active = false;
                $material->save();
            }
        }

        return response()->json(['success' => 'Status change successfully.']);
    }

}

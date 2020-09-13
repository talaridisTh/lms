<?php

namespace App\Http\Controllers\Ajax;

use App\Course;
use App\CourseMaterial;
use App\DataTables\AddCourseInsideMaterialsDataTable;
use App\DataTables\CourseInsideMaterialsDataTable;
use App\DataTables\MaterialsDataTable;
use App\Http\Controllers\Controller;
use App\Material;
use App\Media;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Str;

class MaterialController extends Controller {

    public function index(MaterialsDataTable $dataTable)
    {

        return $dataTable->render('materials.index');
    }

    public function indexCourse(CourseInsideMaterialsDataTable $dataTable)
    {

        return $dataTable->render('materials-course.index');
    }

    public function addCourseMaterial(AddCourseInsideMaterialsDataTable $dataTable)
    {
        return $dataTable->render('add-course-material');
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
        $publish = Carbon::now()->format("Y-m-d H:i:s");
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
            ->attach($material->id, ["status" => $request->state, "priority" => $request->priority + 1, "publish_at" => $publish]);
    }

    public function destroyMultipleMaterials(Request $request)
    {

        $data = [
            'all' => Material::all()->count() - count($request->material_id),
            'trashMaterial' => Material::onlyTrashed()->get()->count() + count($request->material_id)
        ];
        Material::whereIn('id', $request->material_id)->delete();

        return response()->json(['success' => $data]);
    }

    public function addMaterialMultiple(Request $request)
    {

        $materials = Material::findOrFail($request->material_id);
        foreach ($materials as $key => $material)
        {
            if ($key < 1)
            {
                $lastpriority = $material->courses()->count() > 0 ? $material->courses()->orderBy("priority", 'desc')->first()->getOriginal("pivot_priority") : 0;
            }
            $material->courses()->detach($request->course_id);
            $material->courses()->attach($request->course_id, ["priority" => $lastpriority + $key, "publish_at" => now()]);
        }
    }

    public function changeStatusMultiple(Request $request)
    {

        foreach ($request->material_id as $material_id)
        {
            $material = Material::findOrFail($material_id);
            if ($request->status == "on")
            {
                $material->status = true;
                $material->save();
            } else
            {
                $material->status = false;
                $material->save();
            }
        }

        return response()->json(['success' => 'Status change successfully.']);
    }

    public function destroyMultipleCourse(Request $request)
    {

        $material = Material::find($request->materialId);
        $material->courses()->detach($request->courseId);

        return response()->json(['success' => 'Status change successfully.']);
    }

    public function addCourse(Request $request)
    {

        $material = Material::findOrFail($request->materialId);
        $lastpriority = $material->courses()->count() > 0 ? $material->courses()->orderBy("priority", 'desc')->first()->getOriginal("pivot_priority") : 0;
        $material->courses()->detach($request->courseId);
        $material->courses()->attach($request->courseId, ["priority" => $lastpriority + 1, "publish_at" => now()]);
    }

    public function addCourseMultiple(Request $request)
    {

        $material = Material::findOrFail($request->materialId);
        $courses = Course::findOrFail($request->courseIds);
        foreach ($courses as $key => $course)
        {

            if ($key < 1)
            {
                $lastpriority = $material->courses()->count() > 0 ? $material->courses()->orderBy("priority", 'desc')->first()->getOriginal("pivot_priority") : 0;
            }
            $material->courses()->detach($course);
            $material->courses()->attach($course, ["priority" => $lastpriority + $key, "publish_at" => now()]);
        }
    }

    public function coverUpload(Request $request)
    {

        $user = Material::findorFail($request->materialId);
        $date = date('m.Y');

        $image = $request->file;


        $temp = explode(".", $image->getClientOriginalName());

        $name = implode("-", array_diff($temp, [ $image->getClientOriginalExtension() ]) );
        $nameWithExte =  Str::slug( $name, "-" );
        $name =  Str::slug( $name, "-" );
        $name .= ".". $image->getClientOriginalExtension();




        if ($image->isValid())
        {

            $media = new Media;
            $media->original_name = $image->getClientOriginalName();
            $media->name = $nameWithExte;
            $media->rel_path = "storage/$date/images/". $name;
            $media->ext = $image->getClientOriginalExtension();
            $media->file_info = $image->getClientMimeType();
            $media->size = $image->getSize();
            $media->save();
            $user->media()->wherePivot("usage", 0)->detach();
            $user->media()->attach( $media->id, [ "usage" => 0 ] );

            $image->storeAs("public/$date/images", $name);


        }
    }

    public function galleryUpload(Request $request)
    {

        $user = Material::findorFail($request->materialId);
        $date = date('m.Y');
        $image = $request->file;
        $temp = explode(".", $image->getClientOriginalName());
        $name = Str::slug($temp[0], "-");
        if ($image->isValid())
        {

            $media = new Media;
            $media->original_name = $image->getClientOriginalName();
            $media->name = $name;
            $media->rel_path = "storage/$date/images/" . $image->getClientOriginalName();
            $media->ext = $image->getClientOriginalExtension();
            $media->file_info = $image->getClientMimeType();
            $media->size = $image->getSize();
            $media->save();
            $user->media()->attach($media->id, ["usage" => 1]);
            $image->storeAs("public/$date/images", $image->getClientOriginalName());
        }
    }

}

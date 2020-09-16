<?php

namespace App\Http\Controllers;

use App\Course;
use App\Http\Requests\CreateMaterialRequest;
use App\Http\Requests\UpdateMaterialRequest;
use App\Material;
use App\Media;
use App\Topic;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Str;
use PHPUnit\Util\Type;

class MaterialController extends Controller {

    public function index()
    {
        $materials = Material::all();
        $activeCourses = User::courseWhereActive();
           //    soft-delete
//        $trashMaterial = Material::onlyTrashed()->get();
//        return view('admin.materials.materialsMain', compact("materials", "activeCourses","trashMaterial"));

        return view('admin.materials.materialsMain', compact("materials", "activeCourses"));
    }

    public function create()
    {
        $topics = Topic::all();
        $instructors = User::getInstructor();
        $courses = Course::all();
        $types = Material::all()->unique('type');

        return view('admin.materials.newMaterial', compact("topics", "instructors", "courses", "types"));
    }

    public function store(Request $request)
    {
        $material = new Material();
        $data = collect($request)->except("instructor", "topic")->all();
//        if ($files = $request->file('cover'))
//        {
//            $destinationPath = public_path("images") . '/lessson' . $request->title;
//            $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
//            $files->move($destinationPath, $profileImage);
//            $data['cover'] = $profileImage;
//        } else
//        {
//            $data["cover"] = "https://via.placeholder.com/600x400.png";
//        }
        $data["slug"] = Str::slug($request->title, '-');
        isset($data["status"])?  $data["status"]=1: $data["status"]=0;


        $newMaterial = $material->create($data);
        $request->instructor ? $newMaterial->users()->sync($request->instructor) : "";
        $request->topic ? $newMaterial->topics()->sync($request->topic) : "";

        return redirect(route("material.index"))->with('create', 'Το μάθημα ' . $data["title"] . ' δημιουργήθηκε');;
//
    }

    public function show(Material $material = null)
    {
        $media = Media::where("type", 0)->orderBy("id", "desc")->paginate(18);
        $topics = Topic::all();
        $instructors = User::getInstructor();
        $types = Material::all()->unique('type');

        return view('admin.materials.material', compact("topics", "instructors", "material", "types","media"));
    }

    public function update(Request $request, Material $material)
    {
        $material->update($request->except("instructor", "topic", "type", "status"));
        $data = collect($request)->except("instructor", "topic", "status")->all();
        $material->status = isset($request->status) ? 1 : 0;
        $material->save();
        if ($request->instructor)
        {
            $material->users()->sync($request->instructor);
        }
        else{
            $material->users()->detach();
        }
        if ($request->topic)
        {

            foreach ($request->topic as $topic)
            {
                $material->topics()->sync($request->topic);
            }
        }
        if ($request->type)
        {

            $material->update(['type' => $request->type]);
        }



        return redirect()->back()->with('update', 'Το μάθημα  ' . $material->title . ' ενημερώθηκε');
    }

    public function destroy(Request $request,Material $material)
    {

        $material->delete();

        return redirect(route('material.index'));

	}
	
	public function courseMaterial(Course $course, $priority) {
		$media = Media::where("type", 0)->orderBy("id", "desc")->paginate(18);
        $topics = Topic::all();
        $instructors = User::getInstructor();
		$types = Material::all()->unique('type');
		
		$data = [
			"media" => $media,
			"topics" => $topics,
			"instructors" => $instructors,
			"types" => $types
		];

        return view('admin.materials.material')->with($data);
	}

}

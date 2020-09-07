<?php

namespace App\Http\Controllers;

use App\Course;
use App\Http\Requests\CreateMaterialRequest;
use App\Http\Requests\UpdateMaterialRequest;
use App\Material;
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
        $activeCourses = User::courseWhereActive();
        $materials = Material::all(['title', 'description', 'status', 'type']);

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

    public function show(Material $material)
    {

        $topics = Topic::all();
        $instructors = User::getInstructor();
        $courses = Course::with("materials")->get();
        $types = Material::all()->unique('type');

        return view('admin.materials.newMaterial', compact("topics", "instructors", "courses", "material", "types"));
    }

    public function update(Request $request, Material $material)
    {
        $material->update($request->except("instructor", "topic", "type", "status"));
        $data = collect($request)->except("instructor", "topic", "status")->all();
        if ($request->instructor)
        {
            $material->users()->sync($request->instructor);
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
        if ($request->status)
        {
            $material->update(['status' => $request->status]);
        } else
        {

            $material->update(['status' => $request->status == null ? 0 : $request->status]);
        }

        return redirect()->back()->with('update', 'Το μάθημα  ' . $material->title . ' ενημερώθηκε');
    }

    public function destroy(Material $material)
    {

        foreach ($material->topics as $mat)
        {
        }
    }

}

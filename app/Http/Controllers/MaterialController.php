<?php

namespace App\Http\Controllers;

use App\Course;
use App\Http\Requests\CreateMaterialRequest;
use App\Http\Requests\UpdateMaterialRequest;
use App\Material;
use App\Topic;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Str;
use PHPUnit\Util\Type;

class MaterialController extends Controller {

    public function index()
    {
        $activeCourses = User::courseWhereActive();
        $materials = Material::all(['title', 'description', 'active', 'type']);

        return view('admin.materials.materialsMain',compact("materials","activeCourses"));
    }

    public function create()
    {

        $topics = Topic::all();
        $instructors = User::getInstructor();
        $courses = Course::all();
        $types = Material::all()->unique('type');

        return view('admin.materials.newMaterial', compact("topics", "instructors", "courses", "types"));
    }

    public function store(CreateMaterialRequest $request)
    {

        $material = new Material();
        $data = collect($request)->except("instructor", "topic")->all();
        if ($files = $request->file('cover'))
        {
            $destinationPath = public_path("images") . '/lessson' . $request->title;
            $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $profileImage);
            $data['cover'] = $profileImage;
        } else
        {
            $data["cover"] = "https://via.placeholder.com/600x400.png";
        }
        $data["slug"] = Str::slug($request->title, '-');
//        dd($data);
        $newMaterial = $material->create($data);
        if ($request->instructor)
        {

            $newMaterial->users()->attach($request->instructor);
        }
        if ($request->topic)
        {

            $newMaterial->topics()->attach($request->topic);
        }
//        if($request->courses){
//            $newMaterial->courses()->attach($request->courses);
//
//        }
        return redirect(route("material.index"))->with('create', 'Το μάθημα ' . $data["title"] . ' δημιουργήθηκε');;
//        dd($data);
    }

    public function show(Material $material)
    {

        $tops = Topic::all();
        $instructors = User::getInstructor();
        $courses = Course::all();
        $types = Material::all()->unique('type');

        return view('admin.materials.material', compact("tops", "instructors", "courses", "material", "types"));
    }

    public function update(UpdateMaterialRequest $request, Material $material)
    {

        $data = collect($request)->except("instructor", "topic")->all();
        $material->update($data);
        if ($request->instructor)
        {
            $material->users()->update(['user_id' => $request->instructor]);
        }
        if ($request->topic)
        {

            $material->topics()->update(['topic_id' => $request->topic]);
        }

        return redirect(route("material.index"))->with('update', 'Το μάθημα  ' . $material->title . ' ενημερώθηκε');
    }

    public function destroy(Material $material)
    {

    }

}

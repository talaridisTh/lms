<?php

namespace App\Http\Controllers;

use App\Course;
use App\Material;
use App\Topic;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Str;
use PHPUnit\Util\Type;

class MaterialController extends Controller
{

    public function index()
    {
		$materials = Material::all(['title', 'description', 'active', 'type']);

        return view('admin/materials/materialsMain')->withMaterials($materials);
    }


    public function create()
    {

        $types = Topic::all();
        $instructors  = User::getInstructor();
        $courses = Course::all();


        return view('admin.materials.newMaterial',compact("types","instructors","courses"));
    }


    public function store(Request $request)
    {


        $material = new Material();
        $data = collect($request)->except( "instructor","courses")->all();

        if ($files = $request->file('cover'))
        {
            $destinationPath = public_path("images") . '/lessson'.$request->title;
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

        if($request->instructor){

            $newMaterial->users()->attach($request->instructor);

        }
        if($request->courses){
            $newMaterial->courses()->attach($request->courses);

        }

        return redirect(route("material.index"));
//        dd($data);


    }


    public function show(Material $material)
    {
		$topics = Topic::all();

		$data = [
			'material' => $material,
			'topics' => $topics,
		];

        return view('admin.materials.material')->with( $data );
    }

    public function edit(Material $material)
    {

    }

    public function update(Request $request, Material $material)
    {

    }


    public function destroy(Material $material)
    {

	}


}

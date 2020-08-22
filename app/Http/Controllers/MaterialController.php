<?php

namespace App\Http\Controllers;

use App\Material;
use App\Topic;
use Illuminate\Http\Request;
use App\User;

class MaterialController extends Controller
{

    public function index()
    {
		$materials = Material::all(['title', 'description', 'active', 'type']);

        return view('admin/materials/materialsMain')->withMaterials($materials);
    }


    public function create()
    {

        return view('admin/materials/newMaterial');
    }


    public function store(Request $request)
    {

       return  Input::all();
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

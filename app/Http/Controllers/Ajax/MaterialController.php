<?php

namespace App\Http\Controllers\Ajax;

use App\DataTables\MaterialsDataTable;
use App\Http\Controllers\Controller;
use App\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MaterialsDataTable $dataTable)
    {
        return $dataTable->render('materials.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function show(Material $material)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function edit(Material $material)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Material $material)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function destroy(Material $material)
    {
        //
	}
	
	public function toggleActive(Material $material, Request $request) {

		$material->active = $request->state;
		$material->save();

	}

	public function materialTypes() {

		return Material::select('type')->distinct('type')->get();
	}

	public function uploadDescImages(Request $request) {

		$allowedTypes = ["image/png", "image/jpeg"];
		$files = [];

		foreach( $request->file as $key => $image ) {
			if ( $image->isValid() ) {
				if ( in_array( $image->getClientMimeType(), $allowedTypes) ) {
					if ( $image->getSize() <= 512000) {
						$id = md5( $image->getClientOriginalName() );

						$path = Storage::disk('public')->put( "materials/$request->id/descriptionImages", $image );

						$files["file-".$key] = array(
							"url" => url("/storage/$path"),
							"id" => $id
						);
					}
				}
			}
		}

		echo json_encode($files);
	}

	public function uploadContentImages( Request $request ) {


		$allowedTypes = ["image/png", "image/jpeg"];
		$files = [];

		foreach( $request->file as $key => $image ) {
			if ( $image->isValid() ) {
				if ( in_array( $image->getClientMimeType(), $allowedTypes) ) {
					if ( $image->getSize() <= 512000) {
						$id = md5( $image->getClientOriginalName() );

						$path = Storage::disk('public')->put( "materials/$request->id/contentImages", $image );

						$files["file-".$key] = array(
							"url" => url("/storage/$path"),
							"id" => $id
						);
					}
				}
			}
		}

		echo json_encode($files);

	}
}

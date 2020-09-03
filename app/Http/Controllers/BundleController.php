<?php

namespace App\Http\Controllers;

use App\Bundle;
use Illuminate\Http\Request;
use App\Http\Requests\BundleCourseRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;



class BundleController extends Controller
{

    public function index()
    {
        return view('admin/bundles/bundlesMain');
    }


    public function create()
    {
        //
    }


    public function store(BundleCourseRequest $request)
    {
        // if( !empty($_FILES['cover']['name']) ) {
		// 	$ext = $_FILES['cover']['type'] == "image/png" ? ".png" : ".jpeg";
		// 	$fileName = md5( $request->name ).$ext;
		// }


		$bundle = new Bundle;
		$bundle->title = $request->title;
		$bundle->description = $request->description;
		$bundle->status = $request->status;
		$bundle->slug = Str::slug($request->title, "-");
		$bundle->cover = "https://placehold.co/600x400";
		// $bundle->cover = isset($fileName) ? $fileName : "no_image_600x400.png";
		
		$bundle->save();
		
		// if ( isset($fileName) ) {
		// 	$request->cover->storeAs("public/bundles/$bundle->id/cover", $fileName);
		// }
		// else {
		// 	Storage::copy("public/no_image_600x400.png", "public/bundles/$bundle->id/cover/no_image_600x400.png");
		// }
		
		return redirect( "/dashboard/bundle/$bundle->id" );
    }

    public function show(Bundle $bundle)
    {
        return view("admin/bundles/bundle")->withBundle($bundle);
    }


    public function edit(Bundle $bundle)
    {
        //
    }


    public function update(BundleCourseRequest $request, Bundle $bundle)
    {
        $pattern = "/[^a-z0-9\x{0370}-\x{03FF}]/mu";

		$bundle->name = $request->name;
		$bundle->description = $request->description;
		$bundle->status = $request->status;
		$bundle->slug = preg_replace($pattern, "-", mb_strtolower($request->name) );

		if ( !empty($_FILES['cover']['name']) ) {
			
			$ext = $_FILES['cover']['type'] == "image/png" ? ".png" : ".jpeg";
			$fileName = md5( $request->name ).$ext;
			
			Storage::delete( "public/bundles/$bundle->id/cover/$bundle->cover" );
			$request->cover->storeAs("public/bundles/$bundle->id/cover", $fileName);
			
			$bundle->cover = $fileName;
		}

		$bundle->save();

		return redirect( "/dashboard/bundle/$bundle->id" );
    }


    public function destroy(Bundle $bundle)
    {
        //
    }
}

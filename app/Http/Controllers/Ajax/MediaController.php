<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Media;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\View\View;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request ) {

		if ( $request->search ) {
			$media = Media::where("type", 0)
				->where("name", "like", "%$request->search%")
				->paginate(18);
		}
		else {
			$media = Media::where("type", 0)->paginate(18);
		}

		return View('components.admin.imageGallery', ['media' => $media]);
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
     * @param  \App\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function show(Media $media)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function edit(Media $media)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Media $media)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function destroy(Media $media)
    {
        //
	}
	
	public function editorImages ( Request $request ) {


		// dd($request);

		//! model Sended with request	etc. App\Course - App\Bundle
		//! an telika den xrisimopoih8ei o pivot na afere8i kai apo
		//! ta js arxeia
		// $namespace = $request->namespace;

		// $model = $namespace::find($request->id);

		$allowedTypes = ["image/png", "image/jpeg"];
		$date = date('m.Y');
		$files = [];

		foreach ( $request->file as $key => $image ) {
			if ( $image->isValid() ) {
				if ( in_array($image->getClientMimeType(), $allowedTypes) ) {
					if ( $image->getSize() <= 512000 ) {

						$temp = explode(".", $image->getClientOriginalName());

						$name = implode("-", array_diff($temp, [ $image->getClientOriginalExtension() ]) );
						$name =  Str::slug( $name, "-" );
						$name .= ".". $image->getClientOriginalExtension();

						$media = new Media;
						$media->original_name = $image->getClientOriginalName();
						$media->name = $name;
						$media->rel_path = "storage/$date/images/". $name;
						$media->ext = $image->getClientOriginalExtension();
						$media->file_info = $image->getClientMimeType();
						$media->size = $image->getSize();
						$media->save();

						// $model->media()->attach( $media->id, [ "usage" => 1 ] );

						$image->storeAs("public/$date/images", $name);
						
						$files["file-". $key] =[
							"url" => url("storage/$date/images/$name"),
							"id" => $name
						];

					}
				}
			}
		}
		echo json_encode($files);
	}

	public function coverChange(Request $request) {

		$namespace = $request->namespace;
		$id = $request->id;
		$model = $namespace::find( $id );

		$model->cover = $request->url;
		$model->save();

	}
}

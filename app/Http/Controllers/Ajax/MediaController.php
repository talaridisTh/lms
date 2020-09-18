<?php

namespace App\Http\Controllers\Ajax;

use App\DataTables\FileManagerDataTable;
use App\Http\Controllers\Controller;
use App\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

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
				->orderBy("id", "desc")
				->paginate(18);
		}
		else {
			$media = Media::where("type", 0)->orderBy("id", "desc")->paginate(18);
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

	public function fileManagerTable(FileManagerDataTable $dataTable) {

		return $dataTable->render('file.manager');

	}

	public function editorImages ( Request $request ) {

		// dd();
		//! model Sended with request	etc. App\Course - App\Bundle
		//! an telika den xrisimopoih8ei o pivot na afere8i kai apo
		//! ta js arxeia
		// $namespace = $request->namespace;

		// $model = $namespace::find($request->id);

		$allowedTypes = ["image/png", "image/jpeg"];
		$date = date('Y.m');
		$files = [];

		foreach ( $request->file as $key => $image ) {
			if ( $image->isValid() ) {
				if ( in_array($image->getClientMimeType(), $allowedTypes) ) {
					if ( $image->getSize() <= 512000 ) {

						$temp = explode(".", $image->getClientOriginalName());
						$arrayName = (array_diff( $temp, [$image->getClientOriginalExtension()] ));
						$originalName = implode( ".", $arrayName );
						$name =  Str::slug( implode("-", $arrayName ), "-" );

						$count = Media::where( "original_name", $originalName)->count();

						if ( $count > 0 ) {
							$fullname = $name.( $count + 1 ).".".$image->getClientOriginalExtension();
						}
						else {
							$fullname = "$name.".$image->getClientOriginalExtension();
						}

						$media = new Media;
						$media->original_name = $originalName;
						$media->name = $name;
						$media->rel_path = "storage/images/$date/$fullname";
						$media->thumbnail_path = "storage/thumbnails/$date/$fullname";
						$media->ext = $image->getClientOriginalExtension();
						$media->file_info = $image->getClientMimeType();
						$media->size = $image->getSize();
						$media->width = Image::make( $image )->width();
						$media->height = Image::make( $image )->height();
						$media->save();

						 // $model->media()->attach( $media->id, [ "usage" => 1 ] );

						$image->storeAs("public/images/$date", $fullname);

						if ( !file_exists( storage_path("app/public/thumbnails/$date") ) ) {
							Storage::disk("local")->makeDirectory("public/thumbnails/$date");

						}

						Image::make( $image )->fit( 215, 215)
							->save( storage_path("/app/public/thumbnails/$date/$fullname") );

						$files["file-". $key] = [
							"url" => url("storage/$date/images/$name"),
							"id" => $media->id
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

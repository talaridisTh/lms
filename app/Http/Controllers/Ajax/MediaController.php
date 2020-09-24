<?php

namespace App\Http\Controllers\Ajax;

use App\DataTables\FileManagerDataTable;
use App\Http\Controllers\Controller;
use App\Media;
use App\MediaDetails;
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

	public function gridFileManager( Request $request ) {

		if ( $request->search ) {
			$files = Media::where("name", "like", "%$request->search%")
				->orderBy("id", "desc")
				->paginate(24);
		}
		else {
			$files = Media::orderBy("id", "desc")->paginate(24);
		}

		return View("components.admin.gridFileManager", ['files' => $files]);

	}

	public function addToGallery(Request $request) {

		$model = $request->namespace::find( $request->modelId );
		$existingMedia = $model->media()->pluck("id")->toArray();
		
		if ( $model->media()->count() > 0 ) {
			$validMediaIds = array_diff( $request->ids, $existingMedia );
			$priority = $model->media()->orderBy("priority", "desc")->first()->pivot->priority;
		}
		else {
			$priority = 0;
			$validMediaIds = $request->ids;
		}

		foreach( $validMediaIds as $key => $id ) {

			$model->media()->attach($id, ['usage' => 1, "priority" => $key + $priority + 1]);

		}

		$gallery = $model->media()->orderBy("priority")->get();
		return View('components/admin/modelGallery', ['gallery' => $gallery]);

	}

	public function removeFromGallery(Request $request) {

		$model = $request->namespace::find( $request->modelId );

		// dd($request->all());

		foreach( $request->ids as $id ) {
			$model->media()->detach( $id );
		}

		$gallery = $model->media()->orderBy("priority")->get();

		return View('components/admin/modelGallery', ['gallery' => $gallery]);

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
		$request->validate([
			'title' => 'required'
		]);

		// dd($error);

		$details = Media::find($request->id)->mediaDetails;

		if ( !$details ) {
			$details = new MediaDetails();
			$details->media_id = $request->id;
		}

		$details->title = $request->title;
		$details->subtitle = $request->subtitle;
		$details->caption = $request->caption;
		$details->description = $request->description;
		$details->save();
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
					if ( $image->getSize() <= 50000000 ) { // 50MB

						$temp = explode(".", $image->getClientOriginalName());
						$arrayName = (array_diff( $temp, [$image->getClientOriginalExtension()] ));
						$originalName = implode( ".", $arrayName );
						$name =  Str::slug( implode("-", $arrayName ), "-" );

						$count = Media::where( "original_name", $originalName)->count();

						if ( $count > 0 ) {
							$name = $name.( $count + 1 );
							$fullname = $name.".".$image->getClientOriginalExtension();
						}
						else {
							$fullname = "$name.".$image->getClientOriginalExtension();
						}

						$media = new Media;
						$media->original_name = $originalName;
						$media->name = $name;
						$media->rel_path = "/storage/images/$date/$fullname";
						$media->thumbnail_path = "/storage/thumbnails/$date/$fullname";
						$media->ext = $image->getClientOriginalExtension();
						$media->file_info = $image->getClientMimeType();
						$media->size = $image->getSize();
						$media->width = Image::make( $image )->width();
						$media->height = Image::make( $image )->height();
						$media->save();

						 //git $model->media()->attach( $media->id, [ "usage" => 1 ] );

						$image->storeAs("public/images/$date", $fullname);

						if ( !file_exists( storage_path("app/public/thumbnails/$date") ) ) {
							Storage::disk("local")->makeDirectory("public/thumbnails/$date");

						}

						Image::make( $image )->fit( 215, 215)
							->save( storage_path("/app/public/thumbnails/$date/$fullname") );

						$files["file-". $key] = [
							"url" => $media->rel_path,
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

	public function coverChangeNotExist(Request $request) {

        dd($request->all());


	}


}

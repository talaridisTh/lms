<?php

namespace App\Http\Controllers\Ajax;

use App\DataTables\FileManagerDataTable;
use App\Http\Controllers\Controller;
use App\Media;
use App\MediaDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use App\DataTables\FilesDataTable;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class MediaController extends Controller
{

	private $allowedTypes = [
		"application/octet-stream", "application/x-zip-compressed", "application/pdf",
		"application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", 
		"application/vnd.openxmlformats-officedocument.wordprocessingml.template", "application/vnd.ms-word.document.macroEnabled.12",
		"application/vnd.ms-word.template.macroEnabled.12", "application/vnd.ms-excel", "application/vnd.ms-excel", "application/vnd.ms-excel",
		"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "application/vnd.openxmlformats-officedocument.spreadsheetml.template",
		"application/vnd.ms-excel.sheet.macroEnabled.12", "application/vnd.ms-excel.template.macroEnabled.12",
		"application/vnd.ms-excel.addin.macroEnabled.12", "application/vnd.ms-excel.sheet.binary.macroEnabled.12",
		"application/vnd.ms-powerpoint", "application/vnd.openxmlformats-officedocument.presentationml.presentation",
		"application/vnd.openxmlformats-officedocument.presentationml.template", "application/vnd.openxmlformats-officedocument.presentationml.slideshow",
		"application/vnd.ms-powerpoint.addin.macroEnabled.12", "application/vnd.ms-powerpoint.presentation.macroEnabled.12",
		"application/vnd.ms-powerpoint.template.macroEnabled.12", "application/vnd.ms-powerpoint.slideshow.macroEnabled.12",
		"application/vnd.ms-access", "audio/mpeg", "application/vnd.oasis.opendocument.presentation",
		"application/vnd.oasis.opendocument.spreadsheet", "application/vnd.oasis.opendocument.text",
		"application/rtf", "application/vnd.oasis.opendocument.graphics", "text/html", "image/png",
		"image/jpeg"
	];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request ) {

		if ( $request->search ) {
			// $media = Media::where("type", 0)
			// 	->where("name", "like", "%$request->search%")
			// 	->orderBy("id", "desc")
			// 	->paginate(18);

			$media = DB::table("media")
				->leftJoin("media_details", "media.id", "=", "media_details.media_id")
				->where("media.type", 0)
				->where("media.name", "LIKE", "%$request->search%")
				->orWhere("media_details.title", "LIKE", "%$request->search%")
				->orderBy("media.id", "desc")
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

		$gallery = $model->media()->where("type", 0)->orderBy("priority")->get();
		return View('components/admin/modelGallery', ['gallery' => $gallery]);

	}

	public function removeFromGallery(Request $request) {

		$model = $request->namespace::find( $request->modelId );

		foreach( $request->ids as $id ) {
			$model->media()->detach( $id );
		}

		$gallery = $model->media()->where("type", 0)->orderBy("priority")->get();

		return View('components/admin/modelGallery', ['gallery' => $gallery]);

	}

	public function removeCover(Request $request) {

		$model = $request->namespace::find( $request->id );

		if ( $request->namespace === "App\\User" ) {
			$model->avatar = null;
		}
		else {
			$model->cover = null;
		}
		
		$model->save();

	}

	public function remainingFilesTable(FilesDataTable $dataTable) {

		return $dataTable->render('remaning.files');

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
	
	public function addFiles(Request $request) {

		$model = $request->namespace::find($request->modelId);

		foreach( $request->ids as $id ) {
			$model->media()->attach( $id, ["usage" => 3]);
		}

		$files = $model->media()->where("type", 1)->get();

		return view('components/admin/filesTable', ['files' => $files]);
	}

	public function removeFiles( Request $request ) {

		$model = $request->namespace::find( $request->modelId );

		foreach( $request->ids as $id ) {
			$model->media()->detach($id);
		}

		$files = $model->media()->where("type", 1)->get();

		return view('components/admin/filesTable', ['files' => $files]);
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

	public function uploadImages ( Request $request ) {

		$allowedTypes = ["image/png", "image/jpeg"];
		$files = [];

		foreach ( $request->file as $key => $image ) {
			if ( $image->isValid() ) {
				if ( in_array($image->getClientMimeType(), $allowedTypes) ) {
					if ( $image->getSize() <= 50000000 ) { // 50MB

						$media = $this->storeImage($image);

						$files["file-". $media->id] = [
							"url" => $media->rel_path,
							"id" => $media->id
						];
					}
				}
			}
		}
		echo json_encode($files);
	}

	public function fileUpload( Request $request ) {

		$model = $request->namespace::find($request->id);
		$file = $request->file;
		
		//! afairei ta antistixa arxeia
		$allowedTypes = array_diff($this->allowedTypes, ["image/png", "image/jpeg"]);

		if ( $file->isValid() ) {
			if ( in_array($file->getClientMimeType(), $allowedTypes) ) {
				if ( $file->getSize() <= 50000000 ) { // 50MB

					$media = $this->storeFile($file);

					$model->media()->attach( $media->id, [ "usage" => 3 ] );

				}
			}
		}

		$files = $model->media()->where("type", 1)->get();

		return view('components/admin/filesTable', ['files' => $files]);

	}

	public function pdfUpload(Request $request) {

		$file = $request->file;
		
		if ( !$file->isValid() ) {
			abort(422);
		}
		
		if ( $file->getClientMimeType() !== "application/pdf" ) {
			abort(415);
		}


		if ( $file->getSize() <= 50000000 ) { // 50MB
			$this->storeFile($file);
		}
		else {
			abort(413);
		}

	}

	public function coverChange(Request $request) {

		$namespace = $request->namespace;
		$id = $request->id;
		$model = $namespace::find( $id );

		if ( $namespace === "App\\User" ) {
			$model->avatar = $request->url;
			$model->save();

			return response()->json(["imgUrl" => $model->thumbnailUrl("avatar")]);
		}
		elseif ( $namespace === "App\\Option") {
			$model = $namespace::where("name", "logo")->first();
			$model->value = $request->url;
			$model->save();

			return response()->json(["imgUrl" => $model->value]);
		}
		else {
			$model->cover = $request->url;
			$model->save();

			return response()->json(["imgUrl" => $model->cardMediumUrl()]);
		}

	}

	public function generalUpload(Request $request) {

		$file = $request->file;

		$fileTypes = array_diff($this->allowedTypes, ["image/png", "image/jpeg"]);
		$imageTypes = ["image/png", "image/jpeg"];

		if ( $file->isValid() ) {
			if ( $file->getSize() <= 50000000 ) { // 50MB
				if ( in_array($file->getClientMimeType(), $imageTypes) ) {

					$this->storeImage($file);

				}		//! elegxei arxeia na MIN mpi mesa se else
				elseif ( in_array($file->getClientMimeType(), $fileTypes) ) {

					$this->storeFile($file);

				}
			}
		}
	}

	private function fileName($file) {
		$temp = explode(".", $file->getClientOriginalName());
		$arrayName = (array_diff( $temp, [$file->getClientOriginalExtension()] ));
		$originalName = implode( ".", $arrayName );
		$name =  Str::slug( implode("-", $arrayName ), "-" );

		$count = Media::where( "original_name", $originalName)->count();

		if ( $count > 0 ) {
			$name = $name.( $count + 1 );
			$fullname = $name.".".$file->getClientOriginalExtension();
		}
		else {
			$fullname = "$name.".$file->getClientOriginalExtension();
		}

		return (object)[
			"name" => $name,
			"originalName" => $originalName,
			"fullname" => $fullname,
		];
	}

	private function storeImage($image) {
		
		$date = date('Y.m');
		$name = $this->fileName($image);

		$media = new Media;
		$media->original_name = $name->originalName;
		$media->name = $name->name;
		$media->rel_path = "/storage/images/$date/$name->fullname";
		$media->thumbnail_path = "/storage/thumbnails/$date/$name->fullname";
		$media->ext = $image->getClientOriginalExtension();
		$media->file_info = $image->getClientMimeType();
		$media->size = $image->getSize();
		$media->width = Image::make( $image )->width();
		$media->height = Image::make( $image )->height();

		$media->save();

		$image->storeAs("public/images/$date", $name->fullname);

		if ( !file_exists( storage_path("app/public/thumbnails/$date") ) ) {
			Storage::disk("local")->makeDirectory("public/thumbnails/$date");
		}

		Image::make( $image )->fit( 250, 250)
			->save( storage_path("/app/public/thumbnails/$date/$name->fullname") );

		return (object)[
			"id" => $media->id,
			"rel_path" => $media->rel_path
		];
	}

	private function storeFile($file) {

		$date = date('Y.m');
		$name = $this->fileName($file);

		$media = new Media;
		$media->original_name = $name->originalName;
		$media->name = $name->name;
		$media->type = 1;
		$media->rel_path = "/storage/files/$date/$name->fullname";
		$media->ext = $file->getClientOriginalExtension();
		$media->file_info = $file->getClientMimeType();
		$media->size = $file->getSize();
		$media->save();

		$file->storeAs("public/files/$date", $name->fullname);

		return $media;
	}


}

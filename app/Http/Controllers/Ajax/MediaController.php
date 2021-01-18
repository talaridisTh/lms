<?php

namespace App\Http\Controllers\Ajax;

use App\DataTables\Files\FileManagerDataTable;
use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\MediaDetails;
use Illuminate\Http\Request;
use App\DataTables\Files\FilesDataTable;
use App\Traits\MediaUploader;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MediaController extends Controller {

	use MediaUploader;

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

			$media = Media::leftJoin("media_details", "media.id", "=", "media_details.media_id")
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

		if ( $request->namespace === "App\\Models\\User" ) {
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

		if ( $namespace === "App\\Models\\User" ) {
			$model->avatar = $request->url;
			$model->save();

			return response()->json(["imgUrl" => $model->thumbnailUrl("avatar")]);
		}
		elseif ( $namespace === "App\\Models\\Option") {
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

		$imageTypes = ["image/png", "image/jpeg"];
		$fileTypes = array_diff($this->allowedTypes, $imageTypes);

		if ( !$file->isValid() ) {
			abort(422);
		}

		if ( $file->getSize() > 50000000 ) { // 50MB
			abort(413);
		}

		if ( in_array($file->getClientMimeType(), $imageTypes) ) {

			$this->storeImage($file);

		}
		elseif ( in_array($file->getClientMimeType(), $fileTypes) ) {
			//! na perastei se trait kai na figoun ta extra if
			$this->storeFile($file);
		}
		else {
			abort(415);
		}
	}

	public function togglePublicPass(Request $request, Media $media) {

		$string = Str::random(20);

		if ($request->status == 1) {
			$media->public_pass = "$string";
		}
		else {
			$media->public_pass = null;
		}

		$media->save();

		return response()->json([
			"url" => $request->status == 1 ? url("/pf/$string/$media->name") : ""
		]);
	}

	public function getMediaDetails(Media $media) {

		// $mediaDetails = $media->load("details");

		return $media->load("mediaDetails");
	}

	private function storeFile($file) {

		$date = date('Y.m');
		$name = $this->fileName($file);

		$media = new Media;
		$media->original_name = $name->original;
		$media->name = $name->slug;
		$media->type = 1;
		$media->rel_path = "/storage/files/$date/$name->full";
		$media->ext = strtolower($file->getClientOriginalExtension());
		$media->file_info = $file->getClientMimeType();
		$media->size = $file->getSize();
		$media->save();

		$file->storeAs("public/files/$date", $name->full);

		return $media;
	}


}

<?php

namespace App\Traits;

define("IMAGE_TYPES", ["image/png", "image/jpeg"]);

use App\Models\Media;
use Exception;
use Illuminate\Support\Str;
Use Intervention\Image\Facades\Image;

trait MediaUploader {

	private function storeImage($image, $type = 0) {

		$this->fileValidation($image, 50000000, IMAGE_TYPES);

		$name = $this->fileName($image);
		$date = date('Y.m');

		$media = new Media;
		$media->original_name = $name->original;				//! xoris ext
		$media->name = $name->slug;
		$media->type = $type;
		$media->rel_path = "/storage/images/$date/$name->full";	//! + increment on dublicate
		$media->ext = $name->extension;
		$media->file_info = $image->getClientMimeType();
		$media->size = $image->getSize();
		$media->width = Image::make( $image )->width();
		$media->height = Image::make( $image )->height();

		$media->save();
		$image->storeAs("public/images/$date", $name->full);

		return $media;
	}

	private function fileName($file) {

		$temp = explode(".", $file->getClientOriginalName());
		$temp = array_diff( $temp, [$file->getClientOriginalExtension()] );
		$originalName = implode( ".", $temp );
		$slug =  Str::slug( $originalName );
		$extension = strtolower($file->getClientOriginalExtension());

		$count = Media::where( "original_name", $originalName)->count();

		if ( $count > 0 ) {
			$name = $slug.( $count + 1 );
			$fullname = $name.".".$extension;
		}
		else {
			$fullname = "$slug.".$extension;
		}

		return (object)[
			"slug" => $slug,
			"original" => $originalName,
			"full" => $fullname,
			"extension" => $extension
		];
	}

	private function fileValidation($file, $size, $flag) {

		try {
			if ( !$file->isValid() ) {
				$error = $file->getErrorMessage();
				throw new Exception($error, 422);
			}

			if ( !in_array($file->getClientMimeType(), $flag) ) {
				throw new Exception("Invalid type!", 415);
			}

			if ( $file->getSize() > $size ) {
				throw new Exception("Size Exceeded!", 413);
			}
		}
		catch (Exception $err) {
			$code = $err->getCode();
			$message = $err->getMessage();

			abort($code, $message);
		}
	}

}

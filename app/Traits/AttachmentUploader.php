<?php

namespace App\Traits;

define("ALLOWED_FILES", ["application/octet-stream", "application/x-zip-compressed", "application/pdf",
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
]);

define("IMAGE_TYPES", ["image/png", "image/jpeg"]);

use App\Models\Attachment;
use App\Models\Media;
use Exception;
use Illuminate\Support\Str;

trait AttachmentUploader {

	private function storeAttachment($file) {

		$this->fileValidation($file, 20000000, ALLOWED_FILES);

		$name = $this->fileName($file);
		$date = date('Y.m');

		$attachment = new Attachment();
		$attachment->original_name = $name->original;				//! xoris ext
		$attachment->name = $name->slug;
		$attachment->type = in_array($file->getClientMimeType(), IMAGE_TYPES) ? 0 : 1;
		$attachment->rel_path = "/storage/attachments/$date/$name->full";	//! + increment on dublicate
		$attachment->ext = $name->extension;
		$attachment->file_info = $file->getClientMimeType();
		$attachment->size = $file->getSize();

		$attachment->save();
		$file->storeAs("public/attachments/$date", $name->full);

		return $attachment;
	}

	private function fileName($file) {

		$temp = explode(".", $file->getClientOriginalName());
		$temp = array_diff( $temp, [$file->getClientOriginalExtension()] );
		$originalName = implode( ".", $temp );
		$slug =  Str::slug( $originalName );
		$extension = strtolower($file->getClientOriginalExtension());

		$count = Attachment::where( "original_name", "like", "%$originalName%")->count();

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

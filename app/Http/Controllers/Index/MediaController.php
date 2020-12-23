<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Media;

class MediaController extends Controller
{
    public function show($pass, $name) {
		
		$media = Media::with("mediaDetails")->where("name", $name)
			->where("public_pass", $pass)->firstOrFail();
		
		$data = [
			"media" => $media,
			"title" => $media->mediaDetails->title ?? $media->original_name,
			"caption" => $media->mediaDetails->caption ?? "",
			"icons" => Media::$icons
		];

		return view("index/fileSharing/media-temp")->with($data);
	}
}

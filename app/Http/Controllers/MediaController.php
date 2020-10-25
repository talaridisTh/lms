<?php

namespace App\Http\Controllers;

use App\Media;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function index()
    {
		$files = Media::orderBy("id", "desc")->paginate(24);
		$extensions = Media::select(['ext'])->distinct("ext")->get();
		$icons = Media::$icons;

		$data = [
			"files" => $files,
			"extensions" => $extensions,
			"icons" => $icons,
		];

        return view("admin/media/mediaIndex")->with($data);
    }
}

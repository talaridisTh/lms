<?php

namespace App\Http\Controllers;

use App\Media;
use Illuminate\Http\Request;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem as FlysystemFilesystem;
use League\Glide\Server;
use League\Glide\Signatures\SignatureFactory;
use League\Glide\Signatures\SignatureException;
use League\Glide\Urls\UrlBuilderFactory;

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

	public function show(Server $server, Request $request, $path) {

		$temp = explode("/", $path);
		$image = array_pop($temp);
		$source = implode("/", $temp);
		array_shift($temp);
		$cache = implode("/", $temp);

		try {
			// Set complicated sign key
			$signkey = 'The strongest of all warriors are these two, patience and time...';

			// Validate HTTP signature
			SignatureFactory::create($signkey)->validateRequest($request->getPathInfo(), $_GET);

			$source = new FlysystemFilesystem( new Local($source) );
	
			$server->setSource($source);
			$server->setCachePathPrefix(".cache/$cache");

			$server->outputImage($image, $_GET);
		
		} catch (SignatureException $e) {
			// Handle error
			abort(400);
		}
	}

}

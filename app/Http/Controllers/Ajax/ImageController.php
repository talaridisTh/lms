<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use League\Glide\Signatures\SignatureFactory;
use League\Glide\Signatures\SignatureException;
use League\Glide\Urls\UrlBuilderFactory;
use Illuminate\Support\Facades\Crypt;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem as FlysystemFilesystem;
use League\Glide\Server;

class ImageController extends Controller
{
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

	private function imageRequestValidation($path) {
		try {
			// Set complicated sign key
			$signkey = 'The strongest of all warriors are these two, patience and time...';
		
			// Validate HTTP signature
			SignatureFactory::create($signkey)->validateRequest($path, $_GET);
		
		} catch (SignatureException $e) {
			// Handle error
			dd("error");
		}
	}

	public static function ThumbnailUrlBuilder($path) {
		// Set complicated sign key
		$signkey = 'The strongest of all warriors are these two, patience and time...';

		// Create an instance of the URL builder
		$urlBuilder = UrlBuilderFactory::create('/img/', $signkey);

		// Generate a URL
		$url = $urlBuilder->getUrl($path, ["w" => 400, "h" => 400, "fit" => "crop"]);

		return $url;
	}

}

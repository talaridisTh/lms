<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Filesystem\Filesystem;
use League\Glide\Responses\LaravelResponseFactory;
use League\Glide\ServerFactory;
use League\Glide\Signatures\SignatureFactory;
use League\Glide\Signatures\SignatureException;
use League\Glide\Urls\UrlBuilderFactory;
use Illuminate\Support\Facades\Crypt;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem as FlysystemFilesystem;
use League\Flysystem\FilesystemInterface;
use League\Glide\Server;

class ImageController extends Controller
{
	public function show(Server $server, $path) {

		$temp = explode("/", $path);
		$image = array_pop($temp);
		$source = implode("/", $temp);
		array_shift($temp);
		$cache = implode("/", $temp);

		// $this->imageRequestValidation("./$source/$image");

		$source = new FlysystemFilesystem( new Local($source) );

		$server->setSource($source);
		$server->setCachePathPrefix(".cache/$cache");

		$server->outputImage($image, $_GET);

		// $secret = Crypt::encryptString("test");
		// dd($secret);

        // $server = ServerFactory::create([
        //     'response' => new LaravelResponseFactory(app('request')),
        //     'source' => "$storage/$type/$date/",
		// 	'cache' => "storage/",
		// 	// 'source_path_prefix' => 'storage/images/2020.11/',
        //     'cache_path_prefix' => ".cache/$type/$date",
		// 	'base_url' => 'img',
		// 	'max_image_size' => 2000*2000,
		// ]);

        // return $server->getImageResponse($image, request()->all());
	}

	private function imageRequestValidation($path) {
		try {
			// Set complicated sign key
			$signkey = 'v-LK4WCdhcfcc%jt*VC2cj%nVpu+xQKvLUA%H86kRVk_4bgG8&CWM#k*b_7MUJpmTc=4GFmKFp7=K%67je-skxC5vz+r#xT?62tT?Aw%FtQ4Y3gvnwHTwqhxUh89wCa_';
			// $signkey = Crypt::encryptString("!Dark_Pony_Glide_Image_Url_Encryption!");
		
			// Validate HTTP signature
			SignatureFactory::create($signkey)->validateRequest($path, $_GET);
		
		} catch (SignatureException $e) {
			// Handle error
			dd("error");
		}
	}

	public static function ThumbnailUrlBuilder($path) {
		// Set complicated sign key
		$signkey = 'v-LK4WCdhcfcc%jt*VC2cj%nVpu+xQKvLUA%H86kRVk_4bgG8&CWM#k*b_7MUJpmTc=4GFmKFp7=K%67je-skxC5vz+r#xT?62tT?Aw%FtQ4Y3gvnwHTwqhxUh89wCa_';
		// $signkey = Crypt::encryptString("!Dark_Pony_Glide_Image_Url_Encryption!");
			
		// Create an instance of the URL builder
		$urlBuilder = UrlBuilderFactory::create('/img/', $signkey);
			
		// Generate a URL
		$url = $urlBuilder->getUrl($path, ["w" => 400, "h" => 400, "fit" => "crop"]);

		return $url;
	}

}

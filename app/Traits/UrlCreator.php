<?php

namespace App\Traits;

use League\Glide\Urls\UrlBuilderFactory;

trait UrlCreator {

    public function thumbnailUrl() {
        $signkey = 'The strongest of all warriors are these two, patience and time...';

        // Create an instance of the URL builder
        $urlBuilder = UrlBuilderFactory::create('/img/', $signkey);

        // Generate a URL
        $url = $urlBuilder->getUrl($this->attributes['cover'], ["w" => 400, "h" => 400, "fit" => "crop"]);

        return $url;
	}
	
	public function cardSmallUrl() {
        // Set complicated sign key
        $signkey = 'The strongest of all warriors are these two, patience and time...';

        // Create an instance of the URL builder
        $urlBuilder = UrlBuilderFactory::create('/img/', $signkey);

        // Generate a URL
        $url = $urlBuilder->getUrl($this->attributes['cover'], ["w" => 400, "h" => 225, "fit" => "crop"]);

        return $url;
	}
	
	public function cardMediumUrl() {
        // Set complicated sign key
        $signkey = 'The strongest of all warriors are these two, patience and time...';

        // Create an instance of the URL builder
        $urlBuilder = UrlBuilderFactory::create('/img/', $signkey);

        // Generate a URL
        $url = $urlBuilder->getUrl($this->attributes['cover'], ["w" => 600, "h" => 377, "fit" => "crop"]);

        return $url;
    }
}
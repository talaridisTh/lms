<?php

namespace App\Traits;

use League\Glide\Urls\UrlBuilderFactory;

trait UrlCreator {

    public function thumbnailUrl($column = "cover") {
        $signkey = 'The strongest of all warriors are these two, patience and time...';

        // Create an instance of the URL builder
        $urlBuilder = UrlBuilderFactory::create('/img/', $signkey);

        // Generate a URL
        $url = $urlBuilder->getUrl($this->attributes[$column], ["w" => 400, "h" => 400, "fit" => "crop"]);


        return $url;
	}

    public function roundedSmallCoverUrl($column = "cover") {
        $signkey = 'The strongest of all warriors are these two, patience and time...';

        // Create an instance of the URL builder
        $urlBuilder = UrlBuilderFactory::create('/img/', $signkey);

        // Generate a URL
        $url = $urlBuilder->getUrl($this->attributes[$column], ["w" => 100, "h" => 100, "fit" => "crop"]);

        return $url;
    }

    public function roundedMediumCoverUrl($column = "cover") {
        $signkey = 'The strongest of all warriors are these two, patience and time...';

        // Create an instance of the URL builder
        $urlBuilder = UrlBuilderFactory::create('/img/', $signkey);

        // Generate a URL
        $url = $urlBuilder->getUrl($this->attributes[$column], ["w" => 200, "h" => 200, "fit" => "crop"]);

        return $url;
    }

	public function cardSmallUrl($column = "cover") {
        // Set complicated sign key
        $signkey = 'The strongest of all warriors are these two, patience and time...';

        // Create an instance of the URL builder
        $urlBuilder = UrlBuilderFactory::create('/img/', $signkey);

        // Generate a URL
        $url = $urlBuilder->getUrl($this->attributes[$column], ["w" => 400, "h" => 225, "fit" => "crop"]);

        return $url;
	}

	public function cardMediumUrl($column = "cover") {
        // Set complicated sign key
        $signkey = 'The strongest of all warriors are these two, patience and time...';

        // Create an instance of the URL builder
        $urlBuilder = UrlBuilderFactory::create('/img/', $signkey);

        // Generate a URL
        $url = $urlBuilder->getUrl($this->attributes[$column], ["w" => 600, "h" => 377, "fit" => "crop"]);

        return $url;
    }
}

<?php

namespace App\Traits;

use App\Models\Option;
use League\Glide\Urls\UrlBuilderFactory;

trait UrlCreator {

	private function dimensions() {
		$temp = Option::where("name", "Image Dimensions")->first();
		$fallback = '{"thumbnail":{"style":{"w":400,"h":400,"fit":"crop"}},"card-small":{"style":{"w":400,"h":225,"fit":"crop"}},"card-medium":{"style":{"w":600,"h":377,"fit":"crop"}},"rounded-small":{"style":{"w":100,"h":100,"fit":"crop"}},"rounded-medium":{"style":{"w":200,"h":200,"fit":"crop"}}}';

		return !is_null($temp) ? json_decode($temp->value) : json_decode($fallback);
	}

    public function thumbnailUrl($column = "cover") {
        $signkey = 'The strongest of all warriors are these two, patience and time...';

        // Create an instance of the URL builder
        $urlBuilder = UrlBuilderFactory::create('/img/', $signkey);

        // Generate a URL
        $url = $urlBuilder->getUrl($this->attributes[$column], (array)$this->dimensions()->thumbnail->style);

        return $url;
	}

    public function roundedSmallCoverUrl($column = "cover") {
        $signkey = 'The strongest of all warriors are these two, patience and time...';

        // Create an instance of the URL builder
        $urlBuilder = UrlBuilderFactory::create('/img/', $signkey);

        // Generate a URL
        $url = $urlBuilder->getUrl($this->attributes[$column], (array)$this->dimensions()->{"rounded-small"}->style);

        return $url;
    }

    public function roundedMediumCoverUrl($column = "cover") {
        $signkey = 'The strongest of all warriors are these two, patience and time...';

        // Create an instance of the URL builder
        $urlBuilder = UrlBuilderFactory::create('/img/', $signkey);

        // Generate a URL
        $url = $urlBuilder->getUrl($this->attributes[$column], (array)$this->dimensions()->{"rounded-medium"}->style);

        return $url;
    }

	public function cardSmallUrl($column = "cover") {
        // Set complicated sign key
        $signkey = 'The strongest of all warriors are these two, patience and time...';

        // Create an instance of the URL builder
        $urlBuilder = UrlBuilderFactory::create('/img/', $signkey);

        // Generate a URL
        $url = $urlBuilder->getUrl($this->attributes[$column], (array)$this->dimensions()->{"card-small"}->style);

        return $url;
	}

	public function cardMediumUrl($column = "cover") {
        // Set complicated sign key
        $signkey = 'The strongest of all warriors are these two, patience and time...';

        // Create an instance of the URL builder
        $urlBuilder = UrlBuilderFactory::create('/img/', $signkey);

        // Generate a URL
        $url = $urlBuilder->getUrl($this->attributes[$column], (array)$this->dimensions()->{"card-medium"}->style);

        return $url;
    }
}

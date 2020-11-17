<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use League\Glide\Urls\UrlBuilderFactory;

class Media extends Model
{
	use HasFactory;

	public static $icons = [
		"mp3" => "mdi-music-clef-treble",
		"ev3" => "mdi-robot-industrial",
		"pdf" => "mdi-file-pdf-outline text-danger",
		"html" => "mdi-language-html5 text-danger",
		"odg" => "mdi-file-pdf text-danger",
		"doc" => "mdi-file-document-outline text-teal",
		"odt" => "mdi-file-document-outline text-teal",
		"rtf" => "mdi-file-document-outline text-teal",
		"xl" => "mdi-file-table-box text-success",
		"ods" => "mdi-file-table-box text-success",
		"pp" => "mdi-file-powerpoint-outline text-orange",
		"odp" => "mdi-file-powerpoint-outline text-orange",
		"sb3" => "mdi-cat text-orange",
		"zip" => "mdi-folder-zip-outline text-warning",
		"rar" => "mdi-folder-zip-outline text-warning",
	];

	public function courses()
    {
        return $this->morphedByMany('App\Course', 'mediable');
	}

	public function materials()
    {
        return $this->morphedByMany('App\Material', 'mediable')->withPivot('usage');
	}

	public function bundles()
    {
        return $this->morphedByMany('App\Bundle', 'mediable');
    }

    public function mediaDetails()
    {
        return $this->hasOne('App\MediaDetails');
	}

    public function users()
    {
        return $this->morphedByMany('App\User', 'mediable');
	}

	public function thumbnailUrl() {
		// Set complicated sign key
		$signkey = 'The strongest of all warriors are these two, patience and time...';

		// Create an instance of the URL builder
		$urlBuilder = UrlBuilderFactory::create('/img/', $signkey);

		// Generate a URL
		$url = $urlBuilder->getUrl($this->attributes['rel_path'], ["w" => 400, "h" => 400, "fit" => "crop"]);

		return $url;
	}

    public function cardImageUrl() {
        // Set complicated sign key
        $signkey = 'The strongest of all warriors are these two, patience and time...';

        // Create an instance of the URL builder
        $urlBuilder = UrlBuilderFactory::create('/img/', $signkey);

        // Generate a URL
        $url = $urlBuilder->getUrl($this->attributes['rel_path'], ["w" => 400, "h" => 225, "fit" => "crop"]);

        return $url;
    }
}

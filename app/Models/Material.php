<?php

namespace App\Models;

use App\Traits\SlugCreator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use League\Glide\Urls\UrlBuilderFactory;
use App\Traits\UrlCreator;

class Material extends Model {

	use HasFactory;
	use UrlCreator;
	use SlugCreator;

    protected $guarded = [];

    public function chapters()
    {
        return $this->belongsToMany(
            Material::class, "material_section",
            "section_id", "material_id"
        )->withPivot('status', 'priority', 'highlight', 'publish_at');
    }
    public function activeChapters()
    {
        return $this->belongsToMany(
            Material::class, "material_section",
            "section_id", "material_id"
        )->withPivot('status', 'priority', 'highlight', 'publish_at')
            ->wherePivot("status", 1)
            ->wherePivot("publish_at", "<=", now());
    }

    public function courses()
    {

        return $this->belongsToMany(Course::class)->withPivot('status', 'priority');
	}

    public function media()
    {

        return $this->morphToMany(Media::class, 'mediable')->withPivot('usage', 'priority');
    }

    public function mediaDetails()
    {

        return $this->hasOne(MediaDetails::class, 'media_id');
    }

    public function users()
    {

        return $this->belongsToMany(User::class);
    }

    public function topics()
    {

        return $this->morphToMany(Topic::class, 'topicable');
    }

    public function watchlists()
    {

        return $this->morphToMany(User::class, 'watchlistable');
    }

    public function post()
    {
        return $this->morphMany(Post::class, 'postable');
    }

    public function witchlist()
    {
        return $this->belongsToMany(Course::class,'witchlist',"material_id","course_id" );
    }

    public function getRouteKeyName()
    {
        return "slug";
    }

    public static function getIcon($value)
    {
        $icons = [
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
        foreach ($icons as $type => $icon)
        {
            if (fnmatch("$type*", $value))
            {
                return $icon;
            }
        }
    }


    public static function getType($value)
    {
        $icons = [
            "Lesson" => "mdi  mdi-book-open-page-variant ",
            "Link" => 'mdi  mdi-satellite-uplink mr-1 text-red-500',
            "Video" => "mdi  mdi-motion-play-outline  ",
            "Pdf" =>"mdi  mdi-file-pdf  "

        ];
        foreach ($icons as $type => $icon)
        {
            if (fnmatch("$type*", $value))
            {

                return $icon;
            }
        }
    }

	public function publishBadge() {
		if ( $this->pivot->status == 1 ) {
			if ( time() > strtotime($this->pivot->publish_at) && !is_null($this->pivot->publish_at) ) {
				return (object)[
					"icon" => "badge-outline-success",
					"text" => "Published"
				];
			}
			else {
				return (object)[
					"icon" => "custom-pill-primary badge-outline-primary",
					"text" => "Scheduled"
				];
			}
		}
		else {
			return (object)[
				"icon" => "badge-outline-danger",
				"text" => "Draft"
			];
		}
	}

	public function publishDate() {
		if ( !is_null($this->pivot->publish_at) ) {
			$publish = date_create($this->pivot->publish_at);

			return (object)[
				"publish" => $publish,
				"date" => date_format($publish, "d-m-Y"),
				"time" => date_format($publish, "H:i")
			];
		}
		else {
			return (object)[
				"publish" => "",
				"date" => "",
				"time" => ""
			];
		}
	}

    public function imageUrlSmall() {
        // Set complicated sign key
        $signkey = 'The strongest of all warriors are these two, patience and time...';

        // Create an instance of the URL builder
        $urlBuilder = UrlBuilderFactory::create('/img/', $signkey);

        // Generate a URL
        $url = $urlBuilder->getUrl($this->attributes['cover'], ["w" => 400, "h" => 225, "fit" => "crop"]);

        return $url;
    }

}

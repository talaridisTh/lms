<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use League\Glide\Urls\UrlBuilderFactory;

class Material extends Model {

    use HasFactory;

    protected $guarded = [];

    public function chapters()
    {
        return $this->belongsToMany(
            Material::class, "material_section",
            "section_id", "material_id"
        )->withPivot('status', 'priority', 'highlight');
    }

    public function courses()
    {

        return $this->belongsToMany(Course::class)->withPivot('status', 'priority');
    }

    // public function coursesMaterial()
    // {

    //     return $this->hasMany(CourseMaterial::class);
    // }

    public function media()
    {

        return $this->morphToMany('App\Media', 'mediable')->withPivot('usage', 'priority');
    }

    public function mediaDetails()
    {

        return $this->hasOne('App\MediaDetails', 'media_id');
    }

    public function users()
    {

        return $this->belongsToMany(User::class);
    }

    public function topics()
    {

        return $this->morphToMany('App\Topic', 'topicable');
    }

    public function watchlists()
    {

        return $this->morphToMany('App\User', 'watchlistable');
    }

//    public function witchlist()
//    {
//        return $this->hasMany(Witchlist::class);
//    }

    public function witchlist()
    {
        return $this->belongsToMany(Course::class,'witchlist',"material_id","course_id" );
    }

    public function getRouteKeyName()
    {
        return "slug";
    }

//    public function priority($material, $course)
//    {
//
//
//
//        return $test = DB::table('course_material')
//            ->where("course_id", $course)
//            ->where("material_id", $material)
//            ->select("priority")
//            ->first();
//
//    }

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
            "Lesson" => "mdi mdi-file-document-outline text-success",
            "Link" => 'mdi mdi-link-variant-plus text-info',
            "Announcement" => "mdi mdi-comment-quote-outline text-danger",
            "Video" => "mdi mdi-camcorder text-primary",

        ];
        foreach ($icons as $type => $icon)
        {
            if (fnmatch("$type*", $value))
            {

                return $icon;
            }
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

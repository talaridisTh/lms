<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Material extends Model {

    use HasFactory;

    protected $guarded = [];

    public function chapters()
    {

        return $this->belongsToMany(
            Material::class, "material_section",
            "section_id", "material_id"
        )->withPivot('status', 'priority');
    }

    public function courses()
    {

        return $this->belongsToMany(Course::class)->withPivot('status', 'priority');
    }

    public function coursesMaterial()
    {

        return $this->hasMany(CourseMaterial::class);
    }

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
            "mp3" => "mdi-play-circle-outline",
            "pdf" => "mdi-file-pdf-outline text-danger",
            "doc" => "mdi-file-document-outline text-teal",
            "odt" => "mdi-file-document-outline text-teal",
            "rtf" => "mdi-file-document-outline text-teal",
            "xl" => "mdi-file-table-box text-success",
            "ods" => "mdi-file-table-box text-success",
            "pp" => "mdi-file-powerpoint-outline text-orange",
            "odp" => "mdi-file-powerpoint-outline text-orange",
            "zip" => "mdi-folder-zip-outline text-warning",
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

//    public function getTypeAttribute($value)
//    {
//        if (!isset(request()->route()->uri))
//        {
//            return $value;
//        } elseif (request()->route()->getName() == 'index.userCourse' || request()->route()->getName() == 'index.material.show')
//        {
//            if ($value == 'Lesson')
//            {
//                return 'mdi mdi-file-document-outline text-success';
//            } elseif ($value == 'Link')
//            {
//                return 'mdi mdi-link-variant-plus text-info';
//            } elseif ($value == 'Announcement')
//            {
//                return 'mdi mdi-comment-quote-outline text-danger';
//            } elseif ($value == 'Video')
//            {
//                return 'mdi mdi-camcorder text-primary';
//            } elseif ($value == 'Section')
//            {
//                return $value;
//            }
//        } else return $value;
//    }

}

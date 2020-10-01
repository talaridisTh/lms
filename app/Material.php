<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Material extends Model {

    use HasFactory;

	protected $guarded = [];
	
	public function sections() {

		return $this->belongsToMany(Section::class);

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

    public function witchlist()
    {
        return $this->hasMany(Witchlist::class);
    }

    public function getRouteKeyName()
    {
        return "slug";
    }

    public function priority($material, $course)
    {

        return $test = DB::table('course_material')
            ->where("course_id", $course)
            ->where("material_id", $material)
            ->select("priority")
            ->first()->priority;
    }

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


        foreach( $icons as $type => $icon ) {
            if ( fnmatch("$type*", $value ) ) {
                return $icon;
            }
        }
    }

    public function getTypeAttribute($value)
    {

        if (request()->route()->getName() == 'index.userCourse' || request()->route()->getName() == 'index.material.show')
        {
            if ($value == 'Lesson')
            {
                return 'mdi mdi-file-document-outline text-success';
            } elseif ($value == 'Link')
            {
                return 'mdi mdi-link-variant-plus text-info';
            } elseif ($value == 'Announcement')
            {
                return 'mdi mdi-comment-quote-outline text-danger';
            } elseif ($value == 'Video')
            {
                return 'mdi mdi-camcorder text-primary';
            }
        } else return $value;
    }

}

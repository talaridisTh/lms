<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;



class Material extends Model
{
//    soft-delete
//    use SoftDeletes;


    protected $guarded = [];

    public function courses() {

		return $this->belongsToMany(Course::class)->withPivot('status', 'priority');

	}

    public function coursesMaterial() {

        return $this->hasMany(CourseMaterial::class);



	}



	public function media() {

		return $this->morphToMany('App\Media', 'mediable')->withPivot('usage');

	}

	public function users() {





		return $this->belongsToMany(User::class);

	}

	public function topics() {

		return $this->morphToMany('App\Topic', 'topicable');

	}

	public function watchlists() {

		return $this->morphToMany('App\User', 'watchlistable');

	}


    public function getRouteKeyName()
    {
        return "slug";

    }


    public function priority( $material , $course) {

       return  $test =  DB::table('course_material')
            ->where("course_id",$course)
            ->where("material_id",$material)
            ->select("priority")
            ->first()->priority;

    }

    public function getVideoLinkAttribute($value)
    {
        if (strlen($value) >12){

            $test = explode("/", $value);

        return "https://player.vimeo.com/video/" . $test[3];
    }else
        return $value;

    }

    public function getTypeAttribute($value)
    {
        if( request()->route()->getName()=='index.userCourse'){
            if($value=='Lesson'){
                return 'mdi mdi-file-document-outline';
            }
            elseif ($value=='Link'){
                return 'mdi mdi-link-variant-plus';

            }
            elseif ($value=='Announcement'){
                return 'mdi mdi-comment-quote-outline';

            }
            elseif ($value=='Video'){
                return 'mdi mdi-camcorder';

            }

        }
        else return $value;


    }

}

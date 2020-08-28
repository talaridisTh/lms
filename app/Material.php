<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Material extends Model
{

    protected $guarded = [];

    public function courses() {

		return $this->belongsToMany(Course::class)->withPivot('active', 'priority')->orderBy('priority');

	}

    public function coursesMaterial() {

        return $this->hasMany(CourseMaterial::class);



	}

    public function priority( $material , $course) {

        return DB::table('course_material')
            ->where("course_id",$course)
            ->where("material_id",$material)
            ->select("priority")
            ->first()->priority;
    }

	public function users() {


		return $this->belongsToMany(User::class);

	}

	public function topics() {

		return $this->morphToMany('App\Topic', 'topicable');

	}

    public function getUpdatedAtAttribute($value)
	{

	    return  Carbon::parse($value)->diffForHumans();


	}

    public function getRouteKeyName()
    {
        return "slug";

    }

}

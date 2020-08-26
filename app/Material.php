<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{

    protected $guarded = [];

    public function courses() {

		return $this->belongsToMany(Course::class)->withPivot('active', 'priority');

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

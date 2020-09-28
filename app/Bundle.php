<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bundle extends Model
{
	use SoftDeletes;
    use HasFactory;

	public function media() {

		return $this->morphToMany('App\media', 'mediable');

	}

	public function users() {

		return $this->belongsToMany(User::class);

	}
	
	public function courses() {

		return $this->belongsToMany(Course::class);

	}

	public function getRouteKeyName()
    {
        return "slug";

    }

}

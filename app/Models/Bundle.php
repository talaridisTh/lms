<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\UrlCreator;

class Bundle extends Model
{
	use SoftDeletes;
	use HasFactory;
	use UrlCreator;

	public function media() {

		return $this->morphToMany(Media::class, 'mediable');

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

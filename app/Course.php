<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public function materials() {

		return $this->belongsToMany('App\Material')->withPivot('priority');

	}

	public function bundles() {

		return $this->belongsToMany('App\Bundle');

	}

	public function users() {

		return $this->belongsToMany('App\User');

	}
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    public function courses() {

		return $this->belongsToMany('App/Course');

	}

	public function users() {

		return $this->belongsToMany('App/User');

	}

	public function topics() {

		return $this->belongsToMany('App/Topic');

	}
}

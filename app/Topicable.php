<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topicable extends Model
{
    public function materials() {

		return $this->morphedByMany('App\Material', 'topicable');

	}

	public function courses() {

		return $this->morphedByMany('App\Material', 'topicable');
		
	}
}

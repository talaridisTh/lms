<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{




    public function materials() {

		return $this->morphedByMany("App\Material", "topicable");

	}

	public function courses() {

		return $this->morphedByMany("App\Course", "topicable");

	}






}

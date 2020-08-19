<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Bundle extends Model
{
	public function courses() {

		return $this->belongsToMany(Course::class);

	}


}

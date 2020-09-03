<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Bundle extends Model
{
	use SoftDeletes;

	public function courses() {

		return $this->belongsToMany(Course::class);

	}


}

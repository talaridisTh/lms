<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bundle extends Model
{
	public function courses() {

		return $this->belongsToMany('App\Course');

	}
}

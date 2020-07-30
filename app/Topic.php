<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    public function materials() {

		return $this->belongsToMany('App/Material');

	}
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topicable extends Model
{
    public function materials() {

		return $this->morphedByMany(Material::class, 'topicable');

	}

	public function courses() {

		return $this->morphedByMany(Material::class, 'topicable');
		
	}
}

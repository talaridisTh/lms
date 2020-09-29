<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
	use HasFactory;

    protected $guarded = [];
    public function materials() {

		return $this->morphedByMany("App\Material", "topicable");

	}

	public function courses() {

		return $this->morphedByMany("App\Course", "topicable");

	}

}

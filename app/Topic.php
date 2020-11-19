<?php

namespace App;

use App\Traits\UrlCreator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
	use HasFactory;
    use UrlCreator;

    protected $guarded = [];
    public function materials() {

		return $this->morphedByMany("App\Material", "topicable");

	}

	public function courses() {

		return $this->morphedByMany("App\Course", "topicable");

	}

}

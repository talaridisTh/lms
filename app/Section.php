<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
	use HasFactory;
	
	public function materials(){

        return $this->belongsToMany(Material::class)->withPivot('status', 'priority', 'publish_at');
	
	}

	public function course() {

		return $this->belongsTo('App\Course');

	}
}

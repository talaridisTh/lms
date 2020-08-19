<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    public function materials() {

		return $this->belongsToMany(Material::class);

	}

}

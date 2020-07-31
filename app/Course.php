<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public function materials() {

		return $this->belongsToMany('App\Material')->withPivot('priority');

	}

	public function bundles() {

		return $this->belongsToMany('App\Bundle');

	}

	public function users() {

		return $this->belongsToMany('App\User');

	}

    // $user->created_at  // egrafi prin 20 lepta
    public function getCreatedAtAttribute($value)
    {
        $carbonDate = new Carbon($value);

        return $carbonDate->diffForHumans();
    }

    // $user->update_at  //update prin 20 lepta
    public function getUpdatedAtAttribute($value)
    {
        $carbonDate = new Carbon($value);

        return $carbonDate->diffForHumans();
    }
}

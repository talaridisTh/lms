<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    public function courses() {

		return $this->belongsToMany(Course::class);

	}

	public function users() {


		return $this->belongsToMany(User::class);

	}

	public function topics() {

		return $this->belongsToMany(Topic::class);

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

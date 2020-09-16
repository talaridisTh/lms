<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Watchlistable extends Model
{

    public function materials() {

        return $this->morphedByMany('App\Material', 'watchlistable');

    }

    public function courses() {

        return $this->morphedByMany('App\Material', 'watchlistable');

    }

}

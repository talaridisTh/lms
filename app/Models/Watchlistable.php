<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Watchlistable extends Model
{
    use HasFactory;

    public function materials() {

        return $this->morphedByMany(Material::class, 'watchlistable');

    }

    public function courses() {

        return $this->morphedByMany(Material::class, 'watchlistable');

    }

}

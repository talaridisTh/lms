<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Likable extends Model
{
    use HasFactory;



    public function likable()
    {
        return $this->morphTo();
    }
}

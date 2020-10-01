<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Witchlist extends Model
{
    use HasFactory;

    public $timestamps = [ "created_at" ];

    public function materials()
    {
        return $this->hasMany(Material::class);
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    public function details()
    {
        return $this->belongsTo('App\MediaDetails');
    }
}

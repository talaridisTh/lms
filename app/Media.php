<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
	public $timestamps = false;

	public function courses()
    {
        return $this->morphedByMany('App\Course', 'mediable');
	}
	
	public function materials()
    {
        return $this->morphedByMany('App\Material', 'mediable');
	}
	
	public function bundles()
    {
        return $this->morphedByMany('App\Bundle', 'mediable');
    }

    public function details()
    {
        return $this->belongsTo('App\MediaDetails');
    }
}

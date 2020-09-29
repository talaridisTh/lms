<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

	public function users() {

		return $this->belongsToMany( User::class, 'model_has_roles', 'role_id', 'model_id' );

	}
	
}

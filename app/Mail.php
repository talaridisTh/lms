<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mail extends Model
{
	use HasFactory;
	
	//! WARNING epidi to function den exei onoma "user" i "users"
	//! prepei na orisoume to foreing key
	public function author() {
		return $this->belongsTo("App\User", "user_id");
	}
}

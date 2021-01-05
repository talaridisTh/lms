<?php

namespace App\Models;

use App\Traits\UrlCreator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
	use HasFactory,UrlCreator;

	protected $fillable = ["name"];
}

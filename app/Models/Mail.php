<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mail extends Model
{
	use HasFactory, SoftDeletes;

	protected $guarded = [];

	public function author() {
		return $this->belongsTo(User::class, "user_id");
	}

	public function attachments() {

		return $this->morphMany(Attachment::class, "attachmentable");
	}
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MediaDetails extends Model
{
    use HasFactory;

	public function media()
    {
        return $this->belongsTo(Media::class);
    }
}

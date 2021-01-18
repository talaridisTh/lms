<?php

namespace App\Models;

use App\Traits\IconFinder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model {

    use HasFactory, IconFinder;

    protected $guarded = [];

    public function attachmentable()
    {
        return $this->morphTo();
    }

    public function mail()
    {
        return $this->belongsTo(Mail::class);
    }

    public function post()
    {
        return $this->morphMany(Post::class, 'postable');
    }

    public function homework()
    {
        return $this->belongsTo(Homework::class, "attachmentable_id");

    }

}

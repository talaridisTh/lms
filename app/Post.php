<?php

namespace App;

use App\Traits\UrlCreator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory,UrlCreator;

    protected $guarded= [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function postable()
    {
        return $this->morphTo();
    }
    public function getCourse()
    {
        return $this->course?$this->course->title:"General";

    }

    public function likes()
    {
        return $this->morphToMany(User::class, 'likable');
    }
}

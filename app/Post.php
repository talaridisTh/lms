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

    public function course()
    {
        return $this->belongsTo(Course::class);
    }


    public function getCourse()
    {
        return $this->course?$this->course->title:"General";

    }

    public function likes()
    {
        return $this->morphToMany(User::class, 'likable');
    }

//    public function getRouteKeyName()
//    {
//        return "slug";
//
//    }
}

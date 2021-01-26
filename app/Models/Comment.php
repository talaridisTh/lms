<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function announcement()
    {
        return $this->hasOne(Announcement::class, 'id', "commentable_id");
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function likes()
    {
        return $this->morphToMany(User::class, 'likable');
    }

    public function isLikedCount()
    {

        return $this->likes->count() ? $this->likes->count() : "";

    }

    public function media()
    {

        return $this->morphToMany(Media::class, 'mediable')->withPivot('usage', 'priority');
    }

    public function scopeIsAnnouncement($query)
    {
        return $query->where('commentable_type', "App\Models\Announcement");
    }

}

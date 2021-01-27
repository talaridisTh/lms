<?php

namespace App\Models;

use App\Traits\UrlCreator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable {

    use Notifiable, HasRoles, HasFactory, UrlCreator;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * relationship
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        // your other new column
    ];

    public static function courseWhereActive()
    {

        return Course::where("status", 1)->get();

    }

    public static function getlastMessage($user)
    {
        if (isset(User::findOrFail($user)->sentMessage()->orderBy('updated_at', 'DESC')->first()->message)) {

            return User::findOrFail($user)->sentMessage()->orderBy('updated_at', 'DESC')->first()->message;
        } else {

            return "";
        }

    }

    public function activity()
    {

        return $this->morphMany(Activity::class, "causer", "causer_type", "causer_id");

    }

//    CUSTOM METHOD
    public function mails()
    {

        return $this->hasMany(Mail::class);
    }

    public function bundles()
    {

        return $this->belongsToMany(Bundle::class);

    }

    public function likeComment()
    {
        return $this->morphedByMany(Comment::class, 'likable');
    }

    public function likePost()
    {
        return $this->morphedByMany(Post::class, 'likable');
    }

    public function getPosts()
    {
        $models = $this->comments()->where("commentable_type", "!=", "App\Models\Announcement")
            ->get(["commentable_id", "commentable_type"])->unique('commentable_id')->map(function ($model) {
                return $model->commentable_type::find($model->commentable_id);
            });

        return collect($models);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function announcement()
    {
        return $this->morphMany(Announcement::class, 'announcementable');
    }

    public function guest()
    {
        return $this->belongsToMany(User::class, 'guest_user', 'partner_id', "user_id")->withPivot("user_link");
    }

    public function homeworks()
    {
        return $this->hasMany(Homework::class, "student_id");
    }

    public function media()
    {

        return $this->morphToMany(Media::class, 'mediable');

    }

    public function materials()
    {

        return $this->belongsToMany(Material::class);
    }

    public function getAnnouncementCourse()
    {
//        return $this->comments()->where("commentable_type", "App\Models\Announcement")->get();
        return auth()->user()->courses()->with("announcement.comments")->get()->pluck("announcement")->collapse();
    }

    // $user->fullName  // Onoma Epitheto
    public function courses()
    {

        return $this->belongsToMany(Course::class)->withTimestamps();
    }

    public function getFullNameAttribute()
    {
        return $this->attributes['last_name'] . ' ' . $this->attributes['first_name'];
    }

    public function getRouteKeyName()
    {
        return "slug";

    }

    public function commentIsLiked($comment)
    {

        $like = auth()->user()->likeComment->whereIn("id", $comment->id)->first() ? true : false;

        return $like;
    }

}

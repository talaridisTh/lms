<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable {

    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'avatar', 'active', 'email', 'password',"avatar",
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function courses()
    {

        return $this->belongsToMany('App/Course');
    }

    public function materials()
    {

        return $this->belongsToMany('App/Material');
    }

    // $user->fullName  // Onoma Epitheto
    public function getFullNameAttribute()
    {
        return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
    }

    // $user->created_at  // egrafi prin 20 lepta
    public function getCreatedAtAttribute($value)
    {
        $carbonDate = new Carbon($value);

        return $carbonDate->diffForHumans();
    }

    // $user->update_at  //update prin 20 lepta
    public function getUpdatedAtAttribute($value)
    {
        $carbonDate = new Carbon($value);

        return $carbonDate->diffForHumans();
    }



}

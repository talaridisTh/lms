<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
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
        'first_name', 'last_name', 'avatar', 'active', 'email', 'password', "avatar",
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

        return $this->belongsToMany(Course::class);
        //otan to deis auto thimise mou na s pw kati an dn t exw ksexasei !
        //exoume themata me to App/courses klpa
    }

//        dd($ins);{
    public function materials()
    {

        return $this->belongsToMany(Material::class);
    }

    public static function findMaterials($user)
    {
        $materials = User::whereId($user)->with('courses.materials')->first();
        $materialArray = [];
        foreach ($materials->courses as $material)
        {

            array_push($materialArray, $material->materials);
        }

        return $materialArray;
    }

    public static function getInstructor()
    {
        return User::whereHas('courses.materials')->get();
    }


    public static function getMaterialsInstructor($user)
    {

        return User::whereId($user)->with('courses.materials')->whereHas('materials')->first();
    }

//exei lathos edw na t koitaksw
    public static function  getStudent()
    {
        return User::whereHas('courses.users')->get();

    }
    public static function getCountStudent($course)
    {
        return  DB::table("course_user")
             ->join("users","course_user.user_id","=","users.id")
             ->join("courses","course_user.course_id","=","courses.id")
             ->select('users.*')
            ->where("courses.id","=",$course )
             ->count();

    }




    public static function userIs($user)
    {

        return $user->getRoleNames()->first();
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

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

    public static function getIfExistInsuctorCourse($user,$courses)
    {

//          return $test= User::whereHas('materials')
//                ->with("materials.courses")
//                ->get()
//                ->where("id",$user)
//                ->first()
//                ->materials
//                ->first()
//                ->courses
//                ->where("id",$courses);
//
//        $test= User::whereHas('materials')
//            ->with("materials.courses")
//            ->get()
//            ->where("id",$user)
//            ->first();
//
//        if(isset($test["materials"])){
//          return is_null(!$test["materials"][0]["courses"]->whereIn("id",$courses));
//
//
//        }else
//            return  false;

         $test = DB::table("courses")
            ->join("course_material","courses.id","=","course_material.course_id")
            ->join("materials","course_material.material_id","=","materials.id")
            ->join("material_user","material_user.material_id","=","materials.id")
            ->join("users","material_user.user_id","=","users.id")
            ->where("users.id",$user)
            ->where("courses.id",$courses)
            ->select("courses.id")
            ->get();

        if (empty(!count($test))){
            return true;
        }else{
            return false;

        }


//         (isset($test)) {
//              return'$var is either 0, empty, or not set at all';
//    }



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

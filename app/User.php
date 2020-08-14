<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
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
    }

    public function guest()
    {

        return $this->belongsToMany('App\Course', 'guest_course', 'user_id', 'course_id')
            ->withTimestamps()
            ->withPivot("user_link",'id');
    }



    public function materials()
    {

        return $this->belongsToMany(Material::class);
    }

//    CUSTOM METHOD
    public static function getInstructor()
    {
        $users = User::whereHas("courses")->get();
        $instructor = [];
        foreach ($users as $user)
        {
            if ($user->getRoleNames()[0] == "instructor")
                array_push($instructor, $user);
        }

        return $instructor;
    }

    public static function getPartner()
    {
        $users = User::whereHas("courses")->get();
        $partner = [];
        foreach ($users as $user)
        {
            if ($user->getRoleNames()[0] == "partner")
                array_push($partner, $user);
        }

        return $partner;
    }

    public static function getStudent()
    {
        $users = User::whereHas("courses")->get();
        $student = [];
        foreach ($users as $user)
        {
            if ($user->getRoleNames()[0] == "student")
                array_push($student, $user);
        }

        return $student;
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

    public static function getCoursesInstructor($user)
    {

        return $authors = DB::table('course_user')
            ->join('users', 'course_user.user_id', '=', 'users.id')
            ->join('courses', 'courses.id', '=', 'course_user.course_id')
            ->whereIn('course_user.user_id', [7])
            ->select('courses.name')
            ->orderBy('courses.name')
            ->get();
    }

    public static function courseWhereNotExist($user)
    {
       $test = DB::table('courses')
           ->where('active', 1)
            ->whereNotIn('id',
                function ($query) use ($user) {

                    $query->select('course_id')
                        ->from('course_user')
                        ->where('user_id', $user)
                        ->get();
                }
            )
            ->get();
       return $test;
    }

    public static function getCountStudent($course)
    {
        return DB::table("course_user")
            ->join("users", "course_user.user_id", "=", "users.id")
            ->join("courses", "course_user.course_id", "=", "courses.id")
            ->select('users.*')
            ->where("courses.id", "=", $course)
            ->count();
    }

    public static function userIs($user)
    {

        return $user->getRoleNames()->first();
    }

    public static function ifExistUrl( $user)
    {

        $uri = $user->pivot->user_link;
        $request = Request::create($uri);
        return $request->hasValidSignature()==1? " Ενεργο": " Εληξε";
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

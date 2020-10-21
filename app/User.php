<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable {

    use Notifiable, HasRoles, HasFactory ;

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

	public function bundles() {

		return $this->belongsToMany(Bundle::class);

	}

    public function watchlistMaterial() {


        return $this->morphedByMany(Material::class, 'watchlistable');

    }
    public function watchlistCourse() {

        return $this->morphedByMany(Course::class, 'watchlistable');

    }

    public function courses()
    {

        return $this->belongsToMany(Course::class)->withTimestamps();
    }


    public function receiverMessasge()
    {

        return $this->hasMany(Message::class, "from","id");
    }

    public function sentMessage()
    {

        return $this->hasMany(Message::class, "to","id");
    }

//
//    public function guest()
//    {
//
//
//        return $this->belongsToMany('App\User', 'guest_user', 'user_id')
//            ->withTimestamps()
//            ->withPivot("user_link",'id');
//    }




    public function guest()
    {
        return $this->belongsToMany('App\User', 'guest_user', 'partner_id',"user_id")->withPivot("user_link");
    }


    public function GuestMaterials()
    {

        return $this->belongsToMany(Material::class);
    }


    public function role()
    {

        return $this->belongsToMany(Role::class, 'model_has_roles', 'role_id', 'model_id');
    }

    public function media() {

        return $this->morphToMany('App\Media', 'mediable');

    }

    public function materials()
    {

        return $this->belongsToMany(Material::class);
    }

//    public function Witchlist()
//    {
//        return $this->belongsToMany('App\User', 'Witchlist', 'user_id', 'material_id'  );
//    }

    public function witchlist()
    {
        return $this->belongsToMany(User::class,'witchlist', 'user_id', 'material_id'  );
    }


//    CUSTOM METHOD
    public static function getInstructor()
    {
//        $users = User::whereHas("courses")->get();
        $users = User::all();
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
           ->where('status', 1)
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
    public static function trialCourseWhereNotExist($user)
    {
       $test = DB::table('courses')
           ->where('status', 1)
           ->where("version","Trial")
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

    public static function courseWhereActive()
    {

        return Course::where("status",1)->get();

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

    public  static function getlastMessage($user){
	    if(isset(User::findOrFail($user)->sentMessage()->orderBy('updated_at','DESC')->first()->message)){

	       return User::findOrFail($user)->sentMessage()->orderBy('updated_at','DESC')->first()->message;
        }else
        {

            return "";
        }



    }

    public  static function getlastHour($user){
        if(isset(User::findOrFail($user)->sentMessage()->orderBy('updated_at','DESC')->first()->updated_at)){

            return User::findOrFail($user)->sentMessage()->orderBy('updated_at','DESC')->first()->updated_at->diffForHumans();
        }else
        {

            return "";
        }



    }



    // $user->fullName  // Onoma Epitheto
    public function getFullNameAttribute()
    {
        return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
    }

    public function getRouteKeyName()
    {
        return "slug";

    }

    // public function getCreatedAtAttribute($value)
    // {
    //     $carbonDate = new Carbon($value);
    //     return $carbonDate->diffForHumans();
    // }
    public function getUpdatedAtAttribute($value)
    {
        $carbonDate = new Carbon($value);
        return $carbonDate->diffForHumans();
    }

    public static function getNextId()
    {
        $statement = DB::select("show table status like 'users'");
        return $statement[0]->Auto_increment;
    }


}

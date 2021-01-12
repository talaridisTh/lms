<?php

namespace App\Models;

use App\Traits\UrlCreator;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Notifications\NewUserNotification;

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
    protected $attributes = [
        'seen' => '{
            "seen_message": 0,
            "seen_task": 0
        }'
    ];

	public function mails() {

		return $this->hasMany(Mail::class);
	}

	public function bundles() {

		return $this->belongsToMany(Bundle::class);

	}

    public function watchlistMaterial() {


        return $this->morphedByMany(Material::class, 'watchlistable')->withPivot("created_at")->withTimestamps();

    }
    public function watchlistCourse() {

        return $this->morphedByMany(Course::class, 'watchlistable')->withPivot("created_at")->withTimestamps();

    }

    public function courses()
    {

        return $this->belongsToMany(Course::class)->withTimestamps();
    }

    public function likeComment()
    {
        return $this->morphedByMany(Comment::class, 'likable');
    }

    public function likePost()
    {
        return $this->morphedByMany(Post::class, 'likable');
    }




    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function guest()
    {
        return $this->belongsToMany(User::class, 'guest_user', 'partner_id',"user_id")->withPivot("user_link");
    }


    public function guestMaterial()
    {

        return $this->belongsToMany(Material::class,"guest_material","user_id","material_id")->withPivot("course_id");
    }


    // public function role()
    // {

    //     return $this->belongsToMany(Role::class, 'model_has_roles', 'role_id', 'model_id');
    // }

    public function media() {

        return $this->morphToMany(Media::class, 'mediable');

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

        return $this->belongsToMany(Material::class,'witchlist', 'user_id', 'material_id'  )->withPivot("course_id");
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
        return $this->attributes['last_name'] . ' ' . $this->attributes['first_name'];
    }

    public function getRouteKeyName()
    {
        return "slug";

    }


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

    public function commentIsLiked($comment)
    {

        $like = auth()->user()->likeComment->whereIn("id",$comment->id)->first()?true :false;

       return $like;
    }

}

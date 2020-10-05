<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model {

	use SoftDeletes;
	use HasFactory;

	public function sections() {

		return $this->hasMany("App\Section");

	}

    public function media()
    {

        return $this->morphToMany('App\media', 'mediable');
    }

    public function curator()
    {

        return $this->belongsTo('App\User', "user_id");
    }

    public function topics()
    {

        return $this->morphToMany('App\Topic', 'topicable');
    }

    public function materials()
    {

        return $this->belongsToMany(Material::class)->withPivot('status', 'priority', 'publish_at');
    }

    public function bundles()
    {

        return $this->belongsToMany(Bundle::class);
    }

    public function users()
    {

        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function getRouteKeyName()
    {
        return "slug";
    }

    public static function notInCourseMaterials(Course $course)
    {

        $materials = DB::table('materials')
            ->where('status', 1)
            ->whereNotIn('id',
                function ($query) use ($course) {

                    $query->select('material_id')
                        ->from('course_material')
                        ->where('course_id', $course['id'])
                        ->get();
                }
            )
            ->get();

        return $materials;
    }

    public static function notInMaterialsCourse($material)
    {

        $materials = DB::table('courses')
            ->where('status', 1)
            ->whereNotIn('id',
                function ($query) use ($material) {

                    $query->select('course_id')
                        ->from('course_material')
                        ->where('material_id', $material)
                        ->get();
                }
            )
            ->get();

        return $materials;
    }

    public static function courseAuthors($lessonIds)
    {

        $authors = DB::table('material_user')
            ->join('users', 'material_user.user_id', '=', 'users.id')
            ->whereIn('material_user.material_id', $lessonIds)
            ->select('users.first_name', 'users.last_name')
            ->orderBy('users.last_name')
            ->get();

        return $authors;
    }

    public static function materialsOrderByPriority($courseId)
    {
        return DB::table("materials")
            ->join("course_material", "course_material.material_id", "=", "materials.id")
            ->where("course_id", $courseId)
            ->where("type","!=" ,"Announcement")
            ->where("type","!=" ,"Section")
            ->where("course_material.status", 1)
            ->orderBy("priority", 'asc')
            ->get();
    }

    public static function nextMaterial($courseId, $materialPriority)
    {
        return DB::table("materials")
            ->join("course_material", "course_material.material_id", "=", "materials.id")
            ->where("course_id", $courseId)
            ->where("course_material.status", 1)
            ->where("priority", '>', $materialPriority)
            ->orderBy("priority", 'asc')
            ->first();
    }

    public static function prevMaterial($courseId, $materialPriority)
    {
        return DB::table("materials")
            ->join("course_material", "course_material.material_id", "=", "materials.id")
            ->where("course_id", $courseId)
            ->where("course_material.status", 1)
            ->where("priority", '<', $materialPriority)
            ->orderBy("priority", 'desc')
            ->first();
    }

    public static function countActiveCourse()
    {
        return Course::where("status", 1)->where('type', "lesson")->get();
    }

    public static function topicInCourse(Course $course)
    {

        return Course::with('topics')->find($course->id)->topics()->get();
    }



}

<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Course extends Model
{
    public function materials() {

		return $this->belongsToMany(Material::class);

	}

	public function bundles() {

		return $this->belongsToMany(Bundle::class);

	}

	public function users() {

		return $this->belongsToMany(User::class);

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
	
	public static function notInCourseMaterials( Course $course ) {

		$authors =  DB::table('materials')
			->where('active', 1)
			->whereNotIn( 'id',
				function($query) use ($course) {

					$query->select('material_id')
						->from('course_material')
						->where('course_id', $course['id'])
						->get();

				}
			)
			->get();

		return $authors;
	}

	public static function courseAuthors( $lessonIds ) {

		$authors = DB::table('material_user')
			->join('users', 'material_user.user_id', '=', 'users.id')
			->whereIn('material_user.material_id', $lessonIds)
			->select('users.first_name', 'users.last_name')
			->orderBy('users.last_name')
			->get();

		return $authors;
	}
}

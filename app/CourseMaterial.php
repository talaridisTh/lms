<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CourseMaterial extends Pivot
{
	public $timestamps = false;

	public static function incrementPriority( $courseId, $priority ) {

		return CourseMaterial::where("course_id", $courseId)
			->where("priority", ">", $priority )
			->increment("priority");

	}
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseMaterial extends Pivot
{
    use HasFactory;

	public $timestamps = false;

	public static function incrementPriority( $courseId, $priority ) {

		return CourseMaterial::where("course_id", $courseId)
			->where("priority", ">", $priority )
			->increment("priority");

	}
}

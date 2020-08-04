<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class CourseController extends Controller
{

    public function index()
    {
		$courses = Course::all(['id', 'name', 'active', 'slug', 'updated_at', 'created_at']);

        return view('admin/courses/coursesMain')->withCourses($courses);
    }


    public function create()
    {

		return view('admin/courses/newCourse');

    }


    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
		
		$allRemainingMaterials = DB::table('materials')
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

		$materials = $course->materials()->orderBy('priority')->get();
		$lessonIds = [];

		foreach ($materials as $lesson) {
			array_push( $lessonIds, $lesson['id'] );
		};

		$authors = DB::table('material_user')
			->join('users', 'material_user.user_id', '=', 'users.id')
			->whereIn('material_user.material_id', $lessonIds)
			->select('users.first_name', 'users.last_name')
			->orderBy('users.last_name')
			->get();

		$data = [
			'course' => $course,
			'materials' => $materials,
			'allRemainingMaterials' => json_decode($allRemainingMaterials, true),
			'authors' => json_decode($authors, true),
		];

        return view('admin.courses.courseDetails')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        //
    }
}

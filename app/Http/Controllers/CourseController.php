<?php

namespace App\Http\Controllers;

use App\Course;
use App\Material;
use App\User;
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
		$lessons = $course->materials()->where('type', 'Lesson')->get();
		$additions = $course->materials()->where('type', '!=', 'Lesson')->get();
		$lessonIds = [];

		foreach ($lessons as $lesson) {
			array_push( $lessonIds, $lesson['id'] );
		};

		// $authors = Material::whereIn('id', $lessonIds)->users()->get();

		$data = [
			'course' => $course,
			'lessons' => $lessons,
			// 'authors' => $authors,
			'additions' => $additions
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

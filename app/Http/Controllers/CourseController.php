<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Requests\BundleCourseRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class CourseController extends Controller
{

    public function index()
    {
		$courses = Course::all(['id', 'title', 'active', 'slug', 'updated_at', 'created_at']);

        return view('admin/courses/coursesMain')->withCourses($courses);
    }


    public function create()
    {

		return view('admin/courses/newCourse');

    }


    public function store(BundleCourseRequest $request)
    {
		// if( !empty($_FILES['cover']['name']) ) {
		// 	$ext = $_FILES['cover']['type'] == "image/png" ? ".png" : ".jpeg";
		// 	$fileName = md5( $request->name ).$ext;
		// }

		$pattern = "/[^a-z0-9\x{0370}-\x{03FF}]/mu";

		$course = new Course;
		$course->title = $request->title;
		$course->description = $request->description;
		$course->active = $request->active;
		$course->slug = preg_replace($pattern, "-", mb_strtolower($request->title) );
		// $course->cover = isset($fileName) ? $fileName : "no_image_600x400.png";
		$course->cover = "https://placehold.co/600x400";
		
		$course->save();
		
		// if ( isset($fileName) ) {
		// 	$request->cover->storeAs("public/courses/$course->id/cover", $fileName);
		// }
		// else {
		// 	Storage::copy("public/no_image_600x400.png", "public/courses/$course->id/cover/no_image_600x400.png");
		// }
		
		return redirect( "/dashboard/course/$course->id" );

    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
		$allRemainingMaterials = Course::notInCourseMaterials( $course );
		$materials = $course->materials()->orderBy('priority')->get();
		$lessonIds = [];

		foreach ($materials as $lesson) {
			array_push( $lessonIds, $lesson['id'] );
		};

		$data = [
			'course' => $course,
			'materials' => $materials,
			'allRemainingMaterials' => json_decode($allRemainingMaterials, true),
		];

        return view('admin.courses.course')->with($data);
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
    public function update(BundleCourseRequest $request, Course $course)
    {
		$pattern = "/[^a-z0-9\x{0370}-\x{03FF}]/mu";

		$course->title = $request->title;
		$course->description = $request->description;
		$course->active = $request->active;
		$course->slug = preg_replace($pattern, "-", mb_strtolower($request->title) );

		if ( !empty($_FILES['cover']['name']) ) {
			
			$ext = $_FILES['cover']['type'] == "image/png" ? ".png" : ".jpeg";
			$fileName = md5( $request->title ).$ext;
			
			Storage::delete( "public/courses/$course->id/cover/$course->cover" );
			$request->cover->storeAs("public/courses/$course->id/cover", $fileName);
			
			$course->cover = $fileName;
		}

		$course->save();

        return redirect( "/dashboard/course/$course->id" );
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
	
	public function userCourse( Course $course ) {

		$materials = $course->materials;
		$materialId = [];

		foreach ($materials as $material) {
			array_push( $materialId, $material['id'] );
		}

		$authors = Course::courseAuthors( $materialId );
		$materials = $course->materials()->where('course_material.active', 1)->orderBy('priority')->get();

		$data = [
			'course' => $course,
			'authors' => $authors,
			'materials' => $materials
		];

		return view('courses/courseProfile')->with( $data );
	}
}

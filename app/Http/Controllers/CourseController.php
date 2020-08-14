<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Requests\CourseStoreRequest;
use Illuminate\Support\Facades\Storage;

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


    public function store(CourseStoreRequest $request)
    {
		$pattern = "/[^a-z0-9\x{0370}-\x{03FF}]/mu";

		$course = new Course;
		$course->name = $request->name;
		$course->description = $request->description;
		$course->active = $request->active;
		$course->slug = preg_replace($pattern, "-", mb_strtolower($request->name) );
		$course->save();
		
		if ( $request->cover ) {
			$ext = $_FILES['cover']['type'] == "image/png" ? "png" : "jpeg";
			$request->cover->storeAs("public/courses/$course->id/cover", "cover.$ext");
		}
		else {
			Storage::copy("public/no_image_600x400.png", "public/courses/$course->id/cover/cover.png");
		}
		
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

		$authors = Course::courseAuthors( $lessonIds );

		$data = [
			'course' => $course,
			'materials' => $materials,
			'allRemainingMaterials' => json_decode($allRemainingMaterials, true),
			'authors' => json_decode($authors, true),
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

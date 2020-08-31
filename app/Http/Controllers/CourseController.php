<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Requests\BundleCourseRequest;
use App\Role;
use App\Topic;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DateTime;

class CourseController extends Controller
{

    public function index()
    {
		$topics = Topic::all();

        return view('admin/courses/coursesMain')->withTopics( $topics );
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
		$course->subtitle = $request->subtitle;
		$course->summary = $request->summary;
		$course->description = $request->description;
		$course->status = $request->status;
		$course->slug = Str::slug($request->title, "-");
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
		$topics = Topic::all();
		// $instructors = Role::whereIn( 'id', [ 1, 2])->users();
		// $instructors = User::all();
		$lessonIds = [];

		// dd($instructors);
		foreach ($materials as $lesson) {
			array_push( $lessonIds, $lesson['id'] );
		};

		$data = [
			'course' => $course,
			'materials' => $materials,
			'topics' => $topics,
			// 'instructors' => $instructors,
			'publish' => Carbon::parse( $course->publish_at )->format("d-m-Y H:i"),
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

		if ( $request->publishDate ) {
			$dateTime = Carbon::parse( $request->publishDate )->format("Y-m-d H:i:s");
		}
		else {
			$dateTime = Carbon::now()->format("Y-m-d H:i:s");
		}

		$course->title = $request->title;
		$course->subtitle = $request->subtitle;
		$course->summary = $request->summary;
		$course->description = $request->description;
		$course->publish_at = $dateTime;
		// $course->status = $request->status;
		$course->slug = Str::slug($request->title, "-");

		/* if ( !empty($_FILES['cover']['name']) ) {
			
			$ext = $_FILES['cover']['type'] == "image/png" ? ".png" : ".jpeg";
			$fileName = md5( $request->title ).$ext;
			
			Storage::delete( "public/courses/$course->id/cover/$course->cover" );
			$request->cover->storeAs("public/courses/$course->id/cover", $fileName);
			
			$course->cover = $fileName;
		} */

		$course->save();


		$course->topics()->sync( $request->topics );


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

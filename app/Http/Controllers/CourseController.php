<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Requests\BundleCourseRequest;
use App\Media;
use App\Role;
use App\Topic;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CourseController extends Controller
{

    public function index()
    {
		$topics = Topic::all();

        return view('admin/courses/coursesMain')->withTopics( $topics );
    }


    public function create()
    {
		$topics = Topic::all();
		$instructors = Role::find( 2 )->users;

		$data = [
			'topics' => $topics,
			'instructors' => $instructors
		];
		return view('admin/courses/newCourse')->with( $data );

    }


    public function store(BundleCourseRequest $request)
    {
		// if( !empty($_FILES['cover']['name']) ) {
		// 	$ext = $_FILES['cover']['type'] == "image/png" ? ".png" : ".jpeg";
		// 	$fileName = md5( $request->name ).$ext;
		// }
		$request->validate([
			'title' => 'required|unique:courses',
			'version' => 'required'
		]);

		if ( isset($request->publishDate) ) {
			$publishDate = Carbon::parse( $request->publishDate )->format("Y-m-d H:i:s");
		}
		else {
			$publishDate = null;
		}

		$course = new Course;
		$course->title = $request->title;
		$course->subtitle = $request->subtitle;
		$course->summary = $request->summary;
		$course->description = $request->description;
		$course->status = 1 /* $request->status */;
		$course->slug = Str::slug($request->title, "-");
		$course->publish_at = $publishDate;
		$course->user_id = $request->curator;
		$course->version = $request->version;
		// $course->publish_at = $request->publishDate;
		// $course->cover = isset($fileName) ? $fileName : "no_image_600x400.png";
		$course->cover = "https://placehold.co/600x400";
		
		$course->save();

		if ( $request->topics ) {
			foreach ( $request->topics as $id ) {
				$course->topics()->attach( $id );
			}
		}
		
		// if ( isset($fileName) ) {
		// 	$request->cover->storeAs("public/courses/$course->id/cover", $fileName);
		// }
		// else {
		// 	Storage::copy("public/no_image_600x400.png", "public/courses/$course->id/cover/no_image_600x400.png");
		// }
		
		return redirect( "/dashboard/course/$course->slug" );

    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course = null, Request $request)
    {
		
		$topics = Topic::all();
		$instructors = Role::find( 2 )->users;
		$media = Media::where("type", 0)->orderBy("id", "desc")->paginate(18);
		
		if ( is_null($course) ) {
			$publish = "";
		}
		else {
			$publish = is_null($course->publish_at) ? null : Carbon::parse( $course->publish_at )->format("d-m-Y H:i");

		}

		$data = [
			'course' => $course,
			'media' => $media,
			'topics' => $topics,
			'instructors' => $instructors,
			'publish' => $publish,
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
			$dateTime = null;
		}

		$course->title = $request->title;
		$course->subtitle = $request->subtitle;
		$course->summary = $request->summary;
		$course->description = $request->description;
		$course->publish_at = $dateTime;
		$course->user_id = $request->curator;
		// $course->status = $request->status;
		$course->slug = Str::slug($request->title, "-");
		$course->version = $request->version;

		/* if ( !empty($_FILES['cover']['name']) ) {
			
			$ext = $_FILES['cover']['type'] == "image/png" ? ".png" : ".jpeg";
			$fileName = md5( $request->title ).$ext;
			
			Storage::delete( "public/courses/$course->id/cover/$course->cover" );
			$request->cover->storeAs("public/courses/$course->id/cover", $fileName);
			
			$course->cover = $fileName;
		} */

		$course->save();


		$course->topics()->sync( $request->topics );


        return redirect( "/dashboard/course/$course->slug" );
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

	public function softDelete(Course $course)
    {
		$course->delete();

        return redirect("/dashboard/courses");
	}
	
	public function userCourse( Course $course ) {

		$materials = $course->materials;
		$materialId = [];

		foreach ($materials as $material) {
			array_push( $materialId, $material['id'] );
		}

		$authors = Course::courseAuthors( $materialId );
		$materials = $course->materials()->where('course_material.status', 1)->orderBy('priority')->get();

		$data = [
			'course' => $course,
			'authors' => $authors,
			'materials' => $materials
		];

		return view('courses/courseProfile')->with( $data );
	}

	public function clone(Request $request) {

		// dd($request->all());
		$request->validate([
			'title' => 'required|unique:courses'
		]);

		$course = Course::find( $request->id );
		$course->load( "materials", "topics" );
		$newCourse = $course->replicate();
		$newCourse->title = $request->title;
		$newCourse->slug = Str::slug($request->title, "-");

		$newCourse->push();

		$relations = $course->getRelations();

		foreach ( $relations as $key => $relation ) {
			if ( $key === "materials" ) {

				foreach ( $relation as $material ) {
	
					// $status = $material->pivot->status;
					$priority = $material->pivot->priority;
					$publish_at = $material->pivot->publish_at;
	
					$newCourse->materials()->attach($material->id, [
						'status' => 0,
						'priority' => $priority,
						'publish_at' => $publish_at
					]);
				}
			}
			else {
				foreach ($relation as $topic ) {

					$newCourse->topics()->attach( $topic->id );
				}
			}
		}

		return redirect("/dashboard/course/$newCourse->slug");
	}
}

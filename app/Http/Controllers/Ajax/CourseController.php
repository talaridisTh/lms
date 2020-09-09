<?php

namespace App\Http\Controllers\Ajax;

use App\Course;
use App\CourseMaterial;
use App\DataTables\AddCourseUsersDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\DataTables\CoursesDataTable;
use App\DataTables\CourseMaterialsDataTable;
use App\DataTables\CourseUsersDataTable;
use App\DataTables\RemainingMaterialsDataTable;
use App\Material;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CoursesDataTable $dataTable)
    {
        return $dataTable->render('courses.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($ids)
    {
        $idList = explode(',', $ids);

		foreach( $idList as $id ) {
			
			Course::find( $id )->delete();
			// Storage::deleteDirectory("public/courses/$id");
		}
	}
	
	public function toggleStatus(Request $request) {

		$data = $request->all();

		$course = Course::find($data['course']);
		$course->status = $data['state'] == 1 ? 1 : 0;
		$course->updated_at = Carbon::now();
		$course->save();
	}

	public function changePriority( Request $request ) {

		$data = $request->all();

		$course = Course::find($data['courseId']);
		$lastMaterial = Course::find($data['courseId'])
			->materials()->orderBy("priority", "desc")->first();

		$lastInOrder = $lastMaterial->pivot->priority;

		if ( $data['priority']['new'] == 0 ) {
			$data['priority']['new'] = 1;
		}
		elseif ( $data['priority']['new'] > $lastInOrder ) {
			$data['priority']['new'] = $lastInOrder;
		}

		$priorityRange = [ $data['priority']['new'], $data['priority']['old'] ];
		sort( $priorityRange );

			if ( $data['priority']['new'] < $data['priority']['old'] ) {
				DB::table('course_material')
					->where('course_id', $data['courseId'])
					->whereBetween('priority', $priorityRange)
					->increment('priority');
			}
			else {
				DB::table('course_material')
					->where('course_id', $data['courseId'])
					->whereBetween('priority', $priorityRange)
					->decrement('priority');
			}

		CourseMaterial::where( 'course_id', $data['courseId'] )
			->where( 'material_id', $data['materialId'] )
			->update( ['priority' => $data['priority']['new']] );

		$course->updated_at = Carbon::now();
		$course->save();

	}

	public function courseMaterials(CourseMaterialsDataTable $dataTable) {
		return $dataTable->render('course.materials');
	}

	public function remainingMaterials(RemainingMaterialsDataTable $dataTable) {
		return $dataTable->render('course.remaingMaterials');
	}

	public function toggleCourseMaterials( Request $request ) {

		$course = Course::find( $request->courseId );
		$data = $request->data;

		foreach ($data as $material) {
			$course->materials()
				->updateExistingPivot( $material['id'], [ 'status' => $material['status']]);
		}

	}

	public function addMaterials( Request $request ) {

		$course = Course::find( $request->courseId );
		$materialIds = $request->materialId;

		$publish = Carbon::now()->format("Y-m-d H:i:s");
		
		if ( $course->materials()->count() > 0 ) {
			$lastMaterialId = $course->materials()->orderBy('priority', 'desc')->first()->pivot->priority;
		}
		else {
			$lastMaterialId = 0;
		}

		foreach ( $materialIds as $key => $id ) {
			$course->materials()->attach( $id, ['status' => 0, 'priority' => $lastMaterialId + $key + 1 , 'publish_at' => $publish ]);
		}

		$course->updated_at = Carbon::now();
		$course->save();

	}

	public function removeMaterials( Request $request ) {

		$courseId = $request->courseId;
		$materialIds = $request->materialIds;
		$course = Course::find($courseId);

		foreach( $materialIds as $id ) {
			$course->materials()->detach( $id );
		}

		$totalMaterials = $course->materials()->orderBy('priority')->get();

		foreach ( $totalMaterials as $key => $material ) {
			DB::table('course_material')
				->where('course_id', $courseId)
				->where('material_id', $material['id'])
				->update( ['priority' => $key + 1] );
		}

		$course->updated_at = Carbon::now();
		$course->save();
	}

	public function courseStudents( CourseUsersDataTable $dataTable ) {

		return $dataTable->render('courses.users');
		
	}

	public function addCourseStudents(AddCourseUsersDataTable $dataTable) {

		return $dataTable->render('courses.add.users');

	}

	public function addStudents( Request $request ) {

		$course = Course::find( $request->courseId );
		$userIds = $request->userIds;

		foreach ( $userIds as $id ) {
			$course->users()->attach( $id );
		}

	}

	public function removeStudents( Request $request ) {
		
		$course = Course::find( $request->courseId );
		$userIds = $request->userIds;

		foreach ( $userIds as $id ) {
			$course->users()->detach( $id );
		}
		
	}

	public function editorImages ( Request $request ) {

		$allowedTypes = ["image/png", "image/jpeg"];
		$date = date('m.Y');
		$course = Course::find( $request->id );
		$files = [];

		
		foreach ( $request->file as $key => $image ) {
			if ( $image->isValid() ) {
				if ( in_array($image->getClientMimeType(), $allowedTypes) ) {
					if ( $image->getSize() <= 512000 ) {
						
						$name = $image->getClientOriginalName();
						
						$image->storeAs("public/images/$date", $name);

						
						// dd($path->getUrl());
						
						// $path = public_path("storage/images/$date/$name");
						
						$files["file-". $key] =[
							"url" => url("storage/images/$date/$name"),
							"id" => $key
						];


						// $path = $course->addMedia( $image )
						// ->withResponsiveImages()
						// ->toMediaCollection();

						// "url" => $path->getFullUrl(),
						// http://localhost/storage/15/Untitled.png
						// "url" => $path->getUrl(),
						// http://localhost/storage/16/Untitled.png
						// "url" => $path->getPath(),
						// D:\Coding\DarkProjects\Demo LMS\storage\app/public\17/Untitled.png
						
						// return pathinfo($path, PATHINFO_DIRNAME );

						// dd($path->getFullUrl());


						// $files["file-". $key] =[
						// 	"url" => $path->getPath(),
						// 	"id" => $key
						// ];
						
					}
				}
			}
		}

		echo json_encode($files);

	}
}

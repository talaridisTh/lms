<?php

namespace App\Http\Controllers\Ajax;

use App\Course;
use App\Material;
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
use App\Media;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

		// $date = date("Y-m-d");
		// $time = date("H:i");
		// $dateTime = date("Y-m-d H:i:s");
		// dd($dateTime);

		$course = Course::find($request->courseId);

		if ( !$course->publish_at && $request->status == 1 ) {
			$course->publish_at = date("Y-m-d H:i:s");
		}

		$course->status = $request->status == 1 ? 1 : 0;
		// $course->publish_at = $request->status == 1 ? date("Y-m-d H:i:s") : null;
		$course->timestamps  = false;
		$course->save();

		if ( $course->publish_at ) {
			$date = Carbon::parse($course->publish_at)->format("d-m-Y");
			$time = Carbon::parse($course->publish_at)->format("H:i");
		}
		else {
			$date = "";
			$time = "";
		}

		$data = [
			"date" => $date,
			"time" => $time
		];

		echo json_encode($data);
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
		$course = Course::find($courseId);
	
		$course->materials()->orderBy('priority')
			->each( function($material) use ($course, $request) {

				static $counter = 1;
				if ( in_array($material->id, $request->materials) ) {
					if ($material->type == "Section") {
						$material->delete();
					}
					else {
						$course->materials()->detach( $material->id );
					}
				}
				else {
					$material->pivot->update(["priority" => $counter++]);

					//! otan einai etoima ta section na bgei apo comment
					if ($material->type == "Section") {
						$course->sections()->where("parent_id", $material->id)
							->update(["priority" => $counter]);
					}
				}
			
			});

		$sections = $course->sections()->orderBy("priority")->get();
		return View('components/admin/courses/sectionBuilder', ['sections' => $sections]);

	}

	public function courseUsers( CourseUsersDataTable $dataTable ) {

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

}

<?php

namespace App\Http\Controllers\Ajax;

use App\Course;
use App\DataTables\AddCourseUsersDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\DataTables\CoursesDataTable;
use App\DataTables\CourseMaterialsDataTable;
use App\DataTables\CourseUsersDataTable;
use App\DataTables\RemainingMaterialsDataTable;


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

		$course = Course::find($request->courseId);

		if ( !$course->publish_at && $request->status == 1 ) {
			$course->publish_at = date("Y-m-d H:i:s");
		}

		$course->status = $request->status == 1 ? 1 : 0;
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

		$course = Course::find( $request->courseId );

		$lastInOrder = $course->materials()
			->orderBy("priority", "desc")->first()->pivot->priority;

		$priority = $request->priority;

		if ( $priority['new'] == 0 ) {
			$priority['new'] = 1;
		}
		elseif ( $priority['new'] > $lastInOrder ) {
			$priority['new'] = $lastInOrder;
		}

		$priorityRange = [ $priority['new'], $priority['old'] ];
		sort( $priorityRange );

		$counter = $priority['new'] < $priority['old'] ? $priority['new'] + 1 : $priority['old'] - 1 ;

		$materials = $course->materials()->whereBetween('priority', $priorityRange)
			->orderBy("priority")->get();

		foreach ($materials as $material) {

			$material->pivot->update(["priority" => $counter++]);

		}

		$material = $course->materials()->where("materials.id", $request->materialId)->first();
		$material->pivot->update([ "priority" => $priority['new'] ]);

		$course->updated_at = Carbon::now();
		$course->save();

		$sections = $course->materials()->where("type", "Section")->orderBy("priority")->get();
		return View('components/admin/courses/sectionBuilder', ['sections' => $sections]);

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

					$course->materials()->detach( $material->id );

				}
				else {
					$material->pivot->update(["priority" => $counter]);

					$counter++;
				}
			
			});

		$sections = $course->materials()->where("type", "Section")->orderBy("priority")->get();
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

	public function toggleEditors(Course $course, Request $request) {

		$course->fields = $request->fields;
		$course->save();
		
	}

}

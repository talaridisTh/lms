<?php

namespace App\Http\Controllers\Ajax;

use App\Course;
use App\CourseMaterial;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\DataTables\CoursesDataTable;
use App\DataTables\CourseMaterialsDataTable;
use App\DataTables\RemainingMaterialsDataTable;
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
			Storage::deleteDirectory("public/courses/$id");
		}
	}
	
	public function toggleActive(Request $request) {

		$data = $request->all();

		$course = Course::find($data['course']);
		$course->active = $data['state'] == 1 ? 1 : 0;
		$course->updated_at = Carbon::now();
		$course->save();
	}

	public function changePriority( Request $request ) {

		$data = $request->all();

		$course = Course::find($data['courseId']);

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

		$data = $request->all();
		$course = Course::find( $data['courseId'] );

		$material = $course->materials()
			->where('material_id', $data['materialId']);

		$material->active = $data['state'] == 1 ? 1 : 0;
		$material->update( ['course_material.active'=> $data['state'] == 1 ? 1 : 0 ] );

		$course->updated_at = Carbon::now();
		$course->save();
	}

	public function addMaterials( Request $request ) {

		$course = Course::find( $request->courseId );
		$materialIds = $request->materialId;
		
		if ( $course->materials()->count() > 0 ) {
			$lastMaterialId = $course->materials()->orderBy('priority', 'desc')->first()->pivot->priority;
		}
		else {
			$lastMaterialId = 0;
		}

		foreach ( $materialIds as $key => $id ) {
			$course->materials()->attach( $id, ['active' => 0, 'priority' => $lastMaterialId + $key + 1 ] );
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
}

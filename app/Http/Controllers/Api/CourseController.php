<?php

namespace App\Http\Controllers\Api;

use App\Course;
use App\CourseMaterial;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\DataTables\CoursesDataTable;

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
    public function destroy($id)
    {
        //
	}
	
	public function massDestroy($ids)
    {
		$idList = explode(',', $ids);

		foreach( $idList as $id ) {
			
			Course::find( $id )->delete();
			
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

	}

	public function courseMaterials() {
		
	}

	public function remainingMaterials() {

	}
}

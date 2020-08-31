<?php

namespace App\Http\Controllers\Ajax;

use App\Bundle;
use App\DataTables\BundleCoursesDataTable;
use App\DataTables\BundleDataTable;
use App\DataTables\RemainingCoursesDataTable;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BundleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( BundleDataTable $dataTable )
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
     * @param  \App\Bundle  $bundle
     * @return \Illuminate\Http\Response
     */
    public function show(BundleCoursesDataTable $dataTable)
    {
        return $dataTable->render('bundle.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bundle  $bundle
     * @return \Illuminate\Http\Response
     */
    public function edit(Bundle $bundle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bundle  $bundle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bundle $bundle)
    {

		$bundle->status = $request->state;
		$bundle->save();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bundle  $bundle
     * @return \Illuminate\Http\Response
     */
    public function destroy($ids)
    {
        $idList = explode(',', $ids);

		foreach( $idList as $id ) {
			
			Bundle::find( $id )->delete();
			Storage::deleteDirectory("public/bundles/$id");
		}
	}
	
	public function remainingCourses(RemainingCoursesDataTable $dataTable) {
		return $dataTable->render('bundle.remainingCoursesDataTable');
	}

	public function addCourses(Request $request) {

		$bundle = Bundle::find( $request->bundleId );
		$courseIds = $request->courseIds;

		foreach ( $courseIds as $id ) {
			$bundle->courses()->attach( $id );
		}

		$bundle->updated_at = Carbon::now();
		$bundle->save();

	}

	public function removeCourses( Request $request ) {

		$bundle = Bundle::find( $request->bundleId );
		$courseIds = $request->courseIds;

		foreach ( $courseIds as $id ) {
			$bundle->courses()->detach( $id );
		}

		$bundle->updated_at = Carbon::now();
		$bundle->save();

	}
}

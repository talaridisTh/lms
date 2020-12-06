<?php

namespace App\Http\Controllers\Ajax;

use App\Models\Bundle;
use App\DataTables\Bundles\UsersDataTable;
use App\DataTables\Bundles\BundleCoursesDataTable;
use App\DataTables\Bundles\BundleDataTable;
use App\DataTables\Bundles\BundleUsersDatatable;
use App\DataTables\Bundles\CoursesDataTable;
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

	public function bundleSearch(Request $request) {
		$bundles = Bundle::where("title", "LIKE", "%$request->search%")
			->select("id", "title")->paginate(10);

		$result = [];
		$result["results"] = [];

		foreach($bundles as $key => $bundle) {
			if ($bundles->currentPage() === 1 && $key === 0) {

				array_push($result['results'], [
					"id" => " ",
					"text" => "Όλα τα Bundles"
				]);
			}
			array_push($result['results'], [
				"id" => $bundle->title,
				"text" => $bundle->title
			]);
		}

		$result["pagination"] = [
			"more" => $bundles->currentPage() !== $bundles->lastPage()
		];

		echo json_encode($result);
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
	
	public function remainingCourses(CoursesDataTable $dataTable) {
		return $dataTable->render('bundle.CoursesDataTable');
	}

	public function addCourses(Request $request, Bundle $bundle) {

		$courseIds = $request->courseIds;

		foreach ( $courseIds as $id ) {
			$bundle->courses()->attach( $id );
		}

		$bundle->updated_at = Carbon::now();
		$bundle->save();

	}

	public function removeCourses(Request $request, Bundle $bundle) {

		$courseIds = $request->courseIds;

		foreach ( $courseIds as $id ) {
			$bundle->courses()->detach( $id );
		}

		$bundle->updated_at = Carbon::now();
		$bundle->save();

	}

	public function bundleUsers( BundleUsersDatatable $dataTable )
    {
        return $dataTable->render('bundle.users');
	}

	public function remainingUsers (UsersDataTable $dataTable ) {
		
		return $dataTable->render('bundle.remaining.users');

	}
	
	public function removeUsers(Request $request,  Bundle $bundle) {

		foreach( $request->users as $id ) {
			$bundle->users()->detach( $id );
		}

	}

	public function addUsers(Request $request, Bundle $bundle) {

		$bundle->users()->sync( $request->users, false );

	}

	public function toggleStatus(Request $request, Bundle $bundle){

		if ( !$bundle->publish_at && $request->status == 1 ) {
			$bundle->publish_at = date("Y-m-d H:i:s");
		}

		$bundle->status = $request->status == 1 ? 1 : 0;
		$bundle->timestamps  = false;
		$bundle->save();

		if ( $bundle->publish_at ) {
			$date = Carbon::parse($bundle->publish_at)->format("d-m-Y");
			$time = Carbon::parse($bundle->publish_at)->format("H:i");
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

	public function toggleEditors(Bundle $bundle, Request $request) {

		$bundle->fields = $request->fields;
		$bundle->save();
		
	}

}

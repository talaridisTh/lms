<?php

namespace App\Http\Controllers\Ajax;

use App\Models\Course;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\DataTables\Courses\CoursesDataTable;
use App\DataTables\Courses\CourseMaterialsDataTable;
use App\DataTables\Courses\CourseUsersDataTable;
use App\DataTables\Courses\MaterialsDataTable;
use App\DataTables\Courses\UsersDataTable;
use App\Traits\MediaUploader;

class CourseController extends Controller
{
	use MediaUploader;
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CoursesDataTable $dataTable)
    {
        return $dataTable->render('courses.index');
    }

	public function courseSearch(Request $request) {
		$courses = Course::where("title", "LIKE", "%$request->search%")
			->select("id", "title")->paginate(10);

		$result = [];
		$result["results"] = [];

		foreach($courses as $key => $course) {
			if ($courses->currentPage() === 1 && $key === 0) {

				array_push($result['results'], [
					"id" => " ",
					"text" => "Όλα τα Courses"
				]);
			}
			array_push($result['results'], [
				"id" => $course->title,
				"text" => $course->title
			]);
		}

		$result["pagination"] = [
			"more" => $courses->currentPage() !== $courses->lastPage()
		];

		echo json_encode($result);
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

	public function remainingMaterials(MaterialsDataTable $dataTable) {
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

	public function addCourseStudents(UsersDataTable $dataTable) {

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

	public function toggleHighlight(Course $course, Request $request) {
		// $data = $request->materialIds;

		// dd($data);
		foreach ($request->materialIds as $id) {
			$course->materials()
				->updateExistingPivot( $id, [ 'highlight' => $request->status]);
		}
	}

	public function galleryUpload(Request $request, Course $course ) {
		
		$priority = $course->media()->count();

		foreach($request->file as $key => $image) {

			$media = $this->storeImage($image);

			$course->media()
				->attach($media->id, ["usage" => 1, "priority" => $key + 1 + $priority]);
		}

		$gallery = $course->media()->where("type", 0)->orderBy("priority")->get();
		return View('components/admin/modelGallery', ['gallery' => $gallery]);

	}

	public function gallerySort(Request $request, Course $course) {

		foreach ($request->imagesPriority as $key => $id) {
			$course->media()->updateExistingPivot($id, ['priority' => ($key + 1) ]);
		}
	}

}

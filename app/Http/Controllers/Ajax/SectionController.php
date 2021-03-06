<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\Course;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class SectionController extends Controller
{
	public function toggleHighlight(Request $request, Course $course, Material $material) {

		$this->authorize("update", $course);

		foreach ($request->materialIds as $id ) {
			$material->chapters()
				->updateExistingPivot($id, ["highlight" => $request->status]);
		}
	}

	public function toggleChapter(Request $request, Course $course, Material $material) {

		$this->authorize("update", $course);

		$chapter = $material->chapters()
			->wherePivot("material_id", $request->materialId)->first();

		$publish = $chapter->pivot->publish_at;
		$now = Carbon::now();

		if ($request->status === 1) {
			$chapter->pivot->update([
				"status" => 1,
				"publish_at" => is_null($publish) ? $now : $publish
			]);
		}
		else {
			$chapter->pivot->update([
				"status" => 0
			]);
		}

		//! kribo ta deuterolepta
		echo Carbon::parse($chapter->pivot->publish_at)->format("Y-m-d H:i");
	}

	public function toggleMultipleChapters(Request $request, Course $course, Material $material ) {

		$this->authorize("update", $course);

		$now = Carbon::now();
		$data = [
			"materials" => [],
			"status" => $request->status
		];

		foreach ($request->ids as $id ) {
			$chapter = $material->chapters()
				->wherePivot("material_id", $id)->first();

			$publish = $chapter->pivot->publish_at;

			if ( $request->status ) {
				$chapter->pivot->update([
					"status" => 1,
					"publish_at" => is_null($publish) ? $now : $publish
				]);
			}
			else {
				$chapter->pivot->update([
					"status" => 0
				]);
			}

			array_push($data["materials"], [
				"id" => $chapter->id,
				"publish" => $chapter->pivot->publish_at
			]);
		}

		echo json_encode($data);
	}

    public function removeChapters(Request $request, Course $course) {

		$this->authorize("update", $course);

		$material = Material::find($request->sectionId);

		$material->chapters()->orderBy("priority")
			->each( function($chapter) use ($material, $request) {

				static $counter = 1;
				if ( in_array($chapter->id, $request->chapterIds) ) {

					$material->chapters()->detach( $chapter->id );

				}
				else {
					$chapter->pivot->update(["priority" => $counter]);

					$counter++;
				}
			});

		$sections = $course->materials()->where("type", "Section")->orderBy("priority")->get();
		return View('components/admin/courses/sectionBuilder', ['sections' => $sections]);
	}

	public function chaptersPriority(Request $request, Course $course, Material $material) {

		$this->authorize("update", $course);

		$lastInOrder = $material->chapters()
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

		$chapters = $material->chapters()->whereBetween('priority', $priorityRange)
			->orderBy("priority")->get();

		foreach ($chapters as $chapter) {

			$chapter->pivot->update(["priority" => $counter++]);

		}

		$chapter = $material->chapters()->where("materials.id", $request->materialId)->first();
		$chapter->pivot->update([ "priority" => $priority['new'] ]);

		$material->updated_at = Carbon::now();
		$material->save();

		$sections = $course->materials()->where("type", "Section")->orderBy("priority")->get();
		return View('components/admin/courses/sectionBuilder', ['sections' => $sections]);
	}

	public function addNewChapter(Request $request, Course  $course) {

		$this->authorize("update", $course);

		$request->validate([
			'title' => 'required'
		]);

		$section = Material::find( $request->sectionId );

		$material = new Material;
		$material->title = $request->title;
		$material->subtitle = $request->subtitle;
		$material->description = $request->description;
		$material->type = $request->type;
		$material->status = $request->status;
		$material->slug = Str::slug($request->title, "-");
		$material->video_link = $request->video;
		$material->link = $request->link;
		$material->save();

		$section->chapters()->wherePivot("priority", ">", $request->priority)
			->increment("priority");

		$section->chapters()
			->attach( $material->id, [
				"status" => $request->status,
				"priority" => $request->priority + 1,
				"publish_at" => date( "Y-m-d H:i:s", (time() - 10) )
			]);

		$sections = $course->materials()
			->where("type", "Section")->orderBy("priority")->get();

		return View('components/admin/courses/sectionBuilder', ['sections' => $sections]);
	}

	public function publishchapter(Request $request, Course $course, Material $material) {

		$this->authorize("update", $course);

		$material->chapters()->updateExistingPivot($request->materialId, [
			"publish_at" => $request->date
		]);

	}
}

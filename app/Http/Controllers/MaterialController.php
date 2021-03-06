<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Role;
use App\Models\Material;
use App\Models\Media;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\CreateMaterialRequest;
use App\Http\Requests\UpdateMaterialRequest;

class MaterialController extends Controller {

    public function index()
    {
        $materials = Material::all();
        $activeCourses = User::courseWhereActive();

        return view('admin.materials.materialsMain', compact("materials", "activeCourses"));
    }

    public function create(Course $course = null, $priority = null, Material $material = null)
    {
		$data = [
			"instructors" => User::role(["admin", "instructor"])->where("status", 1)->orderBy("last_name")->get(),
			"media" => Media::where("type", 0)->orderBy("id", "desc")->paginate(18),
			"course" => $course,
			"section" => $material,
			"priority" => $priority,
		];

        return view('admin/materials/newMaterial')->with($data);
	}

    public function store(CreateMaterialRequest $request)
    {
		$fields = [
			"summary" => isset($request->summaryField) ? 1 : 0,
			"description" => isset($request->descriptionField) ? 1 : 0,
			"content" => isset($request->contentField) ? 1 : 0,
			"script" => isset($request->scriptEditor) ? 1 : 0,
		];

		$material = new Material();
		$material->title = $request->title;
		$material->subtitle = $request->subtitle;
		$material->summary = $request->summary;
		$material->description = $request->description;
		$material->content = $request->content;
		$material->script = $request->script;
		$material->video_link = $request->video_link;
		$material->link = $request->link;
		$material->type = $request->type;
		$material->slug = $material->createSlug($request->title);
		$material->status = isset($request->status) ? 1 : 0;
		$material->fields = json_encode($fields);

		$material->save();

		if ( isset($request->instructors) ) {
			$material->users()->sync($request->instructors);
		}

		if ( isset($request->courseId) ) {

			$course = $this->storeExtraContent($request, $material);

			return redirect("/dashboard/courses/$course->slug/edit");
		}

        return redirect( "/dashboard/materials/$material->slug/edit" );

	}

	public function createPDF(Course $course = null, $priority = 1, Material $material = null) {

		$data = [
			"course" => $course,
			"priority" => $priority,
			"section" => $material,
			"instructors" => User::role(["admin", "instructor"])
				->where("status", 1)->orderBy("last_name")->get()
		];

        return view('admin.materials.newPDFMaterial')->with($data);
	}

	public function storePDF(Request $request) {

		$request->validate([
			'title' => 'required',
			'pdfId' => 'required|integer|not_in:0',
		]);

		$fields = [
			"summary" => isset($request->summaryEditor) ? 1 : 0,
			"description" => isset($request->descriptionEditor) ? 1 : 0,
			"content" => isset($request->contentEditor) ? 1 : 0
		];

		$material = new Material;
		$material->title = $request->title;
		$material->subtitle = $request->subtitle;
		$material->description = $request->description;
		$material->type = "PDF";
		$material->slug = $material->createSlug($request->title);
		$material->status = isset($request->status) ? 1 : 0;
		$material->fields = json_encode($fields);
		$material->save();

		$material->media()->attach($request->pdfId, ["usage" => 4]);

		if ( isset($request->instructors) ) {
			$material->users()->sync($request->instructors);
		}

		if ( isset($request->courseId) ) {

			$course = $this->storeExtraContent($request, $material);

			return redirect("/dashboard/courses/$course->slug/edit");
		}

		return redirect("/dashboard/pdf/$material->slug/edit");
	}

    public function edit(Material $material)
    {
		$types = [
			"Lesson" => "Μάθημα",
			"Announcement" => "Ανακοίνωση",
			"Video" => "Video",
			"Link" => "Link"
		];

		$data = [
			"topics" => Topic::all(),
			"instructors" => User::role(["admin", "instructor"])->orderBy("last_name")->get(),
			"activeInstructors" => $material->users()->pluck("users.id")->toArray(),
			"material" => $material,
			"types" => $types,
			"media" => Media::where("type", 0)->orderBy("id", "desc")->paginate(18),
			"gallery" => $material->media()->wherePivot("usage", "!=", 3)->orderBy("priority")->get(),
			"files" => $material->media()->where("type", 1)->get(),
			"fields" => json_decode($material->fields)
		];

        return view('admin.materials.material')->with($data);
    }

    public function update(UpdateMaterialRequest $request, Material $material)
    {
        $material->update($request->except("instructors", "status", "slug"));

		$material->slug = $material->createSlug($request->title, $material->id);
        $material->status = isset($request->status) ? 1 : 0;
        $material->save();

		$material->users()->sync($request->instructors);
		
		if ( $request->type === "PDF" ) {
			return redirect( "/dashboard/pdf/$material->slug/edit" );
		}

		return redirect( "/dashboard/materials/$material->slug/edit" );
    }

    public function destroy(Request $request,Material $material)
    {

        $material->delete();

        return redirect(route('material.index'));

	}

	public function editPDF(Material $material) {

		$pdf = $material->media()->wherePivot("usage", 4)
			->with("mediaDetails")->first();

		$data = [
			"material" => $material,
			"instructors" => User::role(["admin", "instructor"])->where("status", 1)->orderBy("last_name")->get(),
			"activeInstructors" => $material ? $material->users()->pluck("users.id")->toArray() : null,
			"fields" => json_decode($material->fields),
			"pdf" => $pdf
		];

		return view("admin/materials/pdfMaterial")->with($data);

	}

	private function storeExtraContent(Request $request, Material $material) {

		$course = Course::find( $request->courseId );

			if ( isset($request->sectionId) ) {
				$section = Material::find( $request->sectionId );
				$section->chapters()->wherePivot("priority", ">", $request->priority)
					->increment("priority");

				$section->chapters()->attach($material->id, [
					"priority" => $request->priority + 1,
					"status" => isset($request->status) ? 1 : 0
				]);
			}
			else {
				$course->materials()->wherePivot("priority", ">", $request->priority)
					->increment("priority");

				$course->materials()->attach( $material->id, [
					"priority" => ($request->priority + 1),
					"status" => isset($request->status) ? 1 : 0
				]);
			}

		return $course;
	}

}

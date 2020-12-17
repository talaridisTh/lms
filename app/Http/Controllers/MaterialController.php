<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Role;
use App\Models\Material;
use App\Models\Media;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;

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
			"instructors" => Role::find(2)->users,
			"media" => Media::where("type", 0)->orderBy("id", "desc")->paginate(18),
			"course" => $course,
			"section" => $material,
			"priority" => $priority,
		];

        return view('admin/materials/newMaterial')->with($data);
	}

    public function store(Request $request)
    {
		$request->validate([
			'title' => 'required',
		]);

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
		$material->type = $request->type;
		$material->slug = Str::slug($request->title, '-');
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
			"instructors" => Role::find(2)->users
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
		$material->slug = Str::slug($request->title, '-');
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

		$data = [
			"material" => $material,
			"instructors" => Role::find(2)->users,
			"activeInstructors" => $material ? $material->users()->pluck("users.id")->toArray() : null,
			"pdf" => $material->media()->wherePivot("usage", 4)->with("mediaDetails")->first()
		];

		return view("admin/materials/pdfMaterial")->with($data);
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
			"instructors" => Role::find(2)->users,
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

    public function update(Request $request, Material $material)
    {

		//TODO to validation apo to content pernaei panta epidi
		//TODO einai panta gemato endexomenos logo tou editor
		$request->validate([
			'title' => 'required',
			'video_link' => 'required_if:type,Video',
			'link' => 'required_if:type,Link',
			'content' => 'required_if:type,Announcement',
		],
		[
			"video_link.required_if" => "Το πεδίο είναι υποχρεωτικό όταν ο Tύπος είναι Video.",
			"link.required_if" => "To πεδίο είναι υποχρεωτικό όταν ο Τύπος είναι Link.",
			"content.required_if" => "To πεδίο είναι υποχρεωτικό όταν ο Τύπος είναι Ανακοίνωση."
		]);

        $material->update($request->except("instructors", "status"));

        $material->status = isset($request->status) ? 1 : 0;
        $material->save();

        $material->users()->sync($request->instructors);

        return redirect()->back()->with('update', 'Το μάθημα  ' . $material->title . ' ενημερώθηκε');
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
			"instructors" => Role::find(2)->users,
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

<?php

namespace App\Http\Controllers;

use App\Course;
use App\Role;
use App\CourseMaterial;
use App\Http\Requests\CreateMaterialRequest;
use App\Http\Requests\UpdateMaterialRequest;
use App\Material;
use App\Media;
use App\Topic;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Str;
use PHPUnit\Util\Type;

class MaterialController extends Controller {

    public function index()
    {
        $materials = Material::all();
        $activeCourses = User::courseWhereActive();
           //    soft-delete
//        $trashMaterial = Material::onlyTrashed()->get();
//        return view('admin.materials.materialsMain', compact("materials", "activeCourses","trashMaterial"));

        return view('admin.materials.materialsMain', compact("materials", "activeCourses"));
    }

    public function create()
    {
        $topics = Topic::all();
        $instructors = User::getInstructor();
        $courses = Course::all();
        $types = Material::all()->unique('type');

        return view('admin.materials.newMaterial', compact("topics", "instructors", "courses", "types"));
    }

    public function store(Request $request)
    {

		// dd($request->all());

		$material = new Material();
		$material->title = $request->title;
		$material->subtitle = $request->subtitle;
		$material->summary = $request->summary;
		$material->description = $request->description;
		$material->content = $request->content;
		$material->video_link = $request->video_link;
		$material->type = $request->type;
		$material->slug = Str::slug($request->title, '-');
		$material->status = isset($request->status) ? 1 : 0;
        if ($request->cover)
        {
            $material->cover = $request->cover;

        }
		$material->save();

        $request->instructor ? $material->users()->sync($request->instructor) : "";
		$request->topic ? $material->topics()->sync($request->topic) : "";

		if ( isset($request->courseId) ) {
			$course = Course::find( $request->courseId );
			CourseMaterial::incrementPriority( $request->courseId, ($request->priority) );

			$course->materials()->attach( $material->id, ["priority" => ($request->priority + 1)] );

			return redirect("/dashboard/course/$course->slug");
		}

        return redirect( route("material.show",$material->slug) );
//        return redirect(route("material.index"))->with('create', 'Το μάθημα ' . $material->title . ' δημιουργήθηκε');;

    }

    public function show(Material $material = null)
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
			"activeInstructors" => $material ? $material->users()->pluck("users.id")->toArray() : null,
			"material" => $material,
			"types" => $types,
			"media" => Media::where("type", 0)->orderBy("id", "desc")->paginate(18),
			"gallery" => $material ? $material->media()->wherePivot("usage", "!=", 3)->orderBy("priority")->get() : null,
			"files" => $material ? $material->media()->where("type", 1)->get() : null
		];

        return view('admin.materials.material')->with($data);
    }

    public function update(Request $request, Material $material)
    {

		$request->validate([
			'title' => 'required',
			'type' => 'required',
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

	public function courseMaterial(Course $course, $priority) {
		$media = Media::where("type", 0)->orderBy("id", "desc")->paginate(18);
        $topics = Topic::all();
        $instructors = User::getInstructor();
		$types = Material::all()->unique('type');

		$data = [
			"course" => $course,
			"priority" => $priority,
			"media" => $media,
			"topics" => $topics,
			"instructors" => $instructors,
			"types" => $types
		];
		// dd("hit");
        return view('admin.materials.material')->with($data);
	}

}

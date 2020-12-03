<?php

namespace App\Http\Controllers\Ajax;

use App\Course;
use App\DataTables\Materials\CoursesDataTable;
use App\DataTables\Materials\MaterialCoursesDataTable;
use App\DataTables\Materials\MaterialsDataTable;
use App\DataTables\Materials\PDFDataTable;
use App\Http\Controllers\Controller;
use App\Material;
use App\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class MaterialController extends Controller {


    public function index(MaterialsDataTable $dataTable)
    {

        return $dataTable->render('materials.index');
	}

	public function editChapter(Material $material, Request $request) {

		$material->title = $request->title;
		$material->slug = Str::slug($request->title, "-");
		$material->save();

		$sections = Course::find( $request->courseId )->materials()
			->where("type", "Section")->orderBy("priority")->get();
		return View('components/admin/courses/sectionBuilder', ['sections' => $sections]);
	}

    public function indexCourse(MaterialCoursesDataTable $dataTable)
    {

        return $dataTable->render('materials-course.index');
    }

    public function addCourseMaterial(CoursesDataTable $dataTable)
    {
        return $dataTable->render('add-course-material');
	}

    public function toggleStatus(Material $material, Request $request)
    {

        $material->status = $request->state;
        $material->save();
    }

    public function materialTypes()
    {

        return Material::select('type')->distinct('type')->get();
    }

    public function uploadDescImages(Request $request)
    {

        $allowedTypes = ["image/png", "image/jpeg"];
        $files = [];
        foreach ($request->file as $key => $image)
        {
            if ($image->isValid())
            {
                if (in_array($image->getClientMimeType(), $allowedTypes))
                {
                    if ($image->getSize() <= 512000)
                    {
                        $id = md5($image->getClientOriginalName());
                        $path = Storage::disk('public')->put("materials/$request->id/descriptionImages", $image);
                        $files["file-" . $key] = [
                            "url" => url("/storage/$path"),
                            "id" => $id
                        ];
                    }
                }
            }
        }
        echo json_encode($files);
    }

    public function addContent(Request $request) {

		$request->validate([
			'title' => 'required'
		]);

        $publish = Carbon::now()->format("Y-m-d H:i:s");
        $material = new Material;
        $material->title = $request->title;
        $material->subtitle = $request->subtitle;
        $material->description = $request->description;
        $material->content = $request->content;
        $material->type = $request->type;
        $material->status = $request->status;
		$material->slug = Str::slug($request->title, "-");
		$material->video_link = $request->video;
		$material->link = $request->link;
		$material->save();

		$course = Course::find($request->courseId);

		$course->materials()->wherePivot("priority", ">", $request->priority)
					->increment("priority");

		$course->materials()
			->attach($material->id, [
				"status" => $request->status,
				"priority" => $request->priority + 1,
				"publish_at" => $publish
			]);

		$sections = $course->materials()->where("type", "Section")->orderBy("priority")->get();
		return View('components/admin/courses/sectionBuilder', ['sections' => $sections]);
	}

    public function destroyMultipleMaterials(Request $request)
    {

        $data = [
            'all' => Material::all()->count() - count($request->material_id),
        ];
        Material::whereIn('id', $request->material_id)->delete();

        return response()->json(['success' => $data]);
    }

    public function addMaterialMultiple(Request $request)
    {

        $materials = Material::findOrFail($request->material_id);
        foreach ($materials as $key => $material)
        {
            if ($key < 1)
            {
                $lastpriority = $material->courses()->count() > 0 ? $material->courses()->orderBy("priority", 'desc')->first()->getOriginal("pivot_priority") : 0;
            }
            $material->courses()->detach($request->course_id);
            $material->courses()->attach($request->course_id, ["priority" => $lastpriority + $key, "publish_at" => now()]);
        }
    }

    public function changeStatusMultiple(Request $request)
    {

        foreach ($request->material_id as $material_id)
        {
            $material = Material::findOrFail($material_id);
            if ($request->status == "on")
            {
                $material->status = true;
                $material->save();
            } else
            {
                $material->status = false;
                $material->save();
            }
        }

        return response()->json(['success' => 'Status change successfully.']);
    }

    public function destroyMultipleCourse(Request $request) {

		$courses = Course::find($request->courseId);

		foreach ($courses as $course) {
			$priority = $course->materials()
				->where("materials.id", $request->materialId)
				->first()->pivot->priority;

			$course->materials()->detach( $request->materialId );

			$course->materials()->wherePivot("priority", ">", $priority)->decrement("priority");
		}

    }

    public function addCourse(Request $request) {

        $material = Material::find($request->materialId);
		$courses = Course::find($request->courseIds);

        foreach ($courses as $course) {

			$materialCount = $course->materials()->count();

            $material->courses()->attach($course, ["priority" => $materialCount + 1, "publish_at" => now()]);
        }
    }

    public function coverUpload(Request $request)
    {

        $user = Material::findorFail($request->materialId);
        $date = date('m.Y');

        $image = $request->file;


        $temp = explode(".", $image->getClientOriginalName());

        $name = implode("-", array_diff($temp, [ $image->getClientOriginalExtension() ]) );
        $nameWithExte =  Str::slug( $name, "-" );
        $name =  Str::slug( $name, "-" );
        $name .= ".". $image->getClientOriginalExtension();




        if ($image->isValid())
        {

            $media = new Media;
            $media->original_name = $image->getClientOriginalName();
            $media->name = $nameWithExte;
            $media->rel_path = "storage/$date/images/". $name;
            $media->ext = $image->getClientOriginalExtension();
            $media->file_info = $image->getClientMimeType();
            $media->size = $image->getSize();
            $media->save();
//            $user->media()->wherePivot("usage", 0)->detach();
//            $user->media()->attach( $media->id, [ "usage" => 0 ] );

            $image->storeAs("public/$date/images", $name);


        }
    }

    public function galleryUpload(Request $request)
    {

		$material = Material::find($request->id);

		if ( $material->media()->count() > 0 ) {
			$priority = $material->media()->orderBy("priority", "desc")->first()->pivot->priority;
		}
		else {
			$priority = 0;
		}

		$allowedTypes = ["image/png", "image/jpeg"];
		$date = date('Y.m');

		foreach ( $request->file as $key => $image ) {
			if ( $image->isValid() ) {
				if ( in_array($image->getClientMimeType(), $allowedTypes) ) {
					if ( $image->getSize() <= 50000000 ) { // 50MB

						$temp = explode(".", $image->getClientOriginalName());
						$arrayName = (array_diff( $temp, [$image->getClientOriginalExtension()] ));
						$originalName = implode( ".", $arrayName );
						$name =  Str::slug( implode("-", $arrayName ), "-" );

						$count = Media::where( "original_name", $originalName)->count();

						if ( $count > 0 ) {
							$name = $name.( $count + 1 );
							$fullname = $name.".".$image->getClientOriginalExtension();
						}
						else {
							$fullname = "$name.".$image->getClientOriginalExtension();
						}

						$media = new Media;
						$media->original_name = $originalName;
						$media->name = $name;
						$media->rel_path = "/storage/images/$date/$fullname";
						$media->thumbnail_path = "/storage/thumbnails/$date/$fullname";
						$media->ext = $image->getClientOriginalExtension();
						$media->file_info = $image->getClientMimeType();
						$media->size = $image->getSize();
						$media->width = Image::make( $image )->width();
						$media->height = Image::make( $image )->height();
						$media->save();

						$material->media()
							->attach($media->id, ["usage" => 1, "priority" => $key + 1 + $priority]);

						$image->storeAs("public/images/$date", $fullname);

						if ( !file_exists( storage_path("app/public/thumbnails/$date") ) ) {
							Storage::disk("local")->makeDirectory("public/thumbnails/$date");

						}

						Image::make( $image )->fit( 215, 215)
							->save( storage_path("/app/public/thumbnails/$date/$fullname") );

					}
				}
			}
		}

		$gallery = $material->media()->where("type", 0)->orderBy("priority")->get();
		return View('components/admin/modelGallery', ['gallery' => $gallery]);

    }

	public function gallerySort(Request $request) {

		$material = Material::find( $request->materialId );

		foreach ($request->imagesPriority as $key => $id) {
			$material->media()->updateExistingPivot($id, ['priority' => ($key + 1) ]);
		}

	}

	public function detachAllFiles( Request $request, Material $material) {

		$material->media()->wherePivot("usage", $request->usage)->detach();

	}

	public function addMaterials(Request $request) {

		$course = Course::find( $request->courseId );
		$material = Material::find( $request->chapterId );

		if ( $material->chapters()->count() > 0 ) {
			$lastpriority = $material->chapters()->orderBy("priority", "desc")
				->first()->pivot->priority;
		}
		else {
			$lastpriority = 0;
		}

		foreach ( $request->materialIds as $key => $id ) {
			$material->chapters()
				->attach( $id, ['status' => 0, 'priority' => $lastpriority + $key + 1 ]);
		}

		$material->updated_at = Carbon::now();
		$material->save();

		$sections = $course->materials()->where("type", "Section")->orderBy("priority")->get();
		return View('components/admin/courses/sectionBuilder', ['sections' => $sections]);
	}

	public function removeChapters(Request $request) {

		$material = Material::find($request->sectionId);

		$course = Course::find( $request->courseId );

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

	public function toggleChapters( Request $request ) {

		$material = Material::find( $request->sectionId );

		foreach ($request->data as $chapter ) {
			$material->chapters()
				->updateExistingPivot($chapter['id'], ["status" => $chapter['status']]);
		}

	}

	public function chaptersPriority(Request $request) {

		$material = Material::find( $request->sectionId );

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

		$sections = Course::find( $request->courseId )->materials()->where("type", "Section")->orderBy("priority")->get();
		return View('components/admin/courses/sectionBuilder', ['sections' => $sections]);
	}

	public function toggleEditors(Material $material, Request $request) {

		$material->fields = $request->fields;
		$material->save();

	}

	public function addSectionContent(Request $request) {

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
				"priority" => $request->priority + 1
			]);

		$sections = Course::find( $request->courseId )->materials()
			->where("type", "Section")->orderBy("priority")->get();

		return View('components/admin/courses/sectionBuilder', ['sections' => $sections]);
	}

	public function changePDF(Request $request, Material $material) {

		$material->media()->where("usage", 4)->sync([$request->pdfId => ["usage" => 4]]);

		return Response::json([
			"pdf" => Media::with("mediaDetails")->find( $request->pdfId )
		], 200);
	}

	public function remainingPDFFiles(PDFDataTable $dataTable) {

		return $dataTable->render('pdf.files');

	}

	public function toggleHighlight(Material $material, Request $request) {

		//! to $material einai to $section
		//! an i metabliti onomasti $section den leitourgei
		foreach ($request->materialIds as $id ) {
			$material->chapters()
				->updateExistingPivot($id, ["highlight" => $request->status]);
		}
	}
}

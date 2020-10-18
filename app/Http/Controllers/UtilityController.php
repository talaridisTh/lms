<?php

namespace App\Http\Controllers;

use App\Bundle;
use App\Utility;
use App\Course;
use App\Media;
use App\Material;
use Illuminate\Http\Request;

class UtilityController extends Controller
{
    public function index() {

		$page = Utility::where("title", "Home page")->first();

		$bannersData = json_decode($page->banners);

		$banners = (object)[];
		
		foreach ($bannersData as $section => $values) {
			$banners->{ $section } = (object)[];
			$banners->{ $section }->models = [];

			foreach($values->models as $model) {

				$namespace = key((array)$model);
				$id = current((array)$model);
				
				$value = $namespace::find( $id );
				array_push($banners->{ $section }->models, $value);
			}
			$banners->{ $section }->status = $values->status;
		}

		$data = [
			"page" => $page,
			"banners" => $banners,
			"statuses" => json_decode($page->fields),
			'media' => Media::where("type", 0)->orderBy("id", "desc")->paginate(18)
		];

		return view("admin/settings/homeContent")->with($data);
		
	}

	public function update(Request $request) {

		$page = Utility::where("title", $request->title)->first();
		$page->primary_editor = $request->primaryEditor;
		$page->secondary_editor = $request->secondaryEditor;


		$fields = json_encode([
			"primary_editor" => [
				"status" => isset($request->primaryContentStatus) ? 1 : 0,
				"content" => $request->primaryContent		//! 0 default 1 custom
			],
			"secondary_editor" => [
				"status" => isset($request->secondaryContentStatus) ? 1 : 0,
				"content" => $request->secondaryContent
			],
		]);

		$page->fields = $fields;
		$page->save();

		return redirect("/dashboard/home-content");
	}
}

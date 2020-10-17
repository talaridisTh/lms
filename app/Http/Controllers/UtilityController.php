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
		$page->first_section = $request->firstSectionContent;
		$page->second_section = $request->secondSectionContent;
		$page->third_section = $request->thirdSectionContent;
		$page->fourth_section = $request->fourthSectionContent;
		$page->fifth_section = $request->fifthSectionContent;

		$fields = json_encode([
			"first_section" => [
				"status" => isset($request->firstSectionStatus) ? 1 : 0,
				"content" => $request->firstSection		//! 0 default 1 custom
			],
			"second_section" => [
				"status" => isset($request->secondSectionStatus) ? 1 : 0,
				"content" => $request->secondSection
			],
			"third_section" => [
				"status" => isset($request->thirdSectionStatus) ? 1 : 0,
				"content" => $request->thirdSection
			],
			"fourth_section" => [
				"status" => isset($request->fourthSectionStatus) ? 1 : 0,
				"content" => $request->fourthSection
			],
			"fifth_section" => [
				"status" => isset($request->fifthSectionStatus) ? 1 : 0,
				"content" => $request->fifthSection
			]
		]);

		$page->fields = $fields;
		$page->save();

		return redirect("/dashboard/home-content");
	}
}

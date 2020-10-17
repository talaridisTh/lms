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
		$bannerStatuses = [];

		$temp = json_decode($page->sixth_section);
		extract( get_object_vars($temp) );		//! metatrepei tis times tou object se $model kai $ids
		$primaryRecords = $model::whereIn("id", $ids)->get();
		$bannerStatuses["primary"] = $status;

		$temp = json_decode($page->seventh_section);
		extract( get_object_vars($temp) );
		$secondaryRecords = $model::whereIn("id", $ids)->get();
		$bannerStatuses["secondary"] = $status;

		$temp = json_decode($page->eighth_section);
		extract( get_object_vars($temp) );
		$tetiaryRecords = $model::whereIn("id", $ids)->get();
		$bannerStatuses["tetiary"] = $status;

		$data = [
			"page" => $page,
			"primaryRecords" => $primaryRecords,
			"secondaryRecords" => $secondaryRecords,
			"tetiaryRecords" => $tetiaryRecords,
			"statuses" => json_decode($page->fields),
			"bannerStatuses" => $bannerStatuses,
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

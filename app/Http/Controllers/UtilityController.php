<?php

namespace App\Http\Controllers;

use App\Utility;
use App\Course;
use Illuminate\Http\Request;

class UtilityController extends Controller
{
    public function index() {

		$page = Utility::where("title", "Home page")->first();

		$temp = json_decode($page->sixth_section);
		extract(get_object_vars($temp));
		$sixthSection = $model::whereIn("id", $ids)->get();

		$temp = json_decode($page->seventh_section);
		extract(get_object_vars($temp));
		$seventhSection = $model::whereIn("id", $ids)->get();

		$temp = json_decode($page->eighth_section);
		extract(get_object_vars($temp));
		$eighthSection = $model::whereIn("id", $ids)->get();

		$data = [
			"page" => $page,
			"sixthSection" => $sixthSection,
			"seventhSection" => $seventhSection,
			"eighthSection" => $eighthSection,
			"statuses" => json_decode($page->statuses)
		];

		return view("admin/homeContent/homeContent")->with($data);
		
	}
}

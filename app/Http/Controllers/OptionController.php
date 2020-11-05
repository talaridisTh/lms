<?php

namespace App\Http\Controllers;

use App\Option;
use App\Media;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function index() {

		$data = [
			"title" => Option::firstOrCreate(["name" => "title"]),
			"copyright" => Option::firstOrCreate(["name" => "copyright"]),
			"logo" => Option::firstOrCreate(['name' => "logo"]),
			"description" => Option::firstOrCreate(['name' => "description"]),
			"terms" => Option::firstOrCreate(['name' => "terms"]),
			"privacyPolicy" => Option::firstOrCreate(['name' => "privacyPolicy"]),
			"cookiePolicy" => Option::firstOrCreate(['name' => "cookiePolicy"]),
			"contactInfo" => Option::firstOrCreate(['name' => "contactInfo"]),
			"social" => Option::firstOrCreate(['name' => "social"]),
			'media' => Media::where("type", 0)->orderBy("id", "desc")->paginate(18),
		];

		return view("admin/settings/general")->with($data);
	}

	public function update(Request $request) {

		$title = Option::where("name", "title")->first();
		$copyright = Option::where("name", "copyright")->first();
		$description = Option::where("name", "description")->first();
		$contactInfo = Option::where("name", "contactInfo")->first();
		$social = Option::where("name", "social")->first();

		$title->value = $request->title;
		$title->save();

		$copyright->value = $request->copyright;
		$copyright->save();

		$description->value = $request->description;
		$description->save();
		
		$contactInfo->value = json_encode([
			"city" => $request->city,
			"address" => $request->address,
			"zipCode" => $request->zipCode,
			"phone" => $request->phone,
			"fax" => $request->fax,
			"email" => $request->email
		]);
		$contactInfo->save();

		$social->value = json_encode([
			"facebook" => $request->facebook,
			"instagram" => $request->instagram,
			"twitter" => $request->twitter,
			"youtube" => $request->youtube,
			"linkedIn" => $request->linkedIn
		]);
		$social->save();
		
		return redirect( "/dashboard/general-settings" );
	}

	public function editPolicies($name) {

		$option = Option::firstOrCreate(["name" => $name]);	//name = "terms|privacyPolicy|cookiePolicy"

		return view("admin/settings/editPolicies")->with(["option" => $option]);

	}

	public function updatePolicies(Request $request, Option $option) {

		$option->value = $request->content;
		$option->save();

		return view("admin/settings/editPolicies")->with(["option" => $option]);
	}
}

<?php

namespace App\Http\Controllers;

use App\Option;
use App\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OptionController extends Controller
{
    public function index() {

		$data = [
			"title" => Option::where("name", "Title")->first(),
			"copyright" => Option::where("name", "Copyright")->first(),
			"logo" => Option::where('name', "Logo")->first(),
			"description" => Option::where('name', "Description")->first(),
			"terms" => Option::where('name', "Terms of Use")->first(),
			"privacyPolicy" => Option::where('name', "Privacy Policy")->first(),
			"cookiePolicy" => Option::where('name', "Cookie Policy")->first(),
			"contactInfo" => Option::where('name', "Contact Info")->first(),
			"social" => Option::where('name', "Social")->first(),
			'media' => Media::where("type", 0)->orderBy("id", "desc")->paginate(18),
		];

		return view("admin/settings/general")->with($data);
	}

	public function store(Request $request) {

		$option = new Option;
		$option->name = $request->name;
		$option->slug = Str::slug($request->name);
		$option->value = $request->value;
		$option->save();

		return redirect("/dashboard/options");
	}

	public function update(Request $request) {

		$title = Option::where("name", "Title")->first();
		$copyright = Option::where("name", "Copyright")->first();
		$description = Option::where("name", "Description")->first();
		$contactInfo = Option::where("name", "Contact Info")->first();
		$social = Option::where("name", "Social")->first();

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

	public function showCarousels() {

		$page = Option::where("name", "Index Carousels")->first();

		if ( $page !== null) {
			$bannersData = json_decode($page->value);
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
		}
		else {
			$banners = [
				"primary" => [
					"models" => [],
					"status" => 0
				],
				"secondary" => [
					"models" => [],
					"status" => 0
				],
			];
		}

		$data = [
			"page" => $page,
			"banners" => $banners
		];

		return view("admin/settings/editCarousels")->with($data);
	}

	public function editPolicies($slug) {

		$option = Option::where(["slug" => $slug])->first();	//slug = "terms-of-use|privacy-policy|cookie-policy"

		return view("admin/settings/editPolicies")->with(["option" => $option]);

	}

	public function updatePolicies(Request $request, Option $option) {

		$option->value = $request->content;
		$option->save();

		return view("admin/settings/editPolicies")->with(["option" => $option]);
	}

	public function createJson() {

		return view("admin/settings/jsonEditor");

	}

	public function storeJson(Request $request) {

		$request->validate([
			'name' => 'required|unique:options',
			'json' => 'required|json'
		]);

		$option = new Option;
		$option->name = $request->name;
		$option->slug = Str::slug($request->name);
		$option->value = json_encode(json_decode($request->json));
		$option->save();

		return redirect("/dashboard/option/$option->id/show-json");
	}

	public function showJson(Option $option) {

		$data = [
			"option" => $option,
			"value" => json_encode(json_decode($option->value), JSON_PRETTY_PRINT),
		];

		return view("admin/settings/jsonEditor")->with($data);
	}

	public function jsonUpdate(Option $option, Request $request) {

		$request->validate([
			'name' => 'required',
			'json' => 'required|json'
		]);

		$option->name = $request->name;
		$option->slug = Str::slug($request->name);
		$option->value = json_encode(json_decode($request->json));
		$option->save();

		return redirect("/dashboard/option/$option->id/show-json");
	}

	public function devIndex() {

		return view("admin/settings/settingsIndex");
	}
}

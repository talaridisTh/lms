<?php

namespace App\Http\Controllers\Ajax;

use App\DataTables\Carousels\MaterialsDataTable;
use App\DataTables\Carousels\CoursesDataTable;
use App\DataTables\Carousels\BundlesDataTable;
use App\DataTables\Options\OptionsDataTable;
use App\Http\Controllers\Controller;
use App\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OptionController extends Controller
{
	public function mainDatatable(OptionsDataTable $dataTable) {

		return $dataTable->render('options.main');
	}

	public function simpleMaterialsDatatable(MaterialsDataTable $datatable) {
		return $datatable->render('simple.materials.datatable');
	}

	public function simpleCoursesDatatable(CoursesDataTable $datatable) {
		return $datatable->render('simple.courses.datatable');
	}

	public function simpleBundlesDatatable(BundlesDataTable $datatable) {
		return $datatable->render('simple.bundles.datatable');
	}

	public function update(Option $option, Request $request) {

		$option->name = $request->name;
		$option->slug = Str::slug($request->name);
		$option->value = $request->value;
		$option->save();
	}

	public function destroy(Option $option) {

		$option->delete();

	}

	public function updateBanners(Request $request) {

		$option = Option::where("name", "Index Carousels")->first();
		$option->value = $request->updatedData;
		$option->save();
		
		$models = [];

		if ( $request->selectedBanners === false ) {
			return;
		}

		foreach ( $request->selectedBanners["models"] as $model ) {
			$namespace = key((array)$model);
			$id = current((array)$model);

			$temp = $namespace::find( $id );

			array_push($models, $temp);

		}

		return view("components/admin/settings/homeEditCardsBuilder", ['models' => $models]);
	}
}

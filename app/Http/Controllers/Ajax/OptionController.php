<?php

namespace App\Http\Controllers\Ajax;

use App\DataTables\SimpleMaterialsDataTable;
use App\DataTables\SimpleCoursesDataTable;
use App\DataTables\SimpleBundlesDataTable;
use App\DataTables\OptionsDataTable;
use App\Http\Controllers\Controller;
use App\Option;
use Illuminate\Http\Request;

class OptionController extends Controller
{
	public function mainDatatable(OptionsDataTable $dataTable) {

		return $dataTable->render('options.main');
	}

	public function simpleMaterialsDatatable(SimpleMaterialsDataTable $datatable) {
		return $datatable->render('simple.materials.datatable');
	}

	public function simpleCoursesDatatable(SimpleCoursesDataTable $datatable) {
		return $datatable->render('simple.courses.datatable');
	}

	public function simpleBundlesDatatable(SimpleBundlesDataTable $datatable) {
		return $datatable->render('simple.bundles.datatable');
	}

	public function update(Option $option, Request $request) {

		$option->name = $request->name;
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

<?php

namespace App\Http\Controllers\Ajax;

use App\DataTables\OptionsDataTable;
use App\Http\Controllers\Controller;
use App\Option;
use Illuminate\Http\Request;

class OptionController extends Controller
{
	public function update(Option $option, Request $request) {

		$option->name = $request->name;
		$option->value = $request->value;
		$option->save();
		// dd($option, $request->all());

	}
	
    public function optionJsonUpdate(Option $option, Request $request) {

		$option->name = $request->name;
		$option->value = json_encode(json_decode($request->value));
		$option->save();
		
	}

	public function mainDatatable(OptionsDataTable $dataTable) {

		return $dataTable->render('options.main');
	}
}

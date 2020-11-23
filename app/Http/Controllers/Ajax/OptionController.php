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
	}

	public function mainDatatable(OptionsDataTable $dataTable) {

		return $dataTable->render('options.main');
	}
}

<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Option;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function optionJsonUpdate(Option $option, Request $request) {

		$option->value = json_encode(json_decode($request->value));
		$option->save();
		
	}
}

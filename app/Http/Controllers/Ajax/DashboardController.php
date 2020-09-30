<?php

namespace App\Http\Controllers\Ajax;

use App\Bundle;
use App\Course;
use App\Http\Controllers\Controller;
use App\Material;
use App\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function globalSearch(Request $request) {
		// dd($request->value);

		$totalCount = 0;

		$users = User::where(function($query) use ($request) {

			$query->where("last_name", "LIKE", "%$request->value%")
			->orWhere("phone", "LIKE", "%$request->value%")->get();

		})->limit(4)->get();

		$totalCount = User::where(function($query) use ($request) {

			$query->where("last_name", "like", "%$request->value%")
			->orWhere("phone", "like", "%$request->value%")->get();

		})->count();
		$totalCount += Bundle::where("title", "LIKE", "%$request->value%")->count();
		$totalCount += Course::where("title", "LIKE", "%$request->value%")->count();
		$totalCount += Material::where("title", "LIKE", "%$request->value%")->count();

		$data = [
			'users' => $users,
			'bundles' => Bundle::where("title", "LIKE", "%$request->value%")->limit(4)->get(),
			'courses' => Course::where("title", "LIKE", "%$request->value%")->limit(4)->get(),
			'materials' => Material::where("title", "LIKE", "%$request->value%")->limit(4)->get(),
			'totalCount' => $totalCount
		];
		
		return view('components/admin/globalSearch')->with($data);
	}
}

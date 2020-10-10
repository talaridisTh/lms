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

		$users = User::where(function($query) use ($request) {

			$query->where("last_name", "LIKE", "%$request->search%")
				->orWhere("first_name", "LIKE", "%$request->search%")
				->orWhere("email", "LIKE", "%$request->search%")
				->orWhere("phone", "LIKE", "%$request->search%")->get();

		})->limit(4)->get();

		$totalCount = User::where(function($query) use ($request) {

			$query->where("last_name", "LIKE", "%$request->search%")
				->orWhere("first_name", "LIKE", "%$request->search%")
				->orWhere("email", "LIKE", "%$request->search%")
				->orWhere("phone", "LIKE", "%$request->search%")->get();

		})->count();

		$materials = Material::where( function($query) use ($request) {

			$unwatned = ["Video", "Link", "Announcement", "Section"];

			$query->where("title", "LIKE", "%$request->search%")
				->whereNotIn("type", $unwatned)->get();

		})->limit(4)->get();

		$totalCount += Bundle::where("title", "LIKE", "%$request->search%")->count();
		$totalCount += Course::where("title", "LIKE", "%$request->search%")->count();
		$totalCount += Material::where( function($query) use ($request) {

			$unwatned = ["Video", "Link", "Announcement", "Section"];

			$query->where("title", "LIKE", "%$request->search%")
				->whereNotIn("type", $unwatned)->get();

		})->count();

		$data = [
			'users' => $users,
			'bundles' => Bundle::where("title", "LIKE", "%$request->search%")->limit(4)->get(),
			'courses' => Course::where("title", "LIKE", "%$request->search%")->limit(4)->get(),
			'materials' => $materials,
			'totalCount' => $totalCount
		];
		
		return view('components/admin/globalSearch')->with($data);
	}
}

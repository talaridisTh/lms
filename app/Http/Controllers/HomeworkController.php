<?php

namespace App\Http\Controllers;

use App\DataTables\Homeworks\HomeworksDataTable;
use App\Models\Homework;
use Illuminate\Http\Request;

class HomeworkController extends Controller
{
    public function index() {

		return view("admin/homeworks/homeworksMain");
	}

	public function indexDataTable(HomeworksDataTable $datatable) {

		return $datatable->render('homeworks.index');
	}

	public function homeworkContent(Homework $homework) {

		$homework->load("student", "course", "attachments");
		
		return view("components/admin/ajax/homeworkModalContent", compact("homework"));
	}

	public function inspected(Homework $homework, Request $request) {

		$homework->update([
			"seen_at" => $request->inspected ? now() : null
		]);
	}
}

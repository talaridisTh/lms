<?php

namespace App\Http\Controllers;

use App\DataTables\Homeworks\HomeworksDataTable;
use App\Models\Homework;
use Illuminate\Http\Request;

class HomeworkController extends Controller
{
    public function index() {

		$homework = Homework::find(1)->with("student", "course")->get();
		return view("admin/homeworks/homeworksMain")->with(["homework" => $homework]);
	}

	public function indexDataTable(HomeworksDataTable $datatable) {

		return $datatable->render('homeworks.index');
	}
}

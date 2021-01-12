<?php

namespace App\Http\Controllers;

use App\DataTables\Homeworks\HomeworksDataTable;
use App\Models\Homework;
use Illuminate\Http\Request;

class HomeworkController extends Controller
{
    public function index() {

		$homework = Homework::find(5)->load("student", "course", "attachments");
		return view("admin/homeworks/homeworksMain")->with(["homework" => $homework]);
	}

	public function indexDataTable(HomeworksDataTable $datatable) {

		return $datatable->render('homeworks.index');
	}

	public function homeworkContent(Homework $homework) {

		$homework->load("student", "course", "attachments");
		
		return view("components/admin/ajax/homeworkModalContent", compact("homework"));
	}
}

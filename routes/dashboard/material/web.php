<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\Ajax\MaterialController as MaterialAjaxController;

Route::prefix("dashboard")->group(function() {
	Route::get('materials/create/{course?}/{priority?}/{material:id?}', [MaterialController::class, "create"]);
	
	Route::resource("materials", MaterialController::class)
		->only(["index", "edit", "update", "store"]);

	Route::get('pdf/create/{course?}/{priority?}/{material?}', [MaterialController::class, "createPDF"]);
	Route::post('pdf', [MaterialController::class, "storePDF"]);
	Route::get('pdf/{material}/edit', [MaterialController::class, "editPDF"]);
});

Route::prefix("material-datatables")->group(function() {
	Route::post('main', [MaterialAjaxController::class, "index"]);
    Route::post('material-courses', [MaterialAjaxController::class, "materialCourses"]);
    Route::post('courses', [MaterialAjaxController::class, "coursesDatatable"]);
});

Route::prefix("material-ajax")->group(function() {

	//mpori na sigxoneuti me to aplo status
	Route::patch('bulk-toggle-status', [MaterialAjaxController::class, "changeStatusMultiple"]);
	//xriazete refactor
	Route::delete('delete', [MaterialAjaxController::class, "destroyMultipleMaterials"]);
});
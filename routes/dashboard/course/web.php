<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\Ajax\CourseController as CourseAjaxController;

//! Course CRUD
Route::prefix("dashboard")->group(function () {
	//* opoiodipote extra route prepei na mpenei PRIN to resource route
	Route::post('courses/clone', [CourseController::class, "clone"]);

	Route::resource("courses", CourseController::class)
		->only(["index", "create", "store", "edit", "update"]);

	// Route::get('courses', [CourseController::class, "index"]);
	// Route::get('courses/create', [CourseController::class, "create"]);
	// Route::post('courses', [CourseController::class, "store"]);
	// Route::get('courses/{course}/edit', [CourseController::class, "edit"]);
	// Route::patch('courses/{course}', [CourseController::class, "update"]);


	// Route::delete('course/{course}', [CourseController::class, "softDelete"])->name('course.softDelete');
});

Route::prefix("course-datatables")->group(function() {
	Route::post('main', [CourseAjaxController::class, "index"]);
    Route::post('course-materials', [CourseAjaxController::class, "courseMaterials"]);
    Route::post('materials', [CourseAjaxController::class, "remainingMaterials"]);
    Route::post('course-users', [CourseAjaxController::class, "courseUsers"]);
    Route::post('users', [CourseAjaxController::class, "usersDataTable"]);
});

Route::prefix("course-ajax")->group(function() {
	Route::delete('destroy/{ids}', [CourseAjaxController::class, "destroy"]);
    Route::patch('status', [CourseAjaxController::class, "toggleStatus"]);
    Route::patch('priority', [CourseAjaxController::class, "changePriority"]);
    Route::patch('toggle-materials', [CourseAjaxController::class, "toggleMaterials"]);
	Route::post('add-materials', [CourseAjaxController::class, "addMaterials"]);
	Route::patch('remove-materials', [CourseAjaxController::class, "removeMaterials"]);
    Route::patch('add-users', [CourseAjaxController::class, "addUsers"]);
    Route::patch('remove-users', [CourseAjaxController::class, "removeUsers"]);
    Route::patch('{course:id}/toggle-editors', [CourseAjaxController::class, "toggleEditors"]);
	Route::patch('{course:id}/toggle-highlight', [CourseAjaxController::class, "toggleHighlight"]);
	Route::post('{course:id}/gallery-upload', [CourseAjaxController::class, "galleryUpload"]);
	Route::patch('{course:id}/gallery-sort', [CourseAjaxController::class, "gallerySort"]);
});
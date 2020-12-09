<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\Ajax\CourseController as CourseAjaxController;
use App\Http\Controllers\Ajax\SectionController as SectionAjaxController;

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
    Route::patch('{course:id}/toggle-material', [CourseAjaxController::class, "toggleMaterial"]);
    Route::patch('{course:id}/toggle-multiple-materials', [CourseAjaxController::class, "toggleMultipleMaterials"]);
	Route::post('add-materials', [CourseAjaxController::class, "addMaterials"]);
	Route::patch('remove-materials', [CourseAjaxController::class, "removeMaterials"]);
    Route::patch('add-users', [CourseAjaxController::class, "addUsers"]);
    Route::patch('remove-users', [CourseAjaxController::class, "removeUsers"]);
    Route::patch('{course:id}/toggle-editors', [CourseAjaxController::class, "toggleEditors"]);
	Route::patch('{course:id}/toggle-highlight', [CourseAjaxController::class, "toggleHighlight"]);
	Route::post('{course:id}/gallery-upload', [CourseAjaxController::class, "galleryUpload"]);
	Route::patch('{course:id}/gallery-sort', [CourseAjaxController::class, "gallerySort"]);
	Route::patch('{course:id}/publish-material', [CourseAjaxController::class, "publishMaterial"]);
});

Route::prefix("section-ajax")->group(function() {
	Route::post("remove-chapters", [SectionAjaxController::class, "removeChapters"]);
    Route::patch("{material:id}/toggle-chapters", [SectionAjaxController::class, "toggleChapters"]);
    Route::patch("toggle-hightlight/{material:id}", [SectionAjaxController::class, "toggleHighlight"]);
    Route::patch("chapters-priority", [SectionAjaxController::class, "chaptersPriority"]);
	Route::post("add-content", [SectionAjaxController::class, "addNewChapter"]);
});
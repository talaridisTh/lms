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
	
    Route::patch('bulk-status-update', [CourseAjaxController::class, "bulkStatusUpdate"]);
	
	Route::middleware("can:customEdit,App\Models\Course")->group(function() {
		Route::patch('{course:id}/remove-users', [CourseAjaxController::class, "removeUsers"]);
		Route::patch('add-users', [CourseAjaxController::class, "addUsers"]);
	});
	
	Route::middleware("can:update,course")->group(function() {
		Route::patch('{course:id}/priority', [CourseAjaxController::class, "changePriority"]);
		Route::post('{course:id}/add-materials', [CourseAjaxController::class, "addMaterials"]);
		Route::patch('{course:id}/status', [CourseAjaxController::class, "toggleStatus"]);
		Route::patch('{course:id}/remove-materials', [CourseAjaxController::class, "removeMaterials"]);
		Route::patch('{course:id}/toggle-material', [CourseAjaxController::class, "toggleMaterial"]);
		Route::patch('{course:id}/toggle-multiple-materials', [CourseAjaxController::class, "toggleMultipleMaterials"]);
		Route::patch('{course:id}/toggle-editors', [CourseAjaxController::class, "toggleEditors"]);
		Route::patch('{course:id}/toggle-highlight', [CourseAjaxController::class, "toggleHighlight"]);
		Route::post('{course:id}/gallery-upload', [CourseAjaxController::class, "galleryUpload"]);
		Route::patch('{course:id}/gallery-sort', [CourseAjaxController::class, "gallerySort"]);
		Route::patch('{course:id}/publish-material', [CourseAjaxController::class, "publishMaterial"]);
		Route::patch('{course:id}/edit-publish', [CourseAjaxController::class, "editPublish"]);
		Route::post("{course:id}/move-to-section/{material:id}", [CourseAjaxController::class, "moveToSection"]);
		Route::get("{course:id}/sections", [CourseAjaxController::class, "courseSections"]);
	});
});

Route::prefix("section-ajax")->group(function() {
	// Route::post("remove-chapters", [SectionAjaxController::class, "removeChapters"]);
	Route::middleware("can:update,course")->group(function() {
		Route::post("{course:id}/remove-chapters", [SectionAjaxController::class, "removeChapters"]);
	});
	Route::post("{course:id}/add-content", [SectionAjaxController::class, "addNewChapter"]);

    Route::patch("{course:id}/{material:id}/toggle-multiple-chapters", [SectionAjaxController::class, "toggleMultipleChapters"]);
    Route::patch("{course:id}/{material:id}/toggle-chapter", [SectionAjaxController::class, "toggleChapter"]);

    Route::patch("{course:id}/{material:id}/toggle-hightlight", [SectionAjaxController::class, "toggleHighlight"]);
	Route::patch("{course:id}/{material:id}/chapters-priority", [SectionAjaxController::class, "chaptersPriority"]);
	
	Route::patch('{course:id}/{material:id}/publish-chapter', [SectionAjaxController::class, "publishchapter"]);

});
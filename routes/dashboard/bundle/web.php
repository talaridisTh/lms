<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BundleController;
use App\Http\Controllers\Ajax\BundleController as BundleAjaxController;

//! Bundle CRUD
Route::prefix("dashboard")->group(function() {

	Route::resource("bundles", BundleController::class)
		->only(["index", "create", "store", "edit", "update"]);

	// Route::delete('/dashboard/bundle/{bundle}', [BundleController::class, "softDelete"])->name('bundle.softDelete');
});

Route::prefix("bundle-datatables")->group(function() {
	Route::post('main', [BundleAjaxController::class, "index"]);
	Route::post('bundle-courses', [BundleAjaxController::class, "show"]);
	Route::post('bundle-users', [BundleAjaxController::class, "bundleUsers"]);
	Route::post('courses', [BundleAjaxController::class, "remainingCourses"]);
	Route::post('users', [BundleAjaxController::class, "remainingUsers"]);
});

Route::prefix("bundle-ajax")->group(function() {
	Route::delete('destroy/{ids}', [BundleAjaxController::class, "destroy"]);
    Route::patch('{bundle:id}/status', [BundleAjaxController::class, "toggleStatus"]);
    Route::patch('{bundle:id}/add-courses', [BundleAjaxController::class, "addCourses"]);
    Route::patch('{bundle:id}/remove-courses', [BundleAjaxController::class, "removeCourses"]);
    Route::post('{bundle:id}/remove-users', [BundleAjaxController::class, "removeUsers"]);
    Route::post('{bundle:id}/add-users', [BundleAjaxController::class, "addUsers"]);
	Route::patch('{bundle:id}/toggle-editors', [BundleAjaxController::class, "toggleEditors"]);
});
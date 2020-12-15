<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Ajax\UserController as UserAjaxController;

Route::prefix("dashboard")->group(function() {

	// Route::resource("users", UserController::class)
	// 	->only(["index", "create", "store", "edit", "update"]);

	Route::get('users', [UserController::class, "index"]);
	Route::get('users/create', [UserController::class, "create"]);
	Route::post('users', [UserController::class, "store"]);


	//!########### prepei na gini ################ 
	//!########### users/{user}/edit #############
	//!########### gia na mpei sto resource ######
	Route::get('users/{user}', [UserController::class, "edit"]);
	Route::patch('users/{user}', [UserController::class, "update"]);

	// Route::delete('/dashboard/bundle/{bundle}', [BundleController::class, "softDelete"])->name('bundle.softDelete');
});

Route::prefix("users-ajax")->group(function() {
	Route::post('{user:id}/sent-info', [UserAjaxController::class, "sentInfo"]);
});
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
	
	Route::patch('users/{user}', [UserController::class, "update"]);

	//!########### prepei na gini ################ 
	//!########### users/{user}/edit #############
	//!########### gia na mpoun sto resource ######
	Route::get('users/{user}', [UserController::class, "edit"]);
});

Route::prefix("users-ajax")->group(function() {
	Route::post('{user:id}/sent-info', [UserAjaxController::class, "sentInfo"]);
    Route::post("{user:id}/show-password", [UserAjaxController::class, "showPassword"]);
    Route::patch("{user:id}/reset-avatar", [UserAjaxController::class, "resetAvatar"]);

});
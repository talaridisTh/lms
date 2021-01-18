<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Ajax\MediaController as MediaAjaxController;

Route::prefix("media-ajax")->group(function() {

	Route::patch("{media:id}/toggle-public-pass", [MediaAjaxController::class, "togglePublicPass"]);
	Route::get("{media:id}/get-media-details", [MediaAjaxController::class, "getMediaDetails"]);
});
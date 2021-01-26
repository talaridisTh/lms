<?php

use App\Http\Controllers\Index\CourseController;
use App\Http\Controllers\Index\HomeController;
use App\Http\Controllers\Index\MaterialController;
use App\Http\Controllers\Index\UserController;
use Illuminate\Support\Facades\Route;

Route::get("/", [HomeController::class, "index"])->name('home');
Route::prefix("home")->name("index.")->group(function () {

    Route::get("courses/{user}", [CourseController::class, "userCourses"])->name("userCourses");
    Route::get("account/{user}", [UserController::class, "index"])->name("account");
    Route::post("account/{user}/update", [UserController::class, "update"])->name("update");
    Route::post("account/{user}/upload-avatar", [UserController::class, "uploadAvatar"])->name("uploadAvatar");
    Route::patch("message/update", [HomeController::class, "updateSeenMessage"])->name("update.message");
    Route::patch("task/update", [HomeController::class, "updateTaskMessage"])->name("update.task");
    Route::patch("announcement/update", [HomeController::class, "updateAnnouncementMessage"])->name("update.announcement");
    //note group with middleware verify course z
    Route::group(['middleware' => 'verifyCourse'], function () {
        Route::get("course/{course}", [CourseController::class, "showCourse"])->name("showCourse")->middleware("verifyCourse");
        Route::get("course/{course}/{material}", [CourseController::class, "showMaterial"])->name("showMaterial")->middleware("verifyCourse");
        Route::get("material/", [MaterialController::class, 'material'])->name("material")->middleware("verifyCourse");
    });
//    Route::get("course/{course}", [CourseController::class, "showCourse"])->name("showCourse")->middleware("verifyCourse");
//    Route::get("course/{course}/{material}", [CourseController::class, "showMaterial"])->name("showMaterial")->middleware("verifyCourse");
//    Route::get("material/", [MaterialController::class, 'material'])->name("material")->middleware("verifyCourse");
});

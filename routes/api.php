<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//!	Courses Ajax Calls
Route::delete( 'courses/massdestroy/{ids}', 'Api\CourseController@massdestroy' );
Route::patch( 'courses/active', 'Api\CourseController@toggleActive' );
Route::patch( 'courses/priority', 'Api\CourseController@changePriority' );
Route::patch( 'courses/toggle-materials', 'Api\CourseController@toggleCourseMaterials' );
Route::post( 'courses/add-materials', 'Api\CourseController@addMaterials' );


//! Courses Datatables
Route::post( 'courses/courses-datatable', 'Api\CourseController@index' );
Route::post( 'courses/course-materials-datatable', 'Api\CourseController@courseMaterials' );
Route::post( 'courses/not-incourse-materials-datatable', 'Api\CourseController@remainingMaterials' );





//Users
Route::post('users/view-users', 'Api\UserController@index')->name("index.datatable");
Route::post('users/view-user', 'Api\UserController@show')->name("show.datatable");
Route::post('/user/add-course-modal', 'Api\UserController@addCourseModal')->name("courseModal.datatable");
Route::patch('/user/add-course', 'Api\UserController@addCourses')->name("addcourses.datatable");
Route::patch('/changeStatus', 'Api\UserController@changeStatus')->name("changeStatus.datatable");;

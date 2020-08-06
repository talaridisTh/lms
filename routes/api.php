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

//!	Courses Ajax Routes
Route::delete( 'courses/massdestroy/{ids}', 'Api\CourseController@massdestroy' );
Route::patch( 'courses/active', 'Api\CourseController@toggleActive' );
Route::patch( 'courses/priority', 'Api\CourseController@changePriority' );
Route::patch( 'courses/toggle-materials', 'Api\CourseController@toggleCourseMaterials' );


//! Courses Datatables
Route::post( 'courses/courses-datatable', 'Api\CourseController@index' );
Route::post( 'courses/course-materials-datatable', 'Api\CourseController@courseMaterials' );
Route::post( 'courses/not-incourse-materials-datatable', 'Api\CourseController@remainingMaterials' );
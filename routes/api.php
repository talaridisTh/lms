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

Route::post( 'courses/coursesdatatable', 'Api\CourseController@index' );



Route::delete( 'courses/massdestroy/{ids}', 'Api\CourseController@massdestroy' );
Route::patch( 'courses/active', 'Api\CourseController@toggleActive' );
Route::patch( 'courses/priority', 'Api\CourseController@changePriority' );


//Users
Route::post('users/userDatatable', 'Api\UserController@index')->name("index.datatable");
Route::patch('/addCourses', 'Api\UserController@addCourses')->name("addcourses.datatable");
Route::patch('/changeStatus', 'Api\UserController@changeStatus')->name("changeStatus.datatable");;


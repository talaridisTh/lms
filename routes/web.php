<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/clear', function() {
    Artisan::call('cache:clear');

    return redirect(route("home"));

});

Route::group(['middleware' => ['auth',"role:admin"]], function () {

    Route::get('/dashboard', 'DashboardController@index')->name("dashboard");

	//! User Routes
    Route::get('/dashboard/users', 'UserController@index')->name('user.index');
    Route::get('/dashboard/create', 'UserController@create')->name('user.create');
    Route::get('/dashboard/users/{user}', 'UserController@show')->name('user.show');
    Route::post('/dashboard/users/create', 'UserController@store')->name('user.store');
    Route::patch('/dashboard/users/{user}', 'UserController@update')->name('user.update');
    Route::delete('/dashboard/users/{user}', 'UserController@destroy')->name('user.destroy');

	//! Material Routes
    Route::get('/dashboard/materials', 'MaterialController@index')->name('material.index');
    Route::get('/dashboard/material/{material}', 'MaterialController@show')->name('material.show');
    Route::get('/dashboard/materials/new', 'MaterialController@newMaterial')->name('material.new');

	//! Course Routes
    Route::get('/dashboard/courses', 'CourseController@index')->name('course.index');
    Route::get('/dashboard/course/{course}', 'CourseController@show')->name('course.show');
    // Route::get('/dashboard/courses/create', 'CourseController@create')->name('course.create');

	//!Bundle Routes
    Route::get('/dashboard/bundles', 'BundleController@index')->name('bundle.index');
    Route::get('/dashboard/bundle/{bundle}', 'BundleController@show')->name('bundle.show');
    Route::get('/dashboard/bundles/create', 'BundleController@create')->name('bundle.create');

});

//! Ajax Users Datatables
Route::post('users/view-users', 'Ajax\UserController@index')->name("index.datatable");
Route::post('users/view-user', 'Ajax\UserController@show')->name("show.datatable");
Route::post('/user/add-course-modal', 'Ajax\UserController@addCourseModal')->name("courseModal.datatable");

//! Ajax Users CRUD
Route::patch('/user/add-course', 'Ajax\UserController@addCourses')->name("addcourses.datatable");
Route::patch('/user/changeStatus', 'Ajax\UserController@changeStatus')->name("changeStatus.datatable");;
Route::delete('/user/delete', 'Ajax\UserController@destroy')->name("destroy.datatable");
Route::delete('/user/multiple/delete', 'Ajax\UserController@destroyMultiple')->name("destroyMultiple.datatable");


//! Ajax Courses Datatables
Route::post( 'courses/courses-datatable', 'Ajax\CourseController@index' );
Route::post( 'courses/course-materials-datatable', 'Ajax\CourseController@courseMaterials' );
Route::post( 'courses/not-incourse-materials-datatable', 'Ajax\CourseController@remainingMaterials' );

//! Ajax Courses CRUD
Route::delete( 'courses/massdestroy/{ids}', 'Ajax\CourseController@massdestroy' );
Route::patch( 'courses/active', 'Ajax\CourseController@toggleActive' );
Route::patch( 'courses/priority', 'Ajax\CourseController@changePriority' );
Route::patch( 'courses/toggle-materials', 'Ajax\CourseController@toggleCourseMaterials' );
Route::post( 'courses/add-materials', 'Ajax\CourseController@addMaterials' );
Route::patch( 'courses/remove-materials', 'Ajax\CourseController@removeMaterials' );

//! Ajax Bundles Datatables
Route::post( 'bundles/bundles-datatable', 'Ajax\BundleController@index' );
Route::post( 'bundles/bundle-courses-datatable', 'Ajax\BundleController@show' );
Route::post( 'bundles/remaining-courses-datatable', 'Ajax\BundleController@remainingCourses' );

//! Ajax Bundles CRUD
Route::patch( 'bundles/bundles-toggle-active/{bundle}', 'Ajax\BundleController@update' );
Route::patch( 'bundles/add-courses', 'Ajax\BundleController@addCourses' );
Route::patch( 'bundles/remove-courses', 'Ajax\BundleController@removeCourses' );

//! Ajax Materials Datatables
Route::post( 'materials/materials-datatable', 'Ajax\MaterialController@index' );

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');




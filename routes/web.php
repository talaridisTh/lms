<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Spatie\Activitylog\Models\Activity;
use Spatie\UrlSigner\MD5UrlSigner;


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
Route::get("/expot/users", "ExportController@usersAll")->name("export.usersAll");
Route::get('/', function () {
    return view('welcome');
});

Route::get('/clear', function() {
    Artisan::call('cache:clear');
    return redirect(route("home"));
});



Route::get("/test", "Index\HomeController@test")->name("user.test");



//!########################################################
//! Dashboard routes
//!########################################################
Route::group(['middleware' => ['auth',"role:admin"]], function () {

    Route::get('/dashboard', 'DashboardController@index')->name("dashboard");

	//! User Routes
    Route::get('/dashboard/users', 'UserController@index')->name('user.index');
    Route::get('/dashboard/users/create', 'UserController@create')->name('user.create');
    Route::get('/dashboard/users/{user:slug}', 'UserController@show')->name('user.show');
    Route::post('/dashboard/users/create', 'UserController@store')->name('user.store');
    Route::patch('/dashboard/users/update/{user:slug}', 'UserController@update')->name('user.update');
    Route::delete('/dashboard/users/{user}', 'UserController@destroy')->name('user.destroy');

	//! Material Routes
    Route::get('/dashboard/materials', 'MaterialController@index')->name('material.index');
    Route::get('/dashboard/material/{material:slug}', 'MaterialController@show')->name('material.show');
    Route::get('/dashboard/materials/create', 'MaterialController@create')->name('material.create');
    Route::post('/dashboard/materials/store', 'MaterialController@store')->name('material.store');
    Route::patch('/dashboard/materials/update/{material:slug}', 'MaterialController@update')->name('material.update');
	//! Course Routes
    Route::get('/dashboard/courses', 'CourseController@index')->name('course.index');
    Route::get('/dashboard/course/{course}', 'CourseController@show')->name('course.show');
    Route::get('/dashboard/courses/create', 'CourseController@create')->name('course.create');
	Route::post('/dashboard/courses/store', 'CourseController@store')->name('course.store');
	Route::post('/dashboard/courses/clone', 'CourseController@clone')->name('course.clone');
    Route::patch('/dashboard/courses/update/{course}', 'CourseController@update')->name('course.update');
    Route::delete('/dashboard/course/{course}', 'CourseController@destroy')->name('course.destroy');

	//! Bundle Routes
    Route::get('/dashboard/bundles', 'BundleController@index')->name('bundle.index');
    Route::get('/dashboard/bundle/{bundle}', 'BundleController@show')->name('bundle.show');
    Route::post('/dashboard/bundle/store', 'BundleController@store')->name('bundle.store');
    Route::patch('/dashboard/bundle/update/{bundle}', 'BundleController@update')->name('bundle.update');

	//! Topic Routes
	Route::get('/dashboard/topics', 'TopicController@index')->name('topic.index');

});

//!======================================================
//! 			End Dashboard Routes					|
//!======================================================


//!########################################################
//! AJAX routes
//!########################################################

//! Dashboard Ajax Users Datatables
Route::post('users/view-users', 'Ajax\UserController@index')->name("index.datatable");
Route::post('users/view-user', 'Ajax\UserController@show')->name("show.datatable");
Route::post('/user/add-course-modal', 'Ajax\UserController@addCourseModal')->name("courseModal.datatable");
Route::post('/user/courses-inside-users', 'Ajax\UserController@coursesInsideUsers')->name("coursesInsideUsers.datatable");

//! Dashboard Ajax Users CRUD
Route::patch('/user/add-course', 'Ajax\UserController@addCourses')->name("addcourses.datatable");
Route::patch('/user/changeStatus', 'Ajax\UserController@changeStatus')->name("changeStatus.datatable");;
Route::patch('/user/multiple/changeStatus', 'Ajax\UserController@changeStatusMultiple')->name("changeStatusMultiple.datatable");;
Route::patch('/user/multiple/add-course', 'Ajax\UserController@addCoursesMultipleUsers')->name("addCoursesMultipleUsers.datatable");
Route::delete('/user/delete', 'Ajax\UserController@destroy')->name("destroy.datatable");
Route::delete('/user/multiple/courses/delete', 'Ajax\UserController@destroyMultipleCourses')->name("destroyMultipleCourses.datatable");
Route::delete('/user/multiple/users/delete', 'Ajax\UserController@destroyMultipleUsers')->name("destroyMultipleUsers.datatable");


//! Dashboard Ajax Courses Datatables
Route::post( 'courses/courses-datatable', 'Ajax\CourseController@index' );
Route::post( 'courses/course-materials-datatable', 'Ajax\CourseController@courseMaterials' );
Route::post( 'courses/not-incourse-materials-datatable', 'Ajax\CourseController@remainingMaterials' );
Route::post( 'courses/course-students-datatable', 'Ajax\CourseController@courseStudents' );
Route::post( 'courses/add-course-students-datatable', 'Ajax\CourseController@addCourseStudents' );

//! Dashboard Ajax Courses CRUD
Route::delete( 'courses/destroy/{ids}', 'Ajax\CourseController@destroy' );
Route::patch( 'courses/status', 'Ajax\CourseController@toggleStatus' );
Route::patch( 'courses/priority', 'Ajax\CourseController@changePriority' );
Route::patch( 'courses/toggle-materials', 'Ajax\CourseController@toggleCourseMaterials' );
Route::post( 'courses/add-materials', 'Ajax\CourseController@addMaterials' );
Route::patch( 'courses/remove-materials', 'Ajax\CourseController@removeMaterials' );
Route::patch( 'courses/add-students', 'Ajax\CourseController@addStudents' );
Route::patch( 'courses/remove-students', 'Ajax\CourseController@removeStudents' );

//! Dashboard Ajax Bundles Datatables
Route::post( 'bundles/bundles-datatable', 'Ajax\BundleController@index' );
Route::post( 'bundles/bundle-courses-datatable', 'Ajax\BundleController@show' );
Route::post( 'bundles/remaining-courses-datatable', 'Ajax\BundleController@remainingCourses' );

//! Dashboard Ajax Bundles CRUD
Route::delete( 'bundles/destroy/{ids}', 'Ajax\BundleController@destroy' );
Route::patch( 'bundles/bundles-toggle-status/{bundle}', 'Ajax\BundleController@update' );
Route::patch( 'bundles/add-courses', 'Ajax\BundleController@addCourses' );
Route::patch( 'bundles/remove-courses', 'Ajax\BundleController@removeCourses' );

//! Dashboard Ajax Materials
Route::post( 'materials/materials-datatable', 'Ajax\MaterialController@index' );
Route::post( 'materials/material-types', 'Ajax\MaterialController@materialTypes' );
Route::post( 'materials/add-additionnal-content', 'Ajax\MaterialController@addContent' );
Route::delete('/materials/multiple/delete', 'Ajax\MaterialController@destroyMultipleMaterials')->name("destroyMultipleMaterials.datatable");
Route::patch('/materials/multiple/add-material', 'Ajax\MaterialController@addMaterialMultiple')->name("addMaterialMultiple.datatable");
Route::patch('/materials/multiple/changeStatus', 'Ajax\MaterialController@changeStatusMultiple')->name("changeStatusMultipleMaterial.datatable");;
Route::patch( 'materials/toggle-active/{material}', 'Ajax\MaterialController@toggleActive' );



//! Dashboard Ajax Materials CRUD
Route::patch( 'materials/toggle-status/{material}', 'Ajax\MaterialController@toggleStatus' );

//! Dashboard Topics Datatables
Route::post( 'topics/topics-datatable', 'Ajax\TopicController@index' );

//! Ajax Upload Files
Route::post( 'materials/upload-description-images', 'Ajax\MaterialController@uploadDescImages' );
Route::post( 'materials/upload-content-images', 'Ajax\MaterialController@uploadContentImages' );

//!======================================================
//! 			End ajax Routes					|
//!======================================================


Auth::routes();



//!######################################################
//!					Index  Routes					#
//!######################################################

Route::get('/home', 'Index\HomeController@index')->name('home');

//! User routes
Route::get('/courses/{user}', 'Index\CourseController@show')->name("index.courses");
Route::get('/courses/course/{course}', 'Index\CourseController@userCourse')->name("index.userCourse");


//! partner routes link
Route::get("/user/link", "Index\HomeController@createLink")->name("user.link");
Route::post("/user/link/store", "Index\HomeController@createLinkStore")->name("user.linkStore");
Route::get("/user/view-link", "Index\HomeController@showLinks")->name("user.showLinks");
Route::get('/partner-links', function (Request $request) {
    if (! $request->hasValidSignature()) {
        abort(401);
    }
})->name('link');


//! Material routes link
//Route::get("/material/{materials}", "Index\MaterialController@globalShow")->name("index.material.global");
Route::get("/material/{course}/{materials}", "Index\MaterialController@show")->name("index.material.show");


//!######################################################
//!					END Index  Routes					#
//!######################################################


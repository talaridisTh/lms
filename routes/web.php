<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

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
Auth::routes();
//! 404
/*todo na gini 404 selida*/
Route::fallback(function () {
    return redirect(route("home"));
});
Route::get('/clear', function () {
    Artisan::call('cache:clear');

    return redirect(route("home"));
});
//!######################################################
//!					middleware				            #
Route::get("email/verify/{id}/{hash}", 'Auth\VerificationController@verify')->name("email.verify");
Route::get("auth/verify", 'Auth\VerificationController@show')->name("email.verify.show");
Route::post("send/email-verification", 'Auth\VerificationController@sendEmailVerification')->name("send.email.verification");
Route::get("/full-verification", function () {
    DB::table("users")->update([
        "email_verified_at" => Carbon::now()
    ]);
});

//!##################################
//! 		Dashboard routes		#
//!##################################
Route::group(['middleware' => ['auth', "status", "role:super-admin"]], function () {

	//! Dev Options Routes
    Route::get("/dashboard/dev-tools/template-config", "OptionController@templateConfig");
    Route::get("/dashboard/options", "OptionController@devIndex");
    Route::get("/dashboard/option/create-json", "OptionController@createJson");
    Route::post("/dashboard/option/store-json", "OptionController@storeJson");
    Route::post("/dashboard/option/store", "OptionController@store");
    Route::get("/dashboard/option/{option:id}/show-json", "OptionController@showJson");
    Route::patch("/dashboard/option/{option:id}/update-json", "OptionController@jsonUpdate");
    Route::patch("option/{option:id}/update", "Ajax\OptionController@update");
	Route::delete("option/{option:id}", "Ajax\OptionController@destroy");
	
	//! Options Datatable
    Route::post('options/main-datatable', 'Ajax\OptionController@mainDatatable');
});

Route::group(['middleware' => ['auth', "status", "role:admin|super-admin"]], function () {
	
	Route::get("/export/users/{ids}", "ExportController@actions")->name("export.actions");
	Route::get("/export/users-all", "ExportController@usersAll")->name("export.usersAll");
	Route::delete('/dashboard/users/{user}', 'UserController@destroy')->name('user.destroy');
	
	//! Topic Routes
	Route::get('/dashboard/topics', 'TopicController@index')->name('topic.index');
	Route::post('/dashboard/topics/store', 'TopicController@store')->name('topic.store');
	
	//! Dashboard Home Content
	Route::get('/dashboard/home-carousels', 'OptionController@showCarousels');
	Route::get('/dashboard/general-settings', 'OptionController@index');
	Route::post('/dashboard/general-settings/update', 'OptionController@update');
	Route::get('/dashboard/options/{slug}', 'OptionController@editPolicies')
		->where("slug", "terms-of-use|privacy-policy|cookie-policy");
	Route::post('/dashboard/options/{option}/update', 'OptionController@updatePolicies');

	//!########################################################
	//! AJAX routes
	//!########################################################
	//! Dashboard Ajax Users Datatables
	Route::post('users/view-users', 'Ajax\UserController@index');
	Route::post('users/view-user', 'Ajax\UserController@show');
	Route::post('user/add-course-modal', 'Ajax\UserController@addCourseModal');

	//! Dashboard Ajax Users CRUD
    Route::patch('/user/changeStatus', 'Ajax\UserController@changeStatus')->name("changeStatus.datatable");
    Route::patch('/user/multiple/changeStatus', 'Ajax\UserController@changeStatusMultiple');
    Route::patch('user/multiple/add-course', 'Ajax\UserController@addCoursesMultipleUsers');
    Route::delete('/user/multiple/users/delete', 'Ajax\UserController@destroyMultipleUsers');
	Route::post('/users/avatar/upload', 'Ajax\UserController@avatarUpload')->name('user.avatar.upload');
	
	//! Ajax  Home Page Setting Datatables
    Route::post('edit-carousels/simple-materials-datatable', 'Ajax\OptionController@simpleMaterialsDatatable');
    Route::post('edit-carousels/simple-courses-datatable', 'Ajax\OptionController@simpleCoursesDatatable');
	Route::post('edit-carousels/simple-bundles-datatable', 'Ajax\OptionController@simpleBundlesDatatable');
	
	//! Dashboard Home Banner Update
	Route::patch('edit-carousels/banners-update', 'Ajax\OptionController@updateBanners');
	
	//! Dashboard Global Search
	Route::post("dashboard-search", "Ajax\DashboardController@globalSearch");
});

Route::group(['middleware' => ['auth', "status", "role:instructor|admin|super-admin"]], function () {
	
	Route::get('/dashboard', 'DashboardController@index')->name("dashboard");

    Route::get("/dashboard/homeworks", "HomeworkController@index");
    Route::post("homeworks-datatable/main", "HomeworkController@indexDataTable");
	Route::get("homework-ajax/{homework:id}", "HomeworkController@homeworkContent");

    //! Mail Routes
    Route::get('/dashboard/email', 'MailController@composeEmail');
    Route::get('/dashboard/email', 'MailController@index');
    Route::get('/dashboard/email/compose/{mail:id?}', 'MailController@composeEmail');
    Route::get('/dashboard/email/{mail:id}', 'MailController@show');
    Route::post('/dashboard/email', 'MailController@sendNewsletter');
    Route::delete('/dashboard/email/{mail:id}/delete', 'MailController@delete');
    Route::post('email/select-users', 'Ajax\MailController@selectUsersDatatable');
    Route::post('email/recipients-data-table', 'Ajax\MailController@recipeintsDatatable');
    Route::post('email/data-table', 'Ajax\MailController@mailsDataTable');
	Route::post('email/delete', 'Ajax\MailController@delete');
	
    //! media Routes
	Route::get("/media", "MediaController@index")->name("media.index");
	
    //! Dashboard Search
	Route::get('/dashboard/search', 'DashboardController@dashboardSearch');

    
//!======================================================
//! 			End Dashboard Routes					|
//!======================================================

//!########################################################
//! AJAX routes
//!########################################################

//! Dashboard Ajax Media
    Route::get('/users/media/{mediaItem}/{size?}', 'MediaController@showMedia')->name('api.media.show');
    Route::post("file-details-store", "Ajax\MediaController@store")->name("file.details.store");
	Route::patch("media/remove-cover", "Ajax\MediaController@removeCover");

//! Select2 Ajax Search
    Route::get("courses/json-search", "Ajax\CourseController@courseSearch");
    Route::get("bundles/json-search", "Ajax\BundleController@bundleSearch");
	Route::get("topics/json-search", "Ajax\TopicController@topicSearch");

//! Dashboard Ajax Materials Datatables
    Route::post('materials/remaining-pdf-files', 'Ajax\MaterialController@remainingPDFFiles');
    Route::post('materials/material-types', 'Ajax\MaterialController@materialTypes');
    Route::post('materials/add-additionnal-content', 'Ajax\MaterialController@addContent');
    Route::patch('/materials/multiple/add-material', 'Ajax\MaterialController@addMaterialMultiple')->name("addMaterialMultiple.datatable");
	Route::patch('materials/toggle-active/{material}', 'Ajax\MaterialController@toggleActive');

//! Dashboard Ajax Materials CRUD
    Route::patch('materials/toggle-status/{material}', 'Ajax\MaterialController@toggleStatus');
    Route::delete('/materials/multiple/course/delete', 'Ajax\MaterialController@destroyMultipleCourse')->name("destroyMultipleCourse.datatable");
    Route::post('/materials/add-course', 'Ajax\MaterialController@addCourse');
    Route::post('/materials/cover/upload', 'Ajax\MaterialController@coverUpload')->name('user.cover.upload');
    Route::post('materials/gallery-upload', 'Ajax\MaterialController@galleryUpload')->name('user.gallery.upload');
    Route::patch('material/images-sort', 'Ajax\MaterialController@gallerySort');
    Route::patch("materials/edit-chapter/{material}", "Ajax\MaterialController@editChapter");
    Route::post("materials/add-materials", "Ajax\MaterialController@addMaterials");
    Route::patch('material/{material:id}/toggle-editors', 'Ajax\MaterialController@toggleEditors');
	Route::patch('material/{material:id}/change-pdf', 'Ajax\MaterialController@changePDF');

//! Dashboard Topics Datatables
    Route::post('topics/topics-datatable', 'Ajax\TopicController@index');
//! Dashboard Ajax Topic CRUD
    Route::patch('topics/update/{topic}', 'Ajax\TopicController@update');
    Route::delete('topics/destroy/{ids}', 'Ajax\TopicController@destroy');
	Route::patch('topics/change/color', 'Ajax\TopicController@changeColor');

//! Dashboard File Manager Datatable
    Route::post('/file-manager', 'Ajax\MediaController@fileManagerTable');
    Route::post('/file-manager/upload', 'Ajax\MediaController@generalUpload');
//! Dashboard Course - Materials Datatable
    Route::post('media/remaining-files', 'Ajax\MediaController@remainingFilesTable');
//! Dashboard File Manager
    Route::get('media/images', 'Ajax\MediaController@index');
//! Dashboard Gallery
    Route::post('media/gallery', 'Ajax\MediaController@addToGallery');
	Route::post('media/gallery-remove', 'Ajax\MediaController@removeFromGallery');

//! Ajax Upload Files
    // Route::post('materials/upload-description-images', 'Ajax\MaterialController@uploadDescImages');
    Route::post('media/upload-images', 'Ajax\MediaController@uploadImages');
    Route::post('media/files-upload', 'Ajax\MediaController@fileUpload');
    Route::post('media/pdf-upload', 'Ajax\MediaController@pdfUpload');
    Route::patch('media/cover/replace', 'Ajax\MediaController@coverChange');
    Route::post('media/add-files', 'Ajax\MediaController@addFiles');
    Route::post('media/remove-files', 'Ajax\MediaController@removeFiles');

	//!======================================================
	//! 			End ajax Routes					|
	//!======================================================
});


//! Glide Images
Route::get('img/{path}', 'MediaController@show')->where('path', '.*');

Route::get("/pf/{pass}/{name}", "Index\MediaController@show");
Route::get("/inactive", function () {
    return view("inactive");
});


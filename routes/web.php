<?php

use App\Models\Option;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
//!########################################################
//! 404
Route::fallback(function () {
    return redirect(route("home"));
});
//!########################################################
//! clear catch
Route::get('/clear', function () {
    Artisan::call('cache:clear');

    return redirect(route("home"));
});

Route::get("/delete/all-post",function (){
    dump( [App\Models\Post::all(),\App\Models\Comment::all(),\App\Models\Likable::all(),\App\Models\Media::all(),\App\Models\Mediable::all()]);
    DB::table("posts")->delete();
    DB::table("likables")->delete();

    dump( [App\Models\Post::all(),\App\Models\Comment::all(),\App\Models\Likable::all(),\App\Models\Media::all(),\App\Models\Mediable::all()]);

});


Route::get("/test", "Index\HomeController@test")->name("user.test");
//!########################################################
//! Dashboard routes
//!######################################################
//!					middleware				            #
Route::group(['middleware' => ['auth', "role:admin|super-admin"]], function () {

    Route::get('/dashboard', 'DashboardController@index')->name("dashboard");
    //! User Routes
    Route::get('/dashboard/users', 'UserController@index')->name('user.index');
    Route::get('/dashboard/users/create', 'UserController@create')->name('user.create');
    Route::get('/dashboard/users/{user}', 'UserController@show')->name('user.show');
    Route::post('/dashboard/users/create', 'UserController@store')->name('user.store');
    Route::patch('/dashboard/users/update/{user}', 'UserController@update')->name('user.update');
    Route::delete('/dashboard/users/{user}', 'UserController@destroy')->name('user.destroy');

	//! Newsletter Routes
	Route::get('/dashboard/email', 'MailController@composeEmail');

	//! Mail Routes
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
    //! Topic Routes
    Route::get('/dashboard/topics', 'TopicController@index')->name('topic.index');
    Route::post('/dashboard/topics/store', 'TopicController@store')->name('topic.store');
    //! Dashboard Search
    Route::get('/dashboard/search', 'DashboardController@dashboardSearch');
    //! Dashboard Home Content
    Route::get('/dashboard/home-carousels', 'OptionController@showCarousels');

    Route::get('/dashboard/general-settings', 'OptionController@index');
	Route::post('/dashboard/general-settings/update', 'OptionController@update');

	Route::get('/dashboard/options/{slug}', 'OptionController@editPolicies')
		->where("slug", "terms-of-use|privacy-policy|cookie-policy");
	Route::post('/dashboard/options/{option}/update', 'OptionController@updatePolicies');

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

//!======================================================
//! 			End Dashboard Routes					|
//!======================================================
//!########################################################
//! AJAX routes
//!########################################################
//! Dashboard Ajax Users Datatables
    Route::post('users/view-users', 'Ajax\UserController@index');
    Route::post('users/view-user', 'Ajax\UserController@show')->name("show.datatable");
    Route::post('/user/add-course-modal', 'Ajax\UserController@addCourseModal')->name("courseModal.datatable");
    Route::post('/user/sent-info', 'Ajax\UserController@sentInfo')->name("ajax.sentInfo");
//! Dashboard Ajax Users CRUD
    Route::patch('/user/add-course', 'Ajax\UserController@addCourses')->name("addcourses.datatable");
    Route::patch('/user/changeStatus', 'Ajax\UserController@changeStatus')->name("changeStatus.datatable");
    Route::patch('/user/multiple/changeStatus', 'Ajax\UserController@changeStatusMultiple');
    Route::patch('/user/multiple/add-course', 'Ajax\UserController@addCoursesMultipleUsers')->name("addCoursesMultipleUsers.datatable");
    Route::delete('/user/delete', 'Ajax\UserController@destroy')->name("destroy.datatable");
    Route::delete('/user/multiple/users/delete', 'Ajax\UserController@destroyMultipleUsers');
    Route::post("/user/show-password", "Ajax\UserController@showPassword")->name("showPassword");
    Route::post('/users/avatar/upload', 'Ajax\UserController@avatarUpload')->name('user.avatar.upload');
//! Dashboard Ajax Media
    Route::get('/users/media/{mediaItem}/{size?}', 'MediaController@showMedia')->name('api.media.show');
    Route::post("file-details-store", "Ajax\MediaController@store")->name("file.details.store");
    Route::patch("media/remove-cover", "Ajax\MediaController@removeCover");

//! Select2 Ajax Search
	Route::get("courses/json-search", "Ajax\CourseController@courseSearch");
	Route::get("bundles/json-search", "Ajax\BundleController@bundleSearch");

//! Dashboard Ajax Materials Datatables
    Route::post('materials/remaining-pdf-files', 'Ajax\MaterialController@remainingPDFFiles');

	//? courses
    Route::post('materials/material-types', 'Ajax\MaterialController@materialTypes');
	Route::post('materials/add-additionnal-content', 'Ajax\MaterialController@addContent');

	//? fail
    // Route::delete('/materials/multiple/delete', 'Ajax\MaterialController@destroyMultipleMaterials')->name("destroyMultipleMaterials.datatable");
	Route::patch('/materials/multiple/add-material', 'Ajax\MaterialController@addMaterialMultiple')->name("addMaterialMultiple.datatable");
    // Route::patch('/materials/multiple/changeStatus', 'Ajax\MaterialController@changeStatusMultiple')->name("changeStatusMultipleMaterial.datatable");;


	Route::patch('materials/toggle-active/{material}', 'Ajax\MaterialController@toggleActive');

//! Dashboard Ajax Materials CRUD
    Route::patch('materials/toggle-status/{material}', 'Ajax\MaterialController@toggleStatus');
    Route::delete('/materials/multiple/course/delete', 'Ajax\MaterialController@destroyMultipleCourse')->name("destroyMultipleCourse.datatable");
    // Route::post('/materials/add-course/', 'Ajax\MaterialController@addCourse');
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
//! Dashboard Global Search
    Route::post("dashboard-search", "Ajax\DashboardController@globalSearch");
//! Ajax Upload Files
    Route::post('materials/upload-description-images', 'Ajax\MaterialController@uploadDescImages');
    Route::post('media/upload-images', 'Ajax\MediaController@uploadImages');
    Route::post('media/files-upload', 'Ajax\MediaController@fileUpload');
    Route::post('media/pdf-upload', 'Ajax\MediaController@pdfUpload');
    Route::patch('media/cover/replace', 'Ajax\MediaController@coverChange');
    Route::post('media/add-files', 'Ajax\MediaController@addFiles');
    Route::post('media/remove-files', 'Ajax\MediaController@removeFiles');
//! Ajax  Home Page Setting Datatables
    Route::post('edit-carousels/simple-materials-datatable', 'Ajax\OptionController@simpleMaterialsDatatable');
    Route::post('edit-carousels/simple-courses-datatable', 'Ajax\OptionController@simpleCoursesDatatable');
    Route::post('edit-carousels/simple-bundles-datatable', 'Ajax\OptionController@simpleBundlesDatatable');
//! Dashboard Home Banner Update
	Route::patch('edit-carousels/banners-update', 'Ajax\OptionController@updateBanners');

//! Options Datatable
	Route::post('options/main-datatable', 'Ajax\OptionController@mainDatatable');

//! Glide Images
	Route::get('img/{path}', 'MediaController@show')->where('path', '.*');
//!======================================================
//! 			End ajax Routes					|
//!======================================================
//!######################################################
//!					Index  Routes					#
//!######################################################
});
//!######################################################
//!					middleware				            #
Route::group(['middleware' => ['auth']], function () {
    //home index
    Route::get('/home', 'Index\HomeController@index')->name('home');
    //excehl
    Route::get("/export/users/{ids}", "ExportController@actions")->name("export.actions");
    Route::get("/export/users-all", "ExportController@usersAll")->name("export.usersAll");
//user-profile index
    Route::get('/{user}/profile', 'Index\UserController@index')->name('index.profile');
    Route::patch('/{user}/profile/update', 'Index\UserController@update')->name('index.profile.update');
    Route::get('/{user}/profile/announcements', 'Index\UserController@ShowAnnouncements')->name('index.profile.announcements');
    Route::get('/{user}/profile/watchlist', 'Index\UserController@watchlist')->name('index.profile.watchlist');
    Route::get('/{user}/profile/history', 'Index\UserController@history')->name('index.profile.history');
// -----Datatable//Watchlist
    Route::post('/watchlist-datatable', 'Index\UserController@watchlistDatatable')->name("datatable.watchlist");
    Route::post('/watchlist-datatable/material', 'Index\UserController@watchlistMaterialDatatable')->name("datatable.watchlistMaterial");
    Route::post('/history-datatable', 'Index\UserController@historyDatatable')->name("datatable.history");
    Route::post('/history-datatable/material', 'Index\UserController@historyMaterialDatatable')->name("datatable.historyMaterial");

//! GUEST INDEX
    Route::get("/user/link", "Ajax\HomeController@createLink")->name("user.link");
    Route::post("/user/link/store", "Index\HomeController@createLinkStore")->name("user.linkStore");
    Route::get("/user/view-link", "Index\HomeController@showLinks")->name("user.showLinks");
    Route::get('/partner-links', function (Request $request) {
        if (!$request->hasValidSignature())
        {
            abort(401);
        }
    })->name('link');
});

//! GUEST AJAX
Route::post("/guest/course", "Ajax\HomeController@guestCourse")->name("guest.course");
Route::post("/guest/instructor", "Ajax\HomeController@guestInstructor")->name("guest.instructor");
Route::post("/guest/instructor-course", "Ajax\HomeController@guestInstructorCourse")->name("guest.instructorCourse");
Route::post("/guest/instructor-material", "Ajax\HomeController@guestInstructorMaterial")->name("guest.instructorMaterial");
Route::post("/guest/create/guest-user", "Ajax\HomeController@createGuestUser")->name("guest.createGuestUser");
Route::get("/guest/temp/link/{user}", "Ajax\HomeController@tempLink")->name("guest.tempLink");



Route::patch("/discussion/update/{id}", "Index\DiscussionController@editComment")->name("discussion.editComment");
//! discussion
Route::get("/discussion", "Index\DiscussionController@index")->name("discussion.index");
Route::get("/discussion/my-question", "Index\DiscussionController@myQuestion")->name("discussion.myQuestion");
Route::get("/discussion/participation", "Index\DiscussionController@participation")->name("discussion.participation");
Route::get("/discussion/best-answer", "Index\DiscussionController@bestAnswer")->name("discussion.bestAnswer");
Route::get("/discussion/popular-week", "Index\DiscussionController@popularWeek")->name("discussion.popularWeek");
Route::get("/discussion/popular-allTime", "Index\DiscussionController@popularAllTime")->name("discussion.popularAllTime");
Route::get("/discussion/isClosed", "Index\DiscussionController@isClosed")->name("discussion.isClosed");
Route::get("/discussion/no-replies", "Index\DiscussionController@noReplies")->name("discussion.noReplies");


Route::get("/discussion/{id}", "Index\DiscussionController@show")->name("discussion.show");
Route::post("/discussion/search", "Index\DiscussionController@search")->name("discussion.search");
Route::post("/discussion/post/store-thread", "Index\DiscussionController@storeThread")->name("discussion.thread");
Route::post("/discussion/post/store-reply", "Index\DiscussionController@storeReply")->name("discussion.reply");
Route::patch("/discussion/like-comment/{id}", "Index\DiscussionController@likeComment")->name("discussion.likeComment");
Route::delete("/discussion/delete/{id}", "Index\DiscussionController@delete")->name("discussion.delete");
Route::patch("/discussion/best/{id}", "Index\DiscussionController@best")->name("discussion.best");
Route::patch("/discussion/closed/{id}", "Index\DiscussionController@closed")->name("discussion.closed");
Route::post("/discussion/comment/upload", "Index\DiscussionController@commentUpload")->name("discussion.commentUpload");
//Route::post("/pagination", "Index\DiscussionController@pagination")->name("discussion.pagination");



//!######################################################
//!					middleware				            #
Route::group(['middleware' => ["auth", "verifyCourse"]], function () {
    Route::get('/courses/{user}', 'Index\CourseController@show')->name("index.courses")->withoutMiddleware(['verifyCourse']);
//! Course
    Route::post('/model/comment', 'Index\CourseController@modelComment')->name("index.modelComment")->withoutMiddleware(['verifyCourse']);
    Route::get('/courses/course/{course}', 'Index\CourseController@userCourse')->name("index.userCourse");
    Route::post("/model/delete", "Index\CourseController@deleteComment")->name("index.deleteComment")->withoutMiddleware(['verifyCourse']);
    Route::patch("/model/update/{id}", "Index\CourseController@editComment")->name("index.editComment")->withoutMiddleware(['verifyCourse']);

//! Material index  ajax
    Route::patch('/add-watchlist/course', 'Index\CourseController@watchlistCourse')->name('index.watchlist.course');
    //! Material index
    Route::get("/material/{course}/{materials}", "Index\MaterialController@show")->name("index.material.show");
    Route::get("/dummy-course/{materials}", "Index\MaterialController@dummyPage")->name("dummyPage.material.show");
//! Material index  ajax
    Route::patch('/add-watchlist/material', 'Index\MaterialController@watchlistMaterial')->name('index.watchlist.material');
    Route::patch('/add-witchlist/material', 'Index\MaterialController@addWitchlist');
});




//!######################################################
//!					END Index  Routes					#
//!######################################################


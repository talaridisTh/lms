<?php

use Illuminate\Http\Request;
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
    //! Material Routes
    Route::get('/dashboard/materials', 'MaterialController@index')->name('material.index');
    Route::get('/dashboard/materials/create/{course?}/{priority?}/{material:id?}', 'MaterialController@create');
    Route::get('/dashboard/material/{material?}', 'MaterialController@show')->name('material.show');
    Route::post('/dashboard/materials/store', 'MaterialController@store')->name('material.store');
    Route::patch('/dashboard/materials/update/{material:slug}', 'MaterialController@update')->name('material.update');
    Route::delete('/dashboard/materials/delete/{material}', 'MaterialController@destroy')->name('material.destroy');
	Route::get('/dashboard/create-pdf/{course?}/{priority?}/{material?}', 'MaterialController@createPDF');
	Route::post('/dashboard/store-pdf-material', 'MaterialController@storePDF');
	Route::get('/dashboard/edit-pdf/{material}', 'MaterialController@editPDF');

    //! Course Routes
    Route::get('/dashboard/courses', 'CourseController@index')->name('course.index');
    Route::get('/dashboard/course/{course?}', 'CourseController@show')->name('course.show');
    Route::get('/dashboard/courses/create', 'CourseController@create')->name('course.create');
    Route::post('/dashboard/courses/store', 'CourseController@store')->name('course.store');
    Route::post('/dashboard/courses/clone', 'CourseController@clone')->name('course.clone');
    Route::patch('/dashboard/courses/update/{course}', 'CourseController@update')->name('course.update');
    Route::delete('/dashboard/course/{course}', 'CourseController@softDelete')->name('course.softDelete');
    //! Bundle Routes
    Route::get('/dashboard/bundles', 'BundleController@index')->name('bundle.index');
    Route::get('/dashboard/bundles/create', 'BundleController@create')->name('bundle.create');
    Route::get('/dashboard/bundle/{bundle?}', 'BundleController@show')->name('bundle.show');
    Route::post('/dashboard/bundle/store', 'BundleController@store')->name('bundle.store');
    Route::patch('/dashboard/bundle/update/{bundle}', 'BundleController@update')->name('bundle.update');
    Route::delete('/dashboard/bundle/{bundle}', 'BundleController@softDelete')->name('bundle.softDelete');

	//! Newsletter Routes
	Route::get('/dashboard/email', 'MailController@composeEmail');

	//! Mail Routes
	Route::get('/dashboard/email', 'MailController@index');
	Route::get('/dashboard/email/compose', 'MailController@composeEmail');
	Route::post('/dashboard/email', 'MailController@sendNewsletter');
	Route::get('email/users', 'MailController@searchUsers');
	Route::post('email/data-table', 'MailController@mailsTable');

	//! media Routes
    Route::get("/media", "MediaController@index")->name("media.index");
    //! Topic Routes
    Route::get('/dashboard/topics', 'TopicController@index')->name('topic.index');
    Route::post('/dashboard/topics/store', 'TopicController@store')->name('topic.store');
    //! Dashboard Search
    Route::get('/dashboard/search', 'DashboardController@dashboardSearch');
    //! Dashboard Home Content
    Route::get('/dashboard/home-carousels', 'OptionCont`roller@showCarousels');

    Route::get('/dashboard/general-settings', 'OptionController@index');
	Route::post('/dashboard/general-settings/update', 'OptionController@update');

	Route::get('/dashboard/options/{slug}', 'OptionController@editPolicies')
		->where("slug", "terms-of-use|privacy-policy|cookie-policy");
	Route::post('/dashboard/options/{option:name}/update', 'OptionController@updatePolicies');

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
    Route::post('users/view-users', 'Ajax\UserController@index')->name("index.datatable");
    Route::post('users/view-user', 'Ajax\UserController@show')->name("show.datatable");
    Route::post('/user/add-course-modal', 'Ajax\UserController@addCourseModal')->name("courseModal.datatable");
    Route::post('/user/courses-inside-users', 'Ajax\UserController@coursesInsideUsers')->name("coursesInsideUsers.datatable");
    Route::post('/user/sent-info', 'Ajax\UserController@sentInfo')->name("ajax.sentInfo");
//! Dashboard Ajax Users CRUD
    Route::patch('/user/add-course', 'Ajax\UserController@addCourses')->name("addcourses.datatable");
    Route::patch('/user/changeStatus', 'Ajax\UserController@changeStatus')->name("changeStatus.datatable");;
    Route::patch('/user/multiple/changeStatus', 'Ajax\UserController@changeStatusMultiple')->name("changeStatusMultiple.datatable");;
    Route::patch('/user/multiple/add-course', 'Ajax\UserController@addCoursesMultipleUsers')->name("addCoursesMultipleUsers.datatable");
    Route::patch('/user/multiple/add-user', 'Ajax\UserController@AddMultipleUserCourse')->name("AddMultipleUserCourse.datatable");
    Route::delete('/user/delete', 'Ajax\UserController@destroy')->name("destroy.datatable");
    Route::delete('/user/multiple/courses/delete', 'Ajax\UserController@destroyMultipleCourses')->name("destroyMultipleCourses.datatable");
    Route::delete('/user/multiple/users/delete', 'Ajax\UserController@destroyMultipleUsers')->name("destroyMultipleUsers.datatable");
    Route::post("/user/show-password", "Ajax\UserController@showPassword")->name("showPassword");
    Route::post('/users/avatar/upload', 'Ajax\UserController@avatarUpload')->name('user.avatar.upload');
//! Dashboard Ajax Media
    Route::get('/users/media/{mediaItem}/{size?}', 'MediaController@showMedia')->name('api.media.show');
    Route::post("file-details-store", "Ajax\MediaController@store")->name("file.details.store");
    Route::patch("media/remove-cover", "Ajax\MediaController@removeCover");
//! Dashboard Ajax Courses Datatables
    Route::post('courses/courses-datatable', 'Ajax\CourseController@index');
    Route::post('courses/course-materials-datatable', 'Ajax\CourseController@courseMaterials');
    Route::post('courses/not-incourse-materials-datatable', 'Ajax\CourseController@remainingMaterials');
    Route::post('courses/course-users-datatable', 'Ajax\CourseController@courseUsers');
    Route::post('courses/add-course-students-datatable', 'Ajax\CourseController@addCourseStudents');
//! Dashboard Ajax Courses CRUD
    Route::delete('courses/destroy/{ids}', 'Ajax\CourseController@destroy');
    Route::patch('courses/status', 'Ajax\CourseController@toggleStatus');
    Route::patch('courses/priority', 'Ajax\CourseController@changePriority');
    Route::patch('courses/toggle-materials', 'Ajax\CourseController@toggleCourseMaterials');
    Route::post('courses/add-materials', 'Ajax\CourseController@addMaterials');
    Route::patch('courses/remove-materials', 'Ajax\CourseController@removeMaterials');
    Route::patch('courses/add-students', 'Ajax\CourseController@addStudents');
    Route::patch('courses/remove-students', 'Ajax\CourseController@removeStudents');
    Route::patch('course/{course}/toggle-editors', 'Ajax\CourseController@toggleEditors');
    Route::patch('course/{course:id}/toggle-highlight', 'Ajax\CourseController@toggleHighlight');
//! Dashboard Ajax Bundles Datatables
    Route::post('bundles/bundles-datatable', 'Ajax\BundleController@index');
    Route::post('bundles/bundle-courses-datatable', 'Ajax\BundleController@show');
    Route::post('bundles/bundle-users-datatable', 'Ajax\BundleController@bundleUsers');
    Route::post('bundles/remaining-courses-datatable', 'Ajax\BundleController@remainingCourses');
    Route::post('bundles/remaining-users-datatable', 'Ajax\BundleController@remainingUsers');
//! Dashboard Ajax Bundles CRUD
    Route::delete('bundles/destroy/{ids}', 'Ajax\BundleController@destroy');
    Route::patch('bundles/status', 'Ajax\BundleController@toggleStatus');
    Route::patch('bundles/add-courses', 'Ajax\BundleController@addCourses');
    Route::patch('bundles/remove-courses', 'Ajax\BundleController@removeCourses');
    Route::post('bundles/remove-users', 'Ajax\BundleController@removeUsers');
    Route::post('bundles/add-users', 'Ajax\BundleController@addUsers');
    Route::patch('bundle/{bundle}/toggle-editors', 'Ajax\BundleController@toggleEditors');
//! Dashboard Ajax Materials Datatables
    Route::post('materials/materials-datatable', 'Ajax\MaterialController@index');
    Route::post('materials/materials-course-datatable', 'Ajax\MaterialController@indexCourse')->name("material-courses-datatable");
    Route::post('materials/add-course-inside-material', 'Ajax\MaterialController@addCourseMaterial')->name("add-course-material-datatable");
    Route::post('materials/remaining-pdf-files', 'Ajax\MaterialController@remainingPDFFiles');

//! Dashboard Ajax Bundles CRUD
    Route::post('materials/material-types', 'Ajax\MaterialController@materialTypes');
    Route::post('materials/add-additionnal-content', 'Ajax\MaterialController@addContent');
    Route::delete('/materials/multiple/delete', 'Ajax\MaterialController@destroyMultipleMaterials')->name("destroyMultipleMaterials.datatable");
    Route::patch('/materials/multiple/add-material', 'Ajax\MaterialController@addMaterialMultiple')->name("addMaterialMultiple.datatable");
    Route::patch('/materials/multiple/changeStatus', 'Ajax\MaterialController@changeStatusMultiple')->name("changeStatusMultipleMaterial.datatable");;
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
    Route::post("section/remove-chapters", "Ajax\MaterialController@removeChapters");
    Route::patch("section/toggle-chapters", "Ajax\MaterialController@toggleChapters");
    Route::patch("section/toggle-hightlight/{material:id}", "Ajax\MaterialController@toggleHighlight");
    Route::patch("section/chapters-priority", "Ajax\MaterialController@chaptersPriority");
    Route::post("section/add-content", "Ajax\MaterialController@addSectionContent");
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



//! discussion
Route::get("/discussion", "Index\DiscussionController@index")->name("discussion.index");
Route::get("/discussion/{id}", "Index\DiscussionController@show")->name("discussion.show");
Route::post("/discussion/search", "Index\DiscussionController@search")->name("discussion.search");

Route::post("/discussion/post/store-thread", "Index\DiscussionController@storeThread")->name("discussion.thread");
Route::post("/discussion/post/store-reply", "Index\DiscussionController@storeReply")->name("discussion.reply");
Route::get("/discussion/change/filter-sidebar", "Index\DiscussionController@filterSidebar")->name("discussion.filterSidebar");
Route::get("/discussion/change/filter-course", "Index\DiscussionController@filterCourse")->name("discussion.filterCourse");
Route::patch("/discussion/like-comment/{id}", "Index\DiscussionController@likeComment")->name("discussion.likeComment");
Route::delete("/discussion/delete/{id}", "Index\DiscussionController@delete")->name("discussion.delete");
Route::patch("/discussion/best/{id}", "Index\DiscussionController@best")->name("discussion.best");
Route::patch("/discussion/closed/{id}", "Index\DiscussionController@closed")->name("discussion.closed");

//Route::post("/pagination", "Index\DiscussionController@pagination")->name("discussion.pagination");



//!######################################################
//!					middleware				            #
Route::group(['middleware' => ["auth", "verifyCourse"]], function () {
    Route::get('/courses/{user}', 'Index\CourseController@show')->name("index.courses")->withoutMiddleware(['verifyCourse']);
//! Course
    Route::get('/courses/course/{course}', 'Index\CourseController@userCourse')->name("index.userCourse");
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


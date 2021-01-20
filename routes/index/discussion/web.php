<?php
//! discussion
use App\Http\Controllers\Index\CourseController;
use App\Http\Controllers\Index\DiscussionController;
use Illuminate\Support\Facades\Route;

Route::prefix("discussion")->name("discussion.")->group(function () {
    Route::get("/", [DiscussionController::class, "index"])->name("index");
    Route::patch("/update/{id}", [DiscussionController::class, 'editComment'])->name("editComment");
    Route::get("/my-question", [DiscussionController::class, 'myQuestion'])->name("myQuestion");
    Route::get("/participation", [DiscussionController::class, 'participation'])->name("participation");
    Route::get("/best-answer", [DiscussionController::class, 'bestAnswer'])->name("bestAnswer");
    Route::get("/popular-week", [DiscussionController::class, 'popularWeek'])->name("popularWeek");
    Route::get("/popular-allTime", [DiscussionController::class, 'popularAllTime'])->name("popularAllTime");
    Route::get("/isClosed", [DiscussionController::class, 'isClosed'])->name("isClosed");
    Route::get("/no-replies", [DiscussionController::class, 'noReplies'])->name("noReplies");
    Route::get("/my-task", [DiscussionController::class, 'myTask'])->name("myTask");
    Route::get("/my-announcement", [DiscussionController::class, 'myAnnouncement'])->name("myAnnouncement");
    Route::patch("/complete-task/{id}", [DiscussionController::class, 'completeTask'])->name("completeTask");
    Route::delete("/delete-task/{id}", [DiscussionController::class, 'deleteTask'])->name("deleteTask");
    Route::get("/{id}", [DiscussionController::class, 'show'])->name("show");
    Route::post("/search", [DiscussionController::class, 'search'])->name("search");
    Route::post("/post/store-thread", [DiscussionController::class, 'storeThread'])->name("thread");
    Route::post("/post/store-reply", [DiscussionController::class, 'storeReply'])->name("reply");
    Route::patch("/like-comment/{id}", [DiscussionController::class, 'likeComment'])->name("likeComment");
    Route::delete("/delete/{id}", [DiscussionController::class, 'delete'])->name("delete");
    Route::patch("/best/{id}", [DiscussionController::class, 'best'])->name("best");
    Route::patch("/closed/{id}", [DiscussionController::class, 'closed'])->name("closed");
    Route::post("/comment/upload", [DiscussionController::class, 'commentUpload'])->name("commentUpload");
    Route::post("/task/send", [DiscussionController::class, 'sendTask'])->name("sendTask");
    Route::post("/upload-task", [DiscussionController::class, 'uploadTask'])->name("uploadTask");
    Route::post("/question/post", [DiscussionController::class, 'createQuestionPost'])->name("createQuestionPost");
    Route::get("/courses/json-search", [DiscussionController::class, 'courseSearchSelect']);
    Route::get("/users/json-search", [DiscussionController::class, 'userSearchSelect']);

//Route::post("/pagination", [DiscussionController::class,'pagination'])->name("pagination");
});
/*note global route form comments*/
Route::prefix("model")->name("index.")->group(function () {

//    Route::get('/courses/course/{course}', 'Index\CourseController@userCourse')->name("index.userCourse")->withoutMiddleware(['verifyCourse']);
    Route::post('comment', [CourseController::class, 'modelComment'])->name("modelComment")->withoutMiddleware(['verifyCourse']);
    Route::post("delete", [CourseController::class, 'deleteComment'])->name("deleteComment")->withoutMiddleware(['verifyCourse']);
    Route::patch("update/{id}", [CourseController::class, 'editComment'])->name("editComment")->withoutMiddleware(['verifyCourse']);
    Route::post("delete/image/{id}", [CourseController::class, 'deletePhotoOnComment'])->name("deletePhotoOnComment")->withoutMiddleware(['verifyCourse']);

});

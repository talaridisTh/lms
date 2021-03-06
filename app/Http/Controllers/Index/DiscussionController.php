<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use App\Mail\EmailTask;
use App\Models\Attachment;
use App\Models\Comment;
use App\Models\Course;
use App\Models\Homework;
use App\Models\Post;
use App\Models\User;
use App\Notifications\NewAnnouncementNorification;
use App\Traits\IconFinder;
use App\Traits\MediaUploader;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DiscussionController extends Controller {

    use MediaUploader, IconFinder;

    private $allowedTypes = [
        "application/octet-stream", "application/x-zip-compressed", "application/pdf",
        "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
        "application/vnd.openxmlformats-officedocument.wordprocessingml.template", "application/vnd.ms-word.document.macroEnabled.12",
        "application/vnd.ms-word.template.macroEnabled.12", "application/vnd.ms-excel", "application/vnd.ms-excel", "application/vnd.ms-excel",
        "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "application/vnd.openxmlformats-officedocument.spreadsheetml.template",
        "application/vnd.ms-excel.sheet.macroEnabled.12", "application/vnd.ms-excel.template.macroEnabled.12",
        "application/vnd.ms-excel.addin.macroEnabled.12", "application/vnd.ms-excel.sheet.binary.macroEnabled.12",
        "application/vnd.ms-powerpoint", "application/vnd.openxmlformats-officedocument.presentationml.presentation",
        "application/vnd.openxmlformats-officedocument.presentationml.template", "application/vnd.openxmlformats-officedocument.presentationml.slideshow",
        "application/vnd.ms-powerpoint.addin.macroEnabled.12", "application/vnd.ms-powerpoint.presentation.macroEnabled.12",
        "application/vnd.ms-powerpoint.template.macroEnabled.12", "application/vnd.ms-powerpoint.slideshow.macroEnabled.12",
        "application/vnd.ms-access", "audio/mpeg", "application/vnd.oasis.opendocument.presentation",
        "application/vnd.oasis.opendocument.spreadsheet", "application/vnd.oasis.opendocument.text",
        "application/rtf", "application/vnd.oasis.opendocument.graphics", "text/html", "image/png",
        "image/jpeg"
    ];
    //
    private $course;

    public function __construct()
    {
        $this->course = $courses = Course::orderBy('title')->get()->map(function ($post) {
            return $post->title;
        });
    }

    public function index(Request $request)
    {
//        dd(auth()->user()->getAnnouncementCourse());
        $posts = auth()->user()->getPosts();
        //            ->orderBy('created_at', $request->option ? $request->option : "desc")
//
//        $posts = Post::orderBy('created_at', $request->option ? $request->option : "desc")
//            ->paginate(10);
//        dd(url()->full());
        return view("index.discussions.discussions", [
            "posts" => $posts,
            "comment" => Comment::all(),
            "courses" => $this->course
        ]);
    }

    public function show($post, Request $request)
    {
        $post = $request->namespace::findOrFail($post);

        return view("components.index.discussions.discussions-post", [
            "post" => $post,
            "comment" => Comment::all(),
            "courses" => $this->course
        ]);
    }

    public function delete($id, Request $request)
    {

        Comment::where("parent_id", $id)->get()->each(function ($comment) {
            $comment->delete();
        });
        Comment::findOrFail($id)->delete();
        $post = $request->namespace::findOrFail($request->postId);

        return view("components.index.discussions.discussions-post", [
            "post" => $post,
            "comment" => Comment::all(),
            "courses" => $this->course
        ]);
    }

    public function search(Request $request)
    {
        $posts = Post::whereHas("user", function ($course) {
            $course->whereIn("posts.postable_id", auth()->user()->courses->pluck("id"));
        })->where('title', 'LIKE', '%' . $request->term . '%')->where("postable_type", '!=', "App\Models\Attachment")->paginate(10);

//        Post::where('title', 'LIKE', '%' . $request->term . '%')->paginate(10)
        return view("index.discussions.discussions", [
            "posts" => $posts,
            "comment" => Comment::all(),
            "courses" => $this->course
        ]);
        //edw emeina sinexizw me ta post refacto na t blepeo mono o user
    }

    public function storeThread(Request $request)
    {

        $request->validate([
            "title" => "required",
            "course" => "required",
        ]);
        Post::create([
            "title" => $request->title,
            "slug" => Str::slug($request->title, "-"),
            "user_id" => auth()->id(),
            "postable_type" => "App\Models\Course",
            "postable_id" => Course::where("title", $request->course)->first()->id
        ]);
        $posts = Post::orderBy('created_at', $request->option ? $request->option : "desc")
            ->paginate(10);

        return view("index.discussions.discussions", [
            "posts" => $posts,
            "comment" => Comment::all(),
            "courses" => $this->course
        ]);
    }

    public function storeReply(Request $request)
    {

        $post = $request->namespace::findOrFail($request->postId);
        if (get_class($post) == "App\Models\Comment") {
            $post = $post->announcement;
        }
        $request->validate([
            "body" => "required",
        ]);
        $post->comments()->create([
            "body" => $request->body,
            "user_id" => auth()->id(),
            "parent_id" => $request->parentId
        ]);

        return view("components.index.discussions.discussions-post", [
            "post" => $post,
            "comment" => Comment::all(),
            "courses" => $this->course
        ]);
    }

    public function myQuestion(Request $request)
    {

        $posts = auth()->user()->posts()
            ->orderBy('created_at', $request->option ? $request->option : "desc")
            ->where("postable_type", '!=', "App\Models\Attachment")
            ->paginate(10);

        return view("index.discussions.discussions", [
            "posts" => $posts,
            "comment" => Comment::all(),
            "courses" => $this->course
        ]);
    }

    public function participation(Request $request)
    {

        $posts = Post::whereIn('id', function ($query) {

            $query->select('post_id')
                ->from('comments')
                ->where("user_id", auth()->id())
                ->get();
        })->orderBy('created_at', $request->option ? $request->option : "desc")->where("postable_type", '!=', "App\Models\Attachment")->paginate(10);

        return view("index.discussions.discussions", [
            "posts" => $posts,
            "comment" => Comment::all(),
            "courses" => $this->course
        ]);
    }

    public function bestAnswer(Request $request)
    {

        $posts = Post::whereIn('id', function ($query) {

            $query->select('post_id')
                ->from('comments')
                ->where("user_id", auth()->id())
                ->where("best", 1)
                ->get();
        })->orderBy('created_at', $request->option ? $request->option : "desc")
            ->where("postable_type", '!=', "App\Models\Attachment")
            ->paginate(10);

        return view("index.discussions.discussions", [
            "posts" => $posts,
            "comment" => Comment::all(),
            "courses" => $this->course
        ]);
    }

    public function popularWeek(Request $request)
    {

        $posts = Post::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->orderBy("watched", "desc")
            ->where("postable_type", '!=', "App\Models\Attachment")
            ->paginate(10);

        return view("index.discussions.discussions", [
            "posts" => $posts,
            "comment" => Comment::all(),
            "courses" => $this->course
        ]);
    }

    public function popularAllTime(Request $request)
    {

        $posts = Post::whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])
            ->orderBy("watched", "desc")
            ->where("postable_type", '!=', "App\Models\Attachment")
            ->paginate(10);

        return view("index.discussions.discussions", [
            "posts" => $posts,
            "comment" => Comment::all(),
            "courses" => $this->course
        ]);
    }

    public function isClosed(Request $request)
    {

        $posts = Post::where("closed", 1)
            ->orderBy('created_at', $request->option ? $request->option : "desc")
            ->where("postable_type", '!=', "App\Models\Attachment")
            ->paginate(10);

        return view("index.discussions.discussions", [
            "posts" => $posts,
            "comment" => Comment::all(),
            "courses" => $this->course
        ]);
    }

    public function noReplies(Request $request)
    {

        $posts = Post::whereNotIn('id', function ($query) {

            $query->select('posts.id')
                ->from('posts')
                ->join('comments', 'comments.post_id', '=', 'posts.id')
                ->where("post_id", "!=", null)
                ->get();
        })->orderBy('created_at', $request->option ? $request->option : "desc")
            ->where("postable_type", '!=', "App\Models\Attachment")
            ->paginate(10);

        return view("index.discussions.discussions", [
            "posts" => $posts,
            "comment" => Comment::all(),
            "courses" => $this->course
        ]);
    }

    public function likeComment($commentId)
    {

        $comment = Comment::findOrFail($commentId);
        if (auth()->user()->commentIsLiked($comment)) {
            auth()->user()->likeComment()->detach($comment);
        } else {
            auth()->user()->likeComment()->attach($comment);
        }

        return response()->json(!auth()->user()->commentIsLiked($comment));
    }

    public function best($commentId, Request $request)
    {
        $best = Comment::findOrFail($commentId)->best;
        Comment::where("post_id", $request->postId)->update(["best" => 0]);
        Comment::findOrFail($commentId)->update(["best" => !$best]);
    }

    public function closed($postId, Request $request)
    {

        $closed = Post::findOrFail($postId)->closed;
        Post::findOrFail($postId)->update(["closed" => !$closed]);
    }

    public function commentUpload(Request $request)
    {
        $this->storeImage($request->filepond, 5);
    }

    public function editComment($commentId, Request $request)
    {

        Comment::find($commentId)->update([
            "body" => $request->editBody
        ]);

        return view("components.index.discussions.discussions-post", [
            "post" => $request->namespace::find($request->postId),
            "comment" => Comment::all(),
            "courses" => $this->course
        ]);
    }

    public function completeTask($task)
    {
        $attachments = Attachment::find($task);
        if ($attachments->completed_at) {
            $attachments->update(["completed_at" => null]);
        } else {

            $attachments->update(["completed_at" => now()]);
        }

        return response()->json(["completed_at" => $attachments->completed_at]);
    }

    public function deleteTask($taskId)
    {

        $countAttach = Attachment::where("attachmentable_id", Attachment::findOrFail($taskId)->attachmentable_id)->count();
        if ($countAttach == 1) {
            Homework::where("id", Attachment::findOrFail($taskId)->attachmentable->id)->delete();
        }
        Attachment::findOrFail($taskId)->delete();
        Attachment::where("attachmentable_id", 0)->delete();

        return $this->myTask();
    }

    public function myTask()
    {

        return view("components.index.discussions.discussions-task", [
            "courses" => auth()->user()->courses()->whereHas("homeworks")->with("homeworks")->get()
        ]);
    }

    public function sendTask(Request $request)
    {
        $mailInfo = new \stdClass();
        $mailInfo->subject = $request->subject;
        $mailInfo->body = $request->body;
        $mailInfo->sender = auth()->user();
        $mailInfo->receiver = User::findOrFail($request->curator);
        $mailInfo->course = Course::where("title", $request->course)->first();
        $mailInfo->attachment = $request->attachment;
        $homework = $this->storeHomework($mailInfo);
        if (isset($request->dropzone)) {
            $ids = $this->uploadTask($request);

        }
        Mail::to(auth()->user()->email)->send(new EmailTask($mailInfo, $homework, isset($ids->original) ? $ids->original : null));

        return $this->myTask();
    }

    private function storeHomework($mail)
    {

        $homework = Homework::create([
            'student_id' => auth()->id(),
            'subject' => $mail->subject,
            'content' => $mail->body ?? auth()->user()->fullname,
            'sent_at' => now()
        ]);
        if (isset($mail->attachment)) {

            Homework::find($homework->id)->update([
                "course_id" => $mail->course->id
            ]);

        }

        return $homework;
    }

    public function uploadTask(Request $request)
    {
        $res = [];
        $files = isset($request->file) ? $request->file : $request->attachment;
        $allowedTypes = array_diff($this->allowedTypes, ["image/png", "image/jpeg"]);
        foreach ($files as $key => $file) {
            if ($file->isValid()) {
                if (in_array($file->getClientMimeType(), $allowedTypes)) {
                    if ($file->getSize() <= 50000000) { // 50MB
                        $media = $this->storeFile($file);
//                        auth()->user()->media()->attach($media->id, ["usage" => 6]);
                        $res["file-" . $key] = [
                            "url" => $media->rel_path,
                            "name" => $media->original_name . "." . $media->ext,
                            "id" => $media->id,
                        ];
                    }

                }
            }
        }

        return response()->json($res);
    }

    private function storeFile($file)
    {

        $date = date('Y.m');
        $name = $this->fileName($file);
        $attachment = new Attachment();
        $attachment->original_name = $name->original;
        $attachment->name = $name->slug;
        $attachment->type = 6;
        $attachment->rel_path = "/storage/attachments/$date/$name->full";
        $attachment->ext = $file->getClientOriginalExtension();
        $attachment->file_info = $file->getClientMimeType();
        $attachment->size = $file->getSize();
        $attachment->save();
        $file->storeAs("public/attachments/$date", $name->full);

        return $attachment;
    }

    public function courseSearchSelect(Request $request)
    {
        $courses = auth()->user()->courses()->where("title", "LIKE", "%$request->search%")
            ->select("courses.id", "title")->paginate(10);
        $result = [];
        $result["results"] = [];
        foreach ($courses as $key => $course) {
            if ($courses->currentPage() === 1 && $key === 0) {

                array_push($result['results'], [
                    "id" => " ",
                    "text" => "Όλα τα μαθήματα"
                ]);
            }
            array_push($result['results'], [
                "id" => $course->title,
                "text" => $course->title
            ]);
        }
        $result["pagination"] = [
            "more" => $courses->currentPage() !== $courses->lastPage()
        ];
        echo json_encode($result);
    }

    public function userSearchSelect(Request $request)
    {
        $userAll = auth()->user()->whereHas("courses", function ($course) {
            $course->whereIn("courses.id", auth()->user()->courses()->get()->pluck("id")->unique("slug"));
        });
        $users = $userAll->where("first_name", "LIKE", "%$request->search%")
            ->select("id", "first_name", "email", "last_name")->paginate(10);
        $result = [];
        $result["results"] = [];
        foreach ($users as $key => $user) {
            if ($users->currentPage() === 1 && $key === 0) {

                array_push($result['results'], [
                    "id" => " ",
                    "text" => "Όλοι οι μαθητές"
                ]);
            }
            array_push($result['results'], [
                "id" => $user->id,
                "text" => $user->fullName
            ]);
        }
        $result["pagination"] = [
            "more" => $users->currentPage() !== $users->lastPage()
        ];
        echo json_encode($result);

    }

    public function uploadAnnouncement(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title" => "required",
            "body" => "required",
            "users" => "required_if:courses,null",
            "courses" => "required_if:users,null",
        ]);
        if ($validator->fails()) {
            return redirect('/discussion/my-announcement')->withErrors($validator);

        }
        if ($request->courses) {
            $course = Course::where("title", $request->courses)->first();
            $announcement = $course->announcement()->create([
                "title" => $request->title,
                "description" => $request->body,
                "status" => 1,
                "slug" => Str::slug($request->title, "-")
            ]);
            $announcement->comments()->create([
                'user_id' => auth()->id(),
                "parent_id" => 0,
                "body" => $request->body,
            ]);
            foreach ($course->users as $user) {
                $user->notify(new NewAnnouncementNorification);
            }

        } elseif ($request->users) {
            foreach ($request->users as $userId) {
                $user = User::findOrFail($userId);
                $announcement = $user->announcement()->create([
                    "title" => $request->title,
                    "description" => $request->body,
                    "status" => 1,
                    "slug" => Str::slug($request->title, "-")
                ]);
                $announcement->comments()->create([
                    'user_id' => auth()->id(),
                    "parent_id" => 0,
                    "body" => $request->body,
                ]);
            }

        }

        return $this->myAnnouncement();
    }

    public function myAnnouncement()
    {

        $user = auth()->user();
        $userRole = $user->getRoleNames()[0];
//        $postsStudent = auth()->user()->courses()->with("announcement.comments")->get()->pluck("announcement.*.comments.*")->collapse();
        $postsStudent = $user->courses()->with("announcement.comments")->get()->pluck("announcement")->collapse();

        return view("components.index.discussions.discussions-announcement", [
            "posts" => $userRole == "student" ? $postsStudent->merge($user->announcement) : $postsStudent->merge($user->announcement),
            "policiesRoles" => ["super-admin", "admin", "instructor"],
            'courses' => $user->courses,
            'users' => $user->courses()->with("users")->get()->pluck("users")->collapse()->unique("id")
        ]);

    }

}

<?php

namespace App\Http\Controllers\Index;

use App\Mail\EmailTask;
use App\Models\Attachment;
use App\Models\Comment;
use App\Models\Course;
use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Post;
use App\Models\User;
use App\Traits\MediaUploader;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class DiscussionController extends Controller {

    use MediaUploader;

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

        $posts = Post::whereHas("user", function ($course) {

            $course->whereIn("posts.postable_id", auth()->user()->courses->pluck("id"));
        })->orderBy('created_at', $request->option ? $request->option : "desc")
            ->paginate(10);
//
//        $posts = Post::orderBy('created_at', $request->option ? $request->option : "desc")
//            ->paginate(10);
        return view("index.discussions.discussions", [
            "posts" => $posts,
            "comment" => Comment::all(),
            "courses" => $this->course
        ]);
    }

    public function show($post)
    {
        $post = Post::findOrFail($post);
        $post->increment("watched");

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
        $post = Post::findOrFail($request->postId);

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
        })->where('title', 'LIKE', '%' . $request->term . '%')->paginate(10);

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

        $post = Post::findOrFail($request->postId);
        $request->validate([
            "body" => "required",
        ]);
        Comment::create([
            "body" => $request->body,
            "user_id" => auth()->id(),
            "post_id" => $request->postId,
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
        })->orderBy('created_at', $request->option ? $request->option : "desc")->paginate(10);

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
        })->orderBy('created_at', $request->option ? $request->option : "desc")->paginate(10);

        return view("index.discussions.discussions", [
            "posts" => $posts,
            "comment" => Comment::all(),
            "courses" => $this->course
        ]);
    }

    public function popularWeek(Request $request)
    {

        $posts = Post::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->orderBy("watched", "desc")->paginate(10);

        return view("index.discussions.discussions", [
            "posts" => $posts,
            "comment" => Comment::all(),
            "courses" => $this->course
        ]);
    }

    public function popularAllTime(Request $request)
    {

        $posts = Post::whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])
            ->orderBy("watched", "desc")->paginate(10);

        return view("index.discussions.discussions", [
            "posts" => $posts,
            "comment" => Comment::all(),
            "courses" => $this->course
        ]);
    }

    public function isClosed(Request $request)
    {

        $posts = Post::where("closed", 1)
            ->orderBy('created_at', $request->option ? $request->option : "desc")->paginate(10);

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
        })->orderBy('created_at', $request->option ? $request->option : "desc")->paginate(10);

        return view("index.discussions.discussions", [
            "posts" => $posts,
            "comment" => Comment::all(),
            "courses" => $this->course
        ]);
    }

    public function likeComment($commentId)
    {

        $comment = Comment::findOrFail($commentId);
        if (auth()->user()->commentIsLiked($comment))
        {
            auth()->user()->likeComment()->detach($comment);
        } else
        {
            auth()->user()->likeComment()->attach($comment);
        }

        return response()->json(!auth()->user()->commentIsLiked($comment));
    }

    public function best($commentId, Request $request)
    {
        $best = Comment::findOrFail($commentId)->best;
        Comment::where("post_id", $request->model)->update(["best" => 0]);
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
            "post" => Post::find($request->postId),
            "comment" => Comment::all(),
            "courses" => $this->course
        ]);
    }

    public function myTask()
    {

        $course = [];
        if (auth()->user()->getRoleNames()[0] == "student")
        {
//            $courseMedia = auth()->user()->media()->where("course_id", "!=", 0)->get();
            $coursesId = auth()->user()->courses->pluck("id");
            $courseMedia = Attachment::whereIn("course_id", $coursesId)->get();
            $course = $courseMedia->map(function ($media) {
                return Course::findOrFail($media->course_id);
            });
        } elseif (auth()->user()->hasAnyRole(["instructor", "admin", "super-admin"]))
        {
            $coursesId = Course::where("user_id", auth()->id())->pluck("id");
            $courseMedia = Attachment::whereIn("course_id", $coursesId)->get();
            $course = $courseMedia->map(function ($media) {
                return Course::findOrFail($media->course_id);
            });
        }

        return view("components.index.discussions.discussions-task", [
            "courses" => collect($course)->unique()
        ]);
    }

    public function completeTask($task)
    {
        $attachments = Attachment::find($task);
        if ($attachments->completed_at)
        {
            $attachments->update(["completed_at" => null]);
        } else
        {

            $attachments->update(["completed_at" => now()]);
        }
        return response()->json(["completed_at"=>$attachments->completed_at]);
    }

    public function deleteTask($taskId)
    {

        Attachment::findOrFail($taskId)->delete();

        return $this->myTask();
    }

    public function sendTask(Request $request)
    {
        $mailInfo = new \stdClass();
        $mailInfo->subject = $request->subject;
        $mailInfo->body = $request->body;
        $mailInfo->sender = auth()->user();
        $mailInfo->receiver = User::findOrFail(3);
        $mailInfo->course = Course::where("title", $request->course)->first();
        $mailInfo->attachment = $request->attachment;
        Mail::to(auth()->user()->email)->send(new EmailTask($mailInfo));
        $this->storeMail($mailInfo);

        return $this->myTask();
    }

    public function uploadTask(Request $request)
    {
        $files = $request->file;
        $res = [];
        $allowedTypes = array_diff($this->allowedTypes, ["image/png", "image/jpeg"]);
        foreach ($files as $key => $file)
        {
            if ($file->isValid())
            {
                if (in_array($file->getClientMimeType(), $allowedTypes))
                {
                    if ($file->getSize() <= 50000000)
                    { // 50MB
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
        $attachment->course_id = 0;
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

    private function storeMail($mail)
    {
        $recipients = [
            "ids" => [auth()->id()],
            "emails" => []
        ];
        $mailCreated = \App\Models\Mail::create([
            'user_id' => auth()->id(),
            'subject' => $mail->subject,
            'content' => $mail->body ?? auth()->user()->fullname,
            'recipients' => json_encode($recipients),
            'sent_at' => now()
        ]);
        if (isset($mail->attachment))
        {
            foreach (json_decode($mail->attachment) as $filePath)
            {
                Attachment::findOrFail($filePath->id)->update(
                    [
                        "mail_id" => $mailCreated->id
                    ]
                );
            }
        }
    }

}

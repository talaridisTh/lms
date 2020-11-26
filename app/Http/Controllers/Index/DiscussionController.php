<?php

namespace App\Http\Controllers\Index;

use App\Comment;
use App\Course;
use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;
use Str;

class DiscussionController extends Controller {

    //
    private $course;

    public function __construct()
    {

        $this->course = $courses = Post::orderBy('title')->get()->map(function ($post) {
            return $post->course->title;
        });
    }

    public function index()
    {

        return view("index.discussions.discussions", [
            "posts" => Post::orderBy('created_at', 'desc')->paginate(10),
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


        return view("components.index.discussions.discussions-main", [
            "posts" =>  Post::where('title', 'LIKE', '%' . $request->term . '%')->paginate(10),
            "comment" => Comment::all(),
            "courses" => $this->course
        ]);

    }

    public function storeThread(Request $request)
    {

        $request->validate([
            "title" => "required",
            "body" => "required",
            "course_id" => "required",
        ]);
        Post::create([
            "title" => $request->title,
            "slug" => Str::slug($request->title, "-"),
            "body" => $request->body,
            "user_id" => auth()->id(),
            "course_id" =>Course::where("title", $request->course_id)->first()->id
        ]);

        return redirect()->back();
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

    public function filterSidebar(Request $request)
    {

        return view("components.index.discussions.discussions-main", [
            "posts" => $this->getFilter($request),
            "comment" => Comment::all(),
            "courses" => $this->course
        ]);
    }

    public function filterCourse(Request $request)
    {

        return view("components.index.discussions.discussions-main", [
            "posts" => $this->getFilter($request),
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

    public function best($commentId,Request $request)
    {
        $best = Comment::findOrFail($commentId)->best;
        Comment::where("post_id",$request->postId)->update(["best" => 0 ]);


        Comment::findOrFail($commentId)->update(["best" => !$best]);
    }

    public function closed($postId,Request $request)
    {

        $closed = Post::findOrFail($postId)->closed;

        Post::findOrFail($postId)->update(["closed" => !$closed]);

    }

    private function getFilter($request)
    {

        if ($request->course == "All")
        {
            $posts = Post::orderBy('created_at', $request->option)->paginate(10);
        } else
        {
            $posts = Post::whereHas('course', function ($query) use ($request) {
                $query->where('title', $request->course);
            })->orderBy('created_at', $request->option)->paginate(10);
        }

        return $posts;
    }

}

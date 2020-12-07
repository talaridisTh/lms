<?php

namespace App\Traits;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

trait hasComments {


    public function modelComment(Request $request)
    {

        $post = Post::where("title", $request->modelInfo["title"])->first();
        if (empty($post))
        {
            $model = $request->namespace::find($request->modelInfo["id"]);
            $curator = empty($request->modelInfo["user_id"]) ?
                User::where("first_name", "Υδρόγειος")->first()->id : $request->modelInfo["user_id"];
            $post = $model->post()->create([
                "title" => $request->modelInfo["title"],
                "slug" => Str::slug($request->modelInfo["title"], "-"),
                "user_id" => $curator,
            ]);
        }
        Comment::create([
            "body" => $request->body,
            "user_id" => auth()->id(),
            "post_id" => $post->id,
            "parent_id" => $request->parentId
        ]);

        return view("components.index.comments.comments", [
            "post" => $post
        ]);
    }

    public function deleteComment(Request $request)
    {
        $postId = Comment::findOrFail($request->id)->post->id;
        Comment::where("parent_id", $request->id)->get()->each(function ($comment) {
            $comment->delete();
        });
        if (Comment::where("post_id",$postId)->count()<=1)
        {
            Comment::findOrFail($request->id)->post()->first()->delete();
        } else
        {

            dump(Comment::findOrFail($request->id));
            Comment::findOrFail($request->id)->delete();
        }

        $post = Post::where("title", $request->modelInfo["title"])->first();

        return view("components.index.comments.comments", [
            "post" => $post
        ]);
    }

}

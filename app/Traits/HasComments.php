<?php

namespace App\Traits;

use App\Models\Comment;
use App\Models\Media;
use App\Models\Post;
use App\Notifications\NewCommentNotification;
use Illuminate\Http\Request;
use Response;
use View;

trait HasComments {

    use MediaUploader;

    private $image = [];

    public function modelComment(Request $request)
    {

        $model = $request->namespace::findOrFail($request->modelInfo);
        $comment = $model->comments()->create([
            "body" => $request->body,
            "user_id" => auth()->id(),
//            "post_id" => $request->modelInfo["id"],
            "parent_id" => $request->parentId
        ]);
        if ($request->upload) {

            $this->attachComment($request, $comment);
        }
        $users = $model->users()->whereHas("roles", function ($role) {
            $role->where("name", "!=", "student");
        })->get()->unique("id");
        foreach ($users as $user) {

            if ($comment->user_id != $user->id) {
                $user->notify(new NewCommentNotification($comment, $model));
            }
        }

        return view("components.index.comments.comments", [
            "model" => $model
        ]);
    }

    private function attachComment($request, $comment)
    {
        foreach ($request->upload as $image) {

            $media = Media::where("original_name", $image)->first()->id;
            $comment->media()->attach($media, ["usage" => 5]);
        }
    }

    public function editComment($commentId, Request $request)
    {
        Comment::find($commentId)->update([
            "body" => $request->editBody
        ]);

        return view("components.index.comments.comments", [
            "model" => $request->namespace::find($request->modelId)
        ]);
    }

    public function deleteComment(Request $request)
    {
        $postId = Comment::findOrFail($request->id)->post->id;
        $this->deletePhotoComment($request->id);
        Comment::where("parent_id", $request->id)->get()->each(function ($comment) {
            $this->deletePhotoComment($comment->id);
            $comment->delete();
        });
        if (Comment::where("post_id", $postId)->count() <= 1) {
            Comment::findOrFail($request->id)->post()->first()->delete();
            $comment = 0;
        } else {

            Comment::findOrFail($request->id)->delete();
            $comment = 1;
        }
        $post = Post::where("title", $request->modelInfo["title"])->first();

        return Response::json(['view' => View::make("components.index.comments.comments", [
            "post" => $post
        ])->render(), 'comment' => $comment]);
//        return view("components.index.comments.comments", [
//            "post" => $post
//        ]);
    }

    private function deletePhotoComment($commentId)
    {
        $comment = Comment::findOrFail($commentId);
        $comment->media()->each(function ($com) {
            $com->delete();
        });
        $comment->media()->detach();
    }

    public function addFiles(Request $request)
    {

//        dd($request->all());
        $model = $request->namespace::find($request->modelId);
        foreach ($request->ids as $id) {
            $model->media()->attach($id, ["usage" => 3]);
        }
//        $files = $model->media()->where("type", 1)->get();
//        return view('components/admin/filesTable', ['files' => $files]);
    }

    public function deletePhotoOnComment(Request $request)
    {
        Comment::find($request->commentId)->media()->detach($request->imageId);
        Media::find($request->imageId)->delete();

        return response()->json(Comment::find($request->commentId)->media()->count());
    }

}

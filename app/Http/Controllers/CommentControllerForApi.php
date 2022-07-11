<?php

namespace App\Http\Controllers;

use App\Http\Resources\Posts as PostResource;
use App\Http\Resources\Comments as CommentResource;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CommentControllerForApi extends Controller
{
    public function store(Request $request)
    {
        $comment = new Comment();

        $comment->body = $request->input('body');
        $comment->post_id = $request->input('post_id');
        $comment->user_id = $request->input('user_id');


        if ($comment->save()) {
            return new CommentResource($comment);
        }

        return null;
    }

    public function currentPostComment(Post $post): AnonymousResourceCollection
    {
        $currentPostComment = Comment::where('post_id', '=', $post->id)->get(['id','body', 'user_id']);
        return CommentResource::collection($currentPostComment);
    }

    public function destroy(Comment $comment)
    {
        if ($comment->delete()) {
            return new CommentResource($comment);
        }

        return null;
    }

}

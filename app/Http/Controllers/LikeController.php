<?php

namespace App\Http\Controllers;

use App\Http\Resources\Comments as CommentResource;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Resources\Likes as LikeResource;


class LikeController extends Controller
{
    public function getLikes(Post $post) : AnonymousResourceCollection
    {
        // fetch the likes of each post
        $currentPostLike = Like::where('post_id', '=', $post->id)->get(['id','count', 'user_id']);
        return LikeResource::collection($currentPostLike);
    }

    public function store(Request $request)
    {
        $like = new Like();


        $like->count += 1;
        $like->post_id = $request->input('post_id');
        $like->user_id = $request->input('user_id');


        if ($like->save()) {
            return new LikeResource($like);
        }

        return null;
    }

    public function destroy(Like $like)
    {
        if ($like->delete()) {
            return new LikeResource($like);
        }
    }




}

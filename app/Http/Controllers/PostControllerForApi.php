<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;

use App\Models\Post;
use App\Http\Resources\Posts as PostResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostControllerForApi extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {

        $posts = Post::latest()->paginate(15);
        return PostResource::collection($posts);
    }

    public function currentUserPost(User $user): AnonymousResourceCollection
    {
        $currentUserPost = Post::where('user_id', '=', $user->id)->get(['slug', 'body', 'created_at', 'image','user_id']);
        return PostResource::collection($currentUserPost);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return PostResource|null
     */
    public function store(Post $post,Request $request)
    {

        $article =  new Post;
        if($request->isMethod('put')) {
            try {
                $article = $post;
            }
            catch (Exception $e) {
                return null;
            }
        }


        $str = $request->input('body');
        if($request->input('slug') == '') {
            $article->slug =  strlen($str) > 5 ? substr($str, 6).'-'. random_int(1, 1000) : 'post-no-'.$article->id.'-'.random_int(100, 2000); ;

        }
        $article->body = $str;

        if ($request->file('image') === null) {
            $article->image = $post->image;
        }else{
            $article->image = request()->file('image')->store('public/thumbnails');;
        }

        $article->user_id = request()->user()->id;

        if ($article->save()) {
            return new PostResource($article);
        }

        return null;
    }

    /**
     * Display the specified resource.
     *
     * @param int $slug
     * @return PostResource
     */
    public function show(Post $post): PostResource
    {
        // Get article

        // Return single article as a resource
        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $slug
     * @return PostResource|null
     */
    public function destroy(Post $post)
    {
        // Get article


        if ($post->delete()) {
            return new PostResource($post);
        }

        return null;
    }


    //its about like and dislike
    public function fetchLike(Post $post)
    {

        return response()->json([
            'post' => $post->like,
        ]);
    }

    public function handleLike(Post $post, Request $request)
    {

        $value = $post->like;
        if($request->liked) {
            if($request->liked > 0) {
                $post->like = $value-1;
                $request->liked = false;
            }
        } else {
            $post->like = $value+1;
            $request->liked = true;
        }
        $post->save();
        return response()->json([
            'liked' => $request->liked
        ]);
    }

    public function fetchDislike(Post $post)
    {
        return response()->json([
            'post' => $post->dislike,
        ]);
    }

    public function handleDislike(Post $post, Request $request)
    {
        $value = $post->dislike;
        if($request->disliked) {
            if($request->disliked > 0) {
                $post->dislike = $value-1;
                $request->disliked = false;
            }
        } else {
            $post->dislike = $value+1;
            $request->disliked = true;
        }
        $post->save();
        return response()->json([
            'disliked' => $request->disliked
        ]);
    }

}

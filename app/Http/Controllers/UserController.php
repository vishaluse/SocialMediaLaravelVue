<?php

namespace App\Http\Controllers;

use App\Http\Resources\Comments as CommentResource;
use App\Http\Resources\Posts as PostResource;
use App\Models\Post;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use App\Http\Resources\Users as UserResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    public function update(User $user, Request $request)
    {

        $currentUser =  new User;
        if($request->isMethod('put')) {
            try {
                $currentUser = $user;
            }
            catch (Exception $e) {
                return null;
            }
        }

        $currentUser->name = $request->input('name');
        $currentUser->username = $request->input('username');
        $currentUser->email = $request->input('email');


        if ($currentUser->save()) {
            return new UserResource($currentUser);
        }

        return null;
    }

    public function currentUsername(User $user): AnonymousResourceCollection
    {
        $currentUsername = User::where('id', '=', $user->id)->get(['name','username', 'email']);
        return UserResource::collection($currentUsername);
    }
}

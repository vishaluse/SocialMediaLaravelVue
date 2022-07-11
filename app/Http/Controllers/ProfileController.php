<?php

namespace App\Http\Controllers;


use App\Http\Resources\Profiles as ProfileResource;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProfileController extends Controller
{
    public function store(Request $request)
    {

        $data = new Profile();

//        $data->follower_id = $request->input('follower_id');
        $data->following_id = $request->input('following_id');
        $data->user_id = $request->input('user_id');


        $followingUserData = new Profile();



        $followingUserData->follower_id = $request->input('user_id');
        $followingUserData->user_id = $request->input('following_id');
        $followingUserData->save();

//        return $request->input('following_id');

        if ($data->save()) {
            return new ProfileResource($data);
        }

        return null;
    }

    public function currentProfileData(User $user): AnonymousResourceCollection
    {
        $currentProfileData = Profile::where('user_id', '=', $user->id)->get(['id','follower_id', 'following_id', 'user_id']);
        return ProfileResource::collection($currentProfileData);

    }

    public function destroy(Profile $profile)
    {

        $followingProfileData = Profile::where('follower_id', $profile->user_id);

        $followingProfileData->delete();

        if ($profile->delete()) {
            return new ProfileResource($profile);
        }

        return null;
    }
}

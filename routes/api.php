<?php

use App\Http\Controllers\CommentControllerForApi;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\LoginApiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterApiController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostControllerForApi;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/authenticated', function () {
    return true;
});



// List posts
Route::get('postsapi', [PostControllerForApi::class, 'index']);

Route::get('postapi/details/{user:id}',[PostControllerForApi::class, 'currentUserPost']);

// List single postapi
Route::get('postapi/{post:slug}', [PostControllerForApi::class, 'show']);


// Create new postapi
Route::post('postapi', [PostControllerForApi::class, 'store']);

// Update postapi
Route::put('postapi/update/{post:slug}', [PostControllerForApi::class, 'store']);


// Delete postapi
Route::delete('postapi/{post:slug}', [PostControllerForApi::class, 'destroy']);




Route::post('register', [RegisterApiController::class, 'register']);
Route::post('login', [LoginApiController::class, 'login']);
Route::post('logout', [LoginApiController::class, 'logout']);

Route::put('user/update/{user:id}', [UserController::class, 'update']);
Route::get('user/{user:id}', [UserController::class, 'currentUsername']);

//comment APIs
//add a comment
Route::post('comment', [CommentControllerForApi::class, 'store']);

//get all the current post comment
Route::get('comment/{post:id}', [CommentControllerForApi::class, 'currentPostComment']);

//delete the comments
Route::delete('comment/{comment:id}', [CommentControllerForApi::class, 'destroy']);


//like APIs
Route::post('like', [LikeController::class, 'store']);

Route::get('like/{post:id}', [LikeController::class, 'getLikes']);

Route::delete('like/delete/{like:id}', [LikeController::class, 'destroy']);


//follower and following APIs
Route::post('following/{user:id}', [ProfileController::class, 'store']);

//fetch particular user profile data which will include follower and following
Route::get('following/profile/{user:id}', [ProfileController::class, 'currentProfileData']);

//delete the following data
Route::delete('following/delete/{profile:id}', [ProfileController::class, 'destroy']);

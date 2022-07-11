<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterApiController extends Controller
{
    public function register(Request $request)
    {


        $attributes = request()->validate([
            'name' => 'required | max:255',
            'username' => 'required | min:3 | max:255 | unique:users,username',
            'email' => 'required | email | max:255 | unique:users,email',
            'password' => 'required | confirmed | min:2 | max: 255',
        ]);

        if($request->image) {

            $attributes['image'] = request()->file('image')->store('public/thumbnails');
        }

        $user = User::create($attributes);

        auth()->login($user);


//        $request->validate([
//            'name' => ['required'],
//            'email' => ['required', 'email', 'unique:users'],
//            'password' =>['required', 'min:3', 'confirmed']
//        ]);
//
//        User::create([
//            'name' => $request->name,
//            'email' => $request->email,
//            'password' => bcrypt($request->password)
//        ]);
    }
}

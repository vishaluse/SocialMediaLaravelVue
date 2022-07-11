<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use function MongoDB\BSON\toJSON;

class VueController extends Controller
{

    public function show()
    {
        return view('welcome');
    }

}

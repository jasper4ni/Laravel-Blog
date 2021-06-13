<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request, $username)
    {
        $user_id = User::select('id')->where('name',$username)->get();
        if(count($user_id)==0){
            return view('user',['username' => $username,'posts' => []]);
        }
        return view('user',['username' => $username])->withPosts(Post::
        latest()
        ->where('user_id',$user_id[0]->id)
        ->orderBy('created_at','desc')
        ->get());
    }
}

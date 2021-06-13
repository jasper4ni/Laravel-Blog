<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\Post;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return view('dashboard')->withPosts(Post::
        latest()
        ->where('user_id',auth()->user()->id)
        ->orderBy('created_at','desc')
        ->get());
    }
}

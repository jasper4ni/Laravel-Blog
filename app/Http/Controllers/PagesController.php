<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\Post;

class PagesController extends Controller
{
    public function index(Request $request)
    {
        return view('index')->withPosts(Post::
        limit(6)
        ->latest()        
        ->orderBy('created_at','desc')
        ->get());
    }

}

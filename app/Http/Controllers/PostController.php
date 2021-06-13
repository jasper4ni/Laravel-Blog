<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth')->except('index','show');
    }
    public function index()
    {
        return view('post.index')->withPosts(Post::orderBy('created_at','desc')->get());;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'content'=>'required',
            'image'=>'required|mimes:jpg,png,jpeg,webp|max:5120',
        ]);

        $newImageName = uniqid().'-'.$request->title.'.'.$request->image->extension();
        $newImageName = SlugService::createSlug(Post::class,'slug',$newImageName);
        $request->image->move(public_path('images'),$newImageName);

        // $slug = Str::slug($request->title);
        $slug = SlugService::createSlug(Post::class,'slug',$request->title);
        
        Post::create([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->content,
            'image_path' => $newImageName,
            'user_id' => auth()->user()->id
        ]);

        return redirect('/post')->with('message','Your post has been added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        return view('post.show')->withPost(Post::where('slug',$slug)->first());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        return view('post.edit')->withPost(Post::where('slug',$slug)->first());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $request->validate([
            'title'=>'required',
            'content'=>'required',
            'image'=>'mimes:jpg,png,jpeg,webp|max:5120',
        ]);
        
        $newSlug = SlugService::createSlug(Post::class,'slug',$request->title);

        if(empty($request->image))
        {
            Post::where('slug',$slug)
            ->update([
                'title' => $request->title,
                'slug' => $newSlug,
                'content' => $request->content,
                'user_id' => auth()->user()->id
            ]);
        }
        else
        {
            $newImageName = uniqid().'-'.$request->title.'.'.$request->image->extension();
            $newImageName = SlugService::createSlug(Post::class,'slug',$newImageName);
            $request->image->move(public_path('images'),$newImageName);
            Post::where('slug',$slug)
            ->update([
                'title' => $request->title,
                'slug' => $newSlug,
                'content' => $request->content,
                'image_path' => $newImageName,
                'user_id' => auth()->user()->id
            ]);
        }
        return redirect('/post')->with('message','Your post has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        Post::where('slug',$slug)
        ->delete();

        return redirect('/post')->with('message','Your post has been deleted!');
    }
}

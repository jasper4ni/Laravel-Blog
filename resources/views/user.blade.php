@extends('layouts.layout')
@section('banner-img','/assets/mojave_bg.jpg')
@section('banner-content')
@if (empty($posts))
    <h1 class="text-white text-3xl text-center">No Such User!</h1>
    <a href="/login" class="mt-5 px-5 py-2 bg-gray-500 bg-blend-overlay text-white outline-none hover:bg-gray-600">
        Join Now :)
    </a>
@else
    @auth
    <h1 class="text-white text-3xl text-center">{{$username}} Posts</h1>
    @else
    <h1 class="text-white text-3xl text-center">{{$username}} Posts</h1>
    <a href="/login" class="mt-5 px-5 py-2 bg-gray-500 bg-blend-overlay text-white outline-none hover:bg-gray-600">
        Join Now :)
    </a>
    @endauth
@endif
@endsection

@section('content')
@if (empty($posts))
@else
<div class="bg-gray-700 text-white font-mono">
    <h2 class="w-9/12 pt-8 mx-auto text-3xl">{{$username}} Posts</h2>
    <div class="w-9/12 m-auto py-8 flex flex-col">
        @if (session()->has('message'))
            <h3 class="font-bold mb-3 text-center">{{session()->get('message')}}</h2>
        @endif
        @if (json_encode($posts) == '[]')
            <h2 class="font-bold mb-2 text-center">{{$username}} Has No Any Post Yet!</h2>
        @else
        @foreach($posts as $post)
        <div class="w-full mb-5 h-auto border-2 relative bg-black bg-opacity-40 border-gray-500 rounded mx-auto px-5 py-5 hover:bg-opacity-50 transition ease-in-out duration-150" >
            <a href="{{ route('post.show',$post->slug ) }}" class="flex sm:flex-row flex-col ">
                <img src="{{asset('images/'.$post->image_path)}}" class="h-40 sm:max-w-none sm:w-1/3 w-full" style="object-fit: cover;">
                <div class="sm:pl-5 sm:pt-0 pt-5 sm:w-2/3">
                    <h2 class="font-bold mb-2 text-lg">{{$post->title}}</h2>
                    <p id="" class="break-all">{{Str::limit($post->content, 270)}}</p>
                </div>               
                <span class="absolute bottom-5 right-5">-></span>
            </a>
            @if (isset(Auth::user()->id) && Auth::user()->id == $post->user_id)
            <a  href="/post/{{$post->slug}}/edit"
                class="w-full mt-5 h-auto border-2 flex sm:flex-row flex-col relative bg-black bg-opacity-20 border-gray-500 rounded mx-auto py-3 px-5 hover:bg-opacity-30 transition ease-in-out duration-150"
                >Edit Post
            </a>
            <form action="/post/{{$post->slug}}" method="POST">
                @csrf
                @method('delete')
                <button type="submit" class="w-full mt-3 h-auto border-2 flex sm:flex-row flex-col relative bg-black bg-opacity-20 border-gray-500 rounded mx-auto py-3 px-5 hover:bg-opacity-30 transition ease-in-out duration-150">
                    Delete Post
                </button>
            </form>
            @endif
            <div class="mt-5" style="max-width: 90%">By <i>{{$post->user->name}}</i> at {{date('jS M Y', strtotime($post->updated_at))}}</div>
        </div>
        @endforeach
        @endif
    </div>
</div>
@endif

@endsection
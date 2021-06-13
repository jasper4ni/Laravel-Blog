@extends('layouts.layout')
@section('banner-img','/assets/mojave_bg.jpg')
@section('banner-content')
@auth
<h1 class="text-white text-3xl text-center">Hi {{ Auth::user()->name }}</h1>
<a href="/post/create" class="mt-5 px-5 py-2 bg-gray-500 bg-blend-overlay text-white outline-none hover:bg-gray-600">
    Create Post :)
</a>
@else
<h1 class="text-white text-3xl text-center">Recent Post</h1>
<a href="/login" class="mt-5 px-5 py-2 bg-gray-500 bg-blend-overlay text-white outline-none hover:bg-gray-600">
    Join Now :)
</a>
@endauth
@endsection

@section('content')
<div class="bg-gray-700 text-white font-mono">
    <div class="w-9/12 m-auto py-8 flex flex-col">
        @if (session()->has('message'))
            <h3 class="font-bold mb-3 text-center">{{session()->get('message')}}</h2>
        @endif
        @if (json_encode($posts) == '[]')
            <h2 class="font-bold mb-2 text-center">No Any Post Yet, Create One Now!</h2>
        @else
        @foreach($posts as $post)
        <div class="w-full mb-5 h-auto border-2 relative bg-black bg-opacity-40 border-gray-500 rounded mx-auto px-5 py-5 hover:bg-opacity-50 transition ease-in-out duration-150" >
            <a href="{{ route('post.show',$post->slug ) }}" class="flex sm:flex-row flex-col ">
                <img src="{{asset('images/'.$post->image_path)}}" class="h-40 sm:max-w-none sm:w-1/3 w-full" width="300px" style="object-fit: cover;">
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
            <div class="mt-5 flex-grow flex items-end" style="max-width: 90%">
                <p class="" style="height: fit-content">By <a href="/user/{{$post->user->name}}"><i>{{$post->user->name}}</i></a> at {{date('jS M Y', strtotime($post->updated_at))}}</p>
            </div>
        </div>
        @endforeach
        @endif
        
        {{-- <a class="w-full mb-5 h-auto border-2 flex sm:flex-row flex-col relative bg-black bg-opacity-40 border-gray-500 rounded mx-auto px-5 pt-5 sm:pb-12 pb-14 hover:bg-opacity-50 transition ease-in-out duration-150" href="/">
            <img src="/assets/mojave_bg.jpg" class="h-40 sm:max-w-none sm:w-72 w-full" style="object-fit: cover;">
            <div class="sm:pl-5 sm:pt-0 pt-5">
                <h2 class="font-bold mb-2">Title</h2>
                <p id="content_preview" class="break-all">Content Content Content Content Content Content Content Content Content Content Content </p>
            </div>               
            <div class="absolute bottom-3 left-5">By <i>Jasper4ni</i> at {{date('jS M Y', time())}}</div>
            <span class="absolute bottom-3 right-5">-></span>
        </a> --}}
    </div>
</div>
@endsection
@push('child-style')
<style>
    #content_preview{
        display: -webkit-box;
        -webkit-line-clamp: 5;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>    
@endpush
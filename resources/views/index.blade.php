@extends('layouts.layout')
@section('banner-img','/assets/mojave_bg.jpg')
@section('banner-content')
@auth
<h1 class="text-white text-3xl text-center">Welcome back {{ Auth::user()->name }}</h1>
<a href="/post/create" class="mt-5 px-5 py-2 bg-gray-500 bg-blend-overlay text-white outline-none hover:bg-gray-600">
    Create Post :)
</a>
@else
<h1 class="text-white text-3xl text-center">Do you dessire to become a senior developer?</h1>
<a href="/login" class="mt-5 px-5 py-2 bg-gray-500 bg-blend-overlay text-white outline-none hover:bg-gray-600">
    Join Now :)
</a>
@endauth
@endsection
@section('content')
    <section class="py-8 bg-gray-700 text-white font-mono">
        <h2 class="w-9/12 py-8 mx-auto text-3xl">Recent Post</h2>
        <div class="w-9/12 grid sm:grid-cols-3 grid-cols-1 gap-5 mx-auto">
            @foreach ($posts as $key=>$post)
            <div class="h-auto border-2 flex flex-col relative bg-black bg-opacity-40 border-gray-500 rounded w-full mx-auto px-5 py-5 hover:bg-opacity-50">
                <a href="{{ route('post.show',$post->slug ) }}" 
                    class="">
                    <img src="{{asset('images/'.$post->image_path)}}" class="sm:h-52 h-44 w-full" style="object-fit: cover;">
                    <div class="pt-5 pb-5">
                        <h2 class="font-bold mb-2 text-lg">{{$post->title}}</h2>
                        <p id="" class="break-all">{{Str::limit($post->content, 240)}}</p>
                    </div>
                    <span class="absolute bottom-5 right-5">-></span>
                </a>
                @if (isset(Auth::user()->id) && Auth::user()->id == $post->user_id)
                <a  href="/post/{{$post->slug}}/edit"
                    class="w-full h-auto border-2 flex sm:flex-row flex-col relative bg-black bg-opacity-40 border-gray-500 rounded mx-auto py-3 px-5 hover:bg-opacity-50 transition ease-in-out duration-150"
                    >Edit Post
                </a>
                <form action="/post/{{$post->slug}}" method="POST">
                    @csrf
                    @method('delete')
                    <button type="submit" class="w-full h-auto border-2 mt-3 flex sm:flex-row flex-col relative bg-black bg-opacity-40 border-gray-500 rounded mx-auto py-3 px-5 hover:bg-opacity-50 transition ease-in-out duration-150">
                        Delete Post
                    </button>
                </form>
                @endif
                <div class="mt-5 flex-grow flex items-end" style="max-width: 90%">
                    <p class="" style="height: fit-content">By <a href="/user/{{$post->user->name}}"><i>{{$post->user->name}}</i> </a><br> at {{date('jS M Y', strtotime($post->updated_at))}}</p>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="w-9/12 mx-auto text-xl h-14 flex items-center justify-end mt-5">
            <a href="/post">More Post -></a>
        </div>  
    </section>
    
@endsection
@push('child-style')
<style>
    #content_preview{
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>    
@endpush
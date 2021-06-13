@extends('layouts.layout')
@section('banner-img','/assets/mojave_bg.jpg')
{{-- @section('banner-img',url('/images/'.rawurlencode($post->image_path))) --}}
@section('banner-content')
@auth
<h1 class="text-white text-3xl text-center">{{$post->title}}</h1>
@else
<h1 class="text-white text-3xl text-center">{{$post->title}}</h1>
<a href="/login" class="mt-5 px-5 py-2 bg-gray-500 bg-blend-overlay text-white outline-none hover:bg-gray-600">
    Join Now :)
</a>
@endauth
@endsection

@section('content')
<div class="bg-gray-700 text-white font-mono">
    <div class="w-9/12 m-auto pt-8 pb-52">
        <img src="/images/{{$post->image_path}}" class="sm:h-80 sm:max-w-none" style="object-fit: contain;">
        <div class=" pt-5">
            <h2 class="font-bold text-3xl">{{$post->title}}</h2>
            <div class="text-md mt-5">By <i>{{$post->user->name}}</i> at {{date('jS M Y', strtotime($post->updated_at))}}</div>
            <div id="content_preview" class="mt-5 break-normal">{!! nl2br($post->content,false) !!}</div>
        </div>
        @if (isset(Auth::user()->id) && Auth::user()->id == $post->user_id)
        <a  href="/post/{{$post->slug}}/edit"
            class="w-full mt-16 h-auto border-2 flex sm:flex-row flex-col relative bg-black bg-opacity-20 border-gray-500 rounded mx-auto py-3 px-5 hover:bg-opacity-30 transition ease-in-out duration-150"
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
    </div>

</div>
@endsection
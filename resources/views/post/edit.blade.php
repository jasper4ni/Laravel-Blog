@extends('layouts.layout')
@section('banner-img','/assets/mojave_bg.jpg')
@section('banner-content')
@auth
<h1 class="text-white text-3xl text-center">Hi {{ Auth::user()->name }}</h1>
@else
<h1 class="text-white text-3xl text-center">Post</h1>
<a href="/login" class="mt-5 px-5 py-2 bg-gray-500 bg-blend-overlay text-white outline-none hover:bg-gray-600">
    Join Now :)
</a>
@endauth
@endsection

@section('content')
<div class="bg-gray-700 font-mono">
    @if ($errors->any())
        <div class="sm:w-10/12 sm:px-0 px-4 py-10 m-auto">
            <div class="font-medium text-white"">
                {{ __('Whoops! Something went wrong.') }}
            </div>

            <ul class="mt-3 list-disc list-inside text-sm text-white"">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form class="rounded-md sm:w-10/12 sm:px-0 px-4 py-10 m-auto" action="/post/{{$post->slug}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div>
            <div>
                <x-label class="text-2xl font-bold" :value="__('Edit Post')"/>
            </div>
            

            <!-- Post Title -->
            <div>
                <x-label class="text-xl mt-8" :value="__('Title')"/>
                <x-input id="title" class="block mt-1 w-full" type="text" name="title" value="{{$post->title}}" required autofocus />
            </div>
                
            <div>
                <!-- Post Content -->
                <x-label class="text-xl mt-8" :value="__('Content')"/>
                <textarea name="content" id="content" class='rounded-md mt-2 shadow-sm w-full h-24 outline-none border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50'>{{$post->content}}</textarea>
            </div>
                
            <div class=" my-7">
                <!-- Post Image -->
                {{-- <x-label class="text-xl mt-8" :value="__('Upload Image')"/> --}}
                <label for="image" class="cursor-pointer inline-block bg-white rounded-md py-2 px-5 hover:bg-gray-500 hover:text-white text-black transition ease-in-out duration-150">
                    <span class="text-md">Upload Image</span>
                    <input id="image" class="hidden mt-1" type="file" name="image">
                </label>
                <p class="inline-block ml-2 text-xs text-white">*only jpg,png,jpeg,webp accepted</p>
            </div>

            <!-- Post Preview -->
            <x-label class="text-xl mb-4" :value="__('Post Card Preview')"/>
            <div class="w-full cursor-pointer mb-5 text-white h-auto border-2 flex sm:flex-row flex-col relative bg-black bg-opacity-40 border-gray-500 rounded mx-auto px-5 pt-5 sm:pb-12 pb-14 hover:bg-opacity-50 transition ease-in-out duration-150">
                <div id="image_overlay" class="bg-black bg-opacity-20 relative">
                    <span class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-lg font-bold" id="image_pre_content">
                        Image
                    </span>
                    <img src="/images/{{$post->image_path}}" alt="Image" id="img_preview" class="h-40 sm:max-w-none sm:w-72 w-full opacity-0 transition ease-in-out duration-500" style="object-fit: cover">
                </div>
                
                <div class="sm:pl-5 sm:pt-0 pt-5 w-full">
                    <h2 class="font-bold mb-2 text-lg" id="title_preview">Title</h2>
                    <p id="content_preview" class="break-all">Content</p>
                    <p class="absolute bottom-3 left-5">By <i>{{Auth::user()->name}}</i> at {{date('jS M Y', time())}}</p>
                </div>               
                <span class="absolute bottom-3 right-5">-></span>
            </div>
            
            <div>
                <button type="submit" class="items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    UPDATE
                </button>
            </div>
            
        </div>
    </form>
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
@push('child-scripts')
<script type="text/javascript">
    $('#content').on('input', function () {
        this.style.height = 'auto';
         
        this.style.height = (this.scrollHeight)+32 + 'px';
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#img_preview').attr('src', e.target.result);
                $('#img_preview').removeClass('opacity-0');
                $('#image_pre_content').remove();
                $('#image_overlay').css('background-color','rgba(0,0,0,0)');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#image").change(function(){
        readURL(this);
    });

    $("#title").keyup(function() {
        var title = $(this).val();
        $("#title_preview").text(title)
    });

    $("#content").keyup(function() {
        var content = $(this).val();
        $("#content_preview").html(content)
    });
    
    $("#title_preview").text($("#title").val())
    $("#content_preview").text($("#content").val())
    $('#img_preview').removeClass('opacity-0');
    $('#image_pre_content').remove();
    $('#image_overlay').css('background-color','rgba(0,0,0,0)');
    var innerHeight = $('#content').prop('scrollHeight');
    $('#content').height(innerHeight);
</script>
@endpush
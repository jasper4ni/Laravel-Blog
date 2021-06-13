<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @php
        $title = Request::route()->getName();
    @endphp
    <title>Learn Laravel - {{ucfirst($title)}}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body>
    @include('layouts.header')
    <div class="flex justify-center items-center flex-col font-mono background-img bg-gray-700" 
    style="background-image: url(@yield('banner-img'));height:600px">
        @section('banner-content')
        @show
    </div>
    @section('content')   
    @show
    @include('layouts.footer')
</body>
</html>
@stack('child-scripts')
@stack('child-style')
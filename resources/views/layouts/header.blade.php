<header class="w-full z-10 h-20 fixed flex justify-around items-center font-mono transition-all bg-transparent duration-500">
    <a href="/" class="m-auto text-3xl text-white text-shadow-md">Learn Laravel</a>
    <nav class="m-auto flex flex-row justify-evenly w-2/5 text-white text-lg">
        @php
            $headerNav = ['home','post'];
        @endphp
        @foreach ($headerNav as $value)
        @if ($value=='home')
            <a href="/" class="transform hover:-translate-y-1 transition-all duration-300">{{ucfirst($value)}}</a>
        @else
            <a href="/{{$value}}" class="transform hover:-translate-y-1 transition-all duration-300">{{ucfirst($value)}}</a>
        @endif            
        @endforeach
        @if (Route::has('login'))
            @auth
                {{-- <a href="{{ url('/dashboard') }}" class="transform hover:-translate-y-1 transition-all duration-300">Dashboard</a> --}}
                @if (Route::has('dashboard'))
                    <a href="{{ route('dashboard') }}" class="transform hover:-translate-y-1 transition-all duration-300">Dashboard</a>
                @endif
                @if (Route::has('logout'))
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="transform hover:-translate-y-1 transition-all duration-300 outline-none focus:outline-none">Logout</button>
                </form>
                {{-- <a href="{{ route('logout') }}" class="transform hover:-translate-y-1 transition-all duration-300">Logout</a> --}}
                @endif
            @else
                <a href="{{ route('login') }}" class="transform hover:-translate-y-1 transition-all duration-300">Login</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="transform hover:-translate-y-1 transition-all duration-300">Register</a>
                @endif
            @endauth
        @endif

        
    </nav>
    
</header>

@push('child-scripts')
    <script>
        $( document ).ready(function() {
            var scroll = $(window).scrollTop();
            if(scroll!=0){
                $('header').css("background-color","rgba(0,0,0,0.3)")
            }
            else{
                $('header').css("background-color","rgba(0,0,0,0)")
            }
            $(window).scroll(function (event) {
                var scroll = $(window).scrollTop();
                if(scroll!=0){
                    $('header').css("background-color","rgba(0,0,0,0.3)")
                }
                else{
                    $('header').css("background-color","rgba(0,0,0,0)")
                }
            });
        });
    </script>
@endpush
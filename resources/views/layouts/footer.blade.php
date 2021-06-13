<footer class="bg-gray-800 py-20 font-mono">
    <div class="sm:grid grid-cols-3 w-3/4 pb-10 m-auto border-b-2 text-l font-bold text-gray-100">
        @php
            $footer = json_decode('{
                "Pages":["home","about","post"],
                "Find us":["What-we-do","Address","Phone","Contact"],
                "Latest posts":["Why-we-love-tech","Why-we-love-design","Why-to-use-Laravel","Why-PHP-is-the-best"]
            }')
        @endphp
        @foreach ($footer as $key => $val)
        <div>
            <h3>
                {{$key}}
            </h3>
            <ul>
                @foreach ($val as $item)
                    <li class="mt-2 font-normal text-gray-300 text-sm"><a href="/{{$item}}">{{ucfirst(str_replace('-',' ',$item))}}</a></li>
                @endforeach
            </ul>
        </div>
        @endforeach
    </div>
    <p class="text-gray-100 m-auto text-xs w-3/4 mt-4 font-sans">2021©Learn Laravel</p>
</footer>
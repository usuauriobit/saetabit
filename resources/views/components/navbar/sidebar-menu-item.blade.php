<li class="flex items-center justify-between w-full mb-2  text-gray-400 hover:bg-white hover:bg-opacity-5
    {{ Route::is($item['route_is']) ? 'border border-white border-opacity-25 text-gray-200' : '' }}
"
    {{-- @if (Route::is($item['route_is']))
        style="
        background: rgba(255, 255, 255, 0.09);
        border-radius: 16px;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        "
    @endif --}}
>
    @if (Route::is($item['route_is']))
        <div class="bg-secondary text-secondary" style="width: 5px; height: 100%;">
            .
        </div>
    @endif
    <a href="{{route($item['route_name'])}}" class="flex items-center w-full px-4 py-2 transition duration-500 transform motion-safe:hover:scale-105">
        {!!$item['icon']!!}
        <span class="ml-3 text-sm">{{$item['label']}}</span>
    </a>
</li>

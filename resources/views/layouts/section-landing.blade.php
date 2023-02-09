@php
$menu = collect(config('landing_menu'));
@endphp
@include('components.navbar.navbar_landing', [
    'menu' => $menu,
])
@include('components.alerts')
<div>
    <nav x-data
        class="fixed top-0 left-0 z-20 h-full pb-10 overflow-x-hidden overflow-y-auto transition origin-left transform bg-gray-900 w-60 -translate-x-full"
        :class="{ '-translate-x-full': !$store.general.sideBar, 'translate-x-0': $store.general.sideBar }"
        {{-- style="background: url({{asset('img/dark-bg-1.jpg')}}); background-position: center; background-repeat:
        no-repeat; background-size: cover" --}}>
        <a href="/" class="flex items-center px-4 py-5">
            <img src="{{ asset('img/logo-white.png') }}" class="w-20" alt="" srcset="">
        </a>
        <nav class="text-sm font-medium text-gray-500" aria-label="Main Navigation">
            <ul class="menu">
                @foreach ($menu as $item)
                    <li>
                        <a class=" {{ Route::is($item['route_is']) ? 'text-gray-200 bg-gray-700' : '' }} flex items-center px-4 py-3 my-2 transition cursor-pointer group hover:bg-gray-800 hover:text-gray-200"
                            href="{{ route($item['route_name']) }}">
                            {!! $item['icon'] !!} &nbsp;
                            <span>{{ $item['label'] }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </nav>
    <div class="slot">
        {{ $slot ?? null }}
        @yield('content')
    </div>
    <div x-data class="fixed inset-0 z-10 w-screen h-screen bg-black bg-opacity-25 md:hidden"
        x-show.transition="$store.general.sideBar" x-on:click="$store.general.closeSideBar()" x-cloak>
    </div>
</div>
@include('components.landing-page.footer')

<nav x-data class="relative flex items-center justify-between w-full h-20 px-8 mx-auto bg-white ">
    <!-- logo -->
    <button class="block btn btn-sm text-xl btn-ghost md:hidden" x-on:click="$store.general.toggleSideBar()">
        <span class="sr-only">Menu</span>
        <i class="las la-bars"></i>
    </button>
    <div class="inline-flex">
        <a class="" href="/">
            <div class="hidden md:block">
                <img src="{{ asset('img/logo-color.png') }}" alt="" srcset="">
            </div>
            {{-- <div class="block md:hidden">
                <img src="{{ asset('img/logo-color.png') }}" alt="" srcset="">
            </div> --}}
        </a>
    </div>
    <!-- login -->
    <div class="flex-initial">
        <div class="relative flex items-center justify-end">
            <div class="flex items-center gap-1 hidden md:block">
                @foreach ($menu as $item)
                    <a class="inline-block px-3 py-2 rounded-full
                        {{ Route::is($item['route_is']) ? 'text-white bg-primary' : 'hover:bg-gray-500/10' }}"
                        href="{{ route($item['route_name']) }}">
                        <div class="relative flex items-center cursor-pointer whitespace-nowrap">
                            {!! $item['icon'] !!} &nbsp; {{ $item['label'] }}
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="block">
                @auth
                    @include('components.profile_dropdown')
                @else
                    <a class="ml-2 inline-block px-3 py-2 rounded-full border-blue-700 text-blue-700 border-2"
                        href="{{ route('login') }}">
                        <div class="relative flex items-center cursor-pointer whitespace-nowrap">
                            <i class="la la-user"></i>
                            <span class="hidden md:block">&nbsp; Iniciar sesión</span>
                        </div>
                    </a>
                @endauth
            </div>
        </div>
    </div>
    <!-- end login -->
</nav>

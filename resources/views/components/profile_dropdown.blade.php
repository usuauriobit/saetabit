<div class="dropdown dropdown-end">
    <div tabindex="0" class="m-1">
        <button class="flex items-center">
            <div class="avatar">
                <div class="w-10 h-10 m-1 rounded-full">
                    @auth

                        <img src="{{ Auth::user()->profile_photo_url }}">
                    @endauth
                </div>
            </div>
            <span class="truncate w-20 md:block hidden">
                {{ Auth::user()->name }}
            </span>
        </button>
    </div>
    <ul tabindex="0" class="p-2 text-black bg-white shadow menu dropdown-content rounded-box w-52">
        @if (Auth::check())
            <li>
                <a href="{{ route('landing_page.auth.profile') }}">
                    Mi perfil
                </a>
            </li>
            {{-- <li>
                <a>Item 2</a>
            </li> --}}
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-jet-dropdown-link href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                this.closest('form').submit();">
                        <div class="py-2 font-semibold text-md">
                            <i class="la la-sign-out-alt"></i> Cerrar sesión
                        </div>
                    </x-jet-dropdown-link>
                </form>
            </li>
        @endif
    </ul>
</div>

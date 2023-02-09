<div class="navbar text-white sticky  w-full" style="background-color: rgb(28 25 23);">
    <div class="navbar-start">
        <button class="block btn btn-light " @click.stop="sideBar = !sideBar">
            <span class="sr-only">Menu</span>
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                    clip-rule="evenodd" />
            </svg>
        </button>
        <div class="ml-3 md:block">
            <span class="text-lg font-bold">
                {{ $modulo }}
            </span>
            <p>
                @php
                    $tcs = new \App\Services\TasaCambioService();
                @endphp
                Precio del dolar: @soles($tcs->tasa_cambio)
                @if (optional($tcs->tasa_cambio_valor)->is_desactualizado)
                    <div class="badge badge-error">Desactualizado</div>
                @endif
            </p>
        </div>
    </div>
    <div class="navbar-center md:block hidden">
        <a href="/" class="">
            <img src="{{ asset('img/logo-white.png') }}" alt="Kutty Logo" class="w-20" />
        </a>
    </div>
    <div class="navbar-end">
        @include('components.profile_dropdown')
    </div>
</div>

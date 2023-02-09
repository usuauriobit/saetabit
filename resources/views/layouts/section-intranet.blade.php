{{-- ESTAS RUTAS NO MOSTRARÁN NAVBAR --}}
@if (Route::currentRouteName() == 'intranet.login')
    {{-- <div class="py-28"></div> --}}
    {{ $slot }}
@elseif (Route::currentRouteName() == 'intranet.index')
    @include('components.navbar.navbar_intranet')
    @include('components.alerts')
    <div class="slot">
        {{ $slot }}
    </div>
@else
    @php
        $data = collect(config('modules_menu'));
        $module = $data->first(fn($value, $key): bool => Route::is($key));
    @endphp

    @if (isset($module['type_header']) && $module['type_header'] == 'horizontal')
        @include('components.navbar.navbar_module', [
            'modulo' => $module['modulo'],
        ])
        @include('components.menu-horizontal', [
            'menu' => $module['menu'],
        ])
        <div class="container w-11/12 h-64 py-3 mx-auto sm:px-4 md:w-4/5">
            @include('components.alerts')
            <div class="slot">
                {{ $slot }}
            </div>
        </div>
    @else
        <section class="min-h-screen bg-base-200" x-data="appData">
            @include('components.sidebar', [
                'modulo' => $module['modulo'],
                'menu' => $module['menu'],
            ])
            <div class="ml-0 transition md:ml-60" :class=" sideBar ? 'md:ml-60' : ''">
                @include('components.navbar.navbar_module', [
                    'modulo' => $module['modulo'],
                ])
                <div class="" style="margin-bottom: -4px">
                    <div class="progress-line"
                        x-data="{ loading: false }"
                        x-show="loading"
                        @loading.window="loading = $event.detail.loading"
                    ></div>
                    <!-- Add content here, remove div below -->
                    {{ $slot }}
                </div>
            </div>
            <div class="fixed inset-0 z-10 w-screen h-screen bg-black bg-opacity-25 md:hidden" x-show.transition="sideBar"
                x-cloak @click="sideBar = false"></div>
        </section>
    @endif
@endif

<nav class="fixed top-0 left-0 z-20 h-full  overflow-x-hidden overflow-y-auto transition origin-left transform bg-gray-900 w-60"
    :class="{ '-translate-x-full': !sideBar, 'translate-x-0': sideBar }"
    style="background: url('{{ asset('img/default/colorful4.jpg') }}');background-size: cover;" {{-- style="background: url({{asset('img/dark-bg-1.jpg')}}); background-position: center; background-repeat:
    no-repeat; background-size: cover" --}}>

    <div class="h-screen sidebar-content" style="background: rgba(10, 1, 37, 0.603);
        " {{-- style="background: rgba(0, 0, 0, 0.29);
        backdrop-filter: blur(9px);
        -webkit-backdrop-filter: blur(9px);" --}}>
        <nav class="text-sm font-medium text-gray-500" aria-label="Main Navigation">
            @include('components.sidebar-content', [
                'menu' => $menu,
            ])
        </nav>
    </div>

</nav>

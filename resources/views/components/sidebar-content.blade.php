<div class="flex items-center w-full">
    <a class="my-6" href="{{ route('intranet.index') }}">
        <img src="{{ asset('img/logo-white.png') }}" width="144" height="30" alt="">
    </a>
</div>
<ul class="">
    @foreach ($menu as $item)
        @if (isset($item['navhead']))
            <li class="px-4 pt-3">
                <span class="text-sm text-gray-500">
                    <strong>{{ strtoupper($item['navhead']) }}</strong>
                </span>
            </li>
        @elseif (isset($item['submenu']))
            <li>
                <div class="collapse rounded-box border-base-300 collapse-arrow">
                    <input type="checkbox">
                    <div class="text-white collapse-title">
                        <a href="#" class="flex items-center w-full text-white">
                            <i class="la la-history"></i>
                            <span class="ml-2 text-sm"> {{ $item['submenu']['header'] }} </span>
                        </a>
                    </div>
                    <div class="text-white collapse-content">
                        <ul>
                            @include('components.navbar.sidebar-menu-item', [
                                'item' => $item['submenu']['menu'],
                            ])
                        </ul>
                    </div>
                </div>
            </li>
        @else
            @if ((isset($item['permission']) && Auth::user()->can($item['permission'])) || !isset($item['permission']))
                @include('components.navbar.sidebar-menu-item', [
                    'item' => $item,
                ])
            @endif
        @endif
    @endforeach
</ul>

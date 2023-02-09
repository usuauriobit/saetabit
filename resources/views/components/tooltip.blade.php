{{-- <div class="tooltip tooltip-left w-full" data-tip="{{ $content }}" data-html="true">
    {{ $activator }}
</div> --}}
<span style="z-index: 2" x-data="{ tooltip: false }" x-on:mouseover="tooltip = true" x-on:mouseleave="tooltip = false"
    class="w-5 h-5 ml-2 cursor-pointer">
    <!-- SVG Goes Here -->
    <i class="la la-info"></i>
    <div x-show="tooltip"
        class="absolute p-2 text-sm text-black transform translate-x-8 -translate-y-8 bg-white shadow rounded-lg">
        {{ $slot }}
    </div>
</span>

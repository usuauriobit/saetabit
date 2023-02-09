<div id="{{$idModal}}" class="modal" wire:ignore.self>
    <div class="overflow-y-auto
        @if (!$wSize)
            @if ($wSize == 'lg') sm:max-w-lg
            @elseif($wSize == 'xl') sm:max-w-xl
            @elseif($wSize == '2xl') sm:max-w-2xl
            @elseif($wSize == '4xl') sm:max-w-4xl
            @elseif($wSize == '6xl') sm:max-w-6xl
            @elseif($wSize == 'full') sm:max-w-full
            @endif
        @endif
         {{!is_null($wSize) ? "sm:max-w-{$wSize}" : ''}}
         max-h-5/6 modal-box">
        <div class="flex items-center justify-between pb-2">
            <div class="text-lg font-bold">
                {{$label}}
            </div>
            <div class="text-right">
                <a href="#" class="btn btn-outline btn-sm btn-circle ">
                    <i class="la la-close"></i>
                </a>
            </div>
        </div>
        {{$slot}}
    </div>
</div>

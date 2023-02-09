<div {{$attributes}}>
    <div class="flex items-center ">
        {{$avatar ?? ''}}
        <div class="flex items-center justify-between w-full"  >
            <div class="{{!$noPadding ? 'px-3': '' }} ">
                <p tabindex="0" class="text-{{$labelSize}} font-medium leading-5 text-gray-800 focus:outline-none">{{$label}}</p>
                @if (!is_null($sublabel))
                    <p tabindex="0" class="text-sm leading-normal text-gray-500 focus:outline-none">{{ $sublabel }}</p>
                @endif
            </div>
            <div>
                {{$actions}}
            </div>
        </div>
    </div>
</div>

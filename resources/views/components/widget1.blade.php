<div class="text-center">
    {{$icon ?? ''}}
    <br>
    <strong>{{ $title }}</strong>
    <p class="mt-2 text-3xl">
        {{$value}} {{$suffix}}
    </p>
    {{$result}}
    @if ($diffValue)
        <span class="text-{{$diffState}}">
            <i class="las la-caret-{{$diffState == 'success' ? 'up' : 'down'}}"></i>
             {{$diffValue}}
            {{$diffSuffix}}
        </span>
    @endif
</div>
{{$footer}}

@if ($footerValue)
    <div class="flex justify-between mt-2 text-sm text-gray-400">
        <span class="font-bold">{{$footerDesc }}</span>
        <span class="text-right">{{$footerValue }}</span>
    </div>
@endif

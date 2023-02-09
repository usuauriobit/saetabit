<div class=" mb-7">
    <div class="text-2xl font-bold">
        <i class="las la-plane-{{ $type == 'ida' ? 'departure' : 'arrival' }}"></i> {{ strtoupper($type) }}
    </div>
    <span class="text-gray-400">
        | {{ $fecha }}
    </span>
</div>

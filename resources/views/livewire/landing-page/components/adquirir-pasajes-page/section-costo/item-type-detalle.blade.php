@if (count($this->{'vuelos_' . $type . '_selected'}) == 0)
    <div class="alert shadow-sm">
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                class="stroke-info flex-shrink-0 w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>Seleccione un vuelo de ida.</span>
        </div>
    </div>
@else
    @foreach ($this->{"tarifas_$type"} as $tarifa)
        <div class="flex justify-between">
            <span>{{ $tarifa['nro'] }} {{ $tarifa['descripcion'] }}</span>
            @if ($tarifa['tarifa']['is_dolarizado'])
                <strong>@toSoles($tarifa['nro'] * $tarifa['tarifa']['precio'])</strong>
            @else
                <strong>@soles($tarifa['nro'] * $tarifa['tarifa']['precio'])</strong>
            @endif
        </div>
    @endforeach
    <div class="flex justify-between">
        <strong>Total</strong>
        <strong>@soles($this->{"monto_total_$type"})</strong>
    </div>
@endif

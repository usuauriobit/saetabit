<div>
    <strong>{{ $descuento->descripcion }}</strong>
    @php
        $descuento_monto = $descuento->getMonto($this->pasaje->tarifa);
    @endphp
    <div>
        <div class="badge badge-success">
            {{-- @if ($descuento->is_dolarizado)
                @dolares($descuento_monto)
            @else
                @soles($descuento_monto)
            @endif --}}

            @if (isset($descuento->descuento_porcentaje) && intval($descuento->descuento_porcentaje) !== 0)
                (- @nro($descuento->descuento_porcentaje)%)
            @elseif (isset($descuento->descuento_monto) && intval($descuento->descuento_monto) !== 0)
                (-
                    @if ($descuento->is_dolarizado)
                        @dolares($descuento->descuento_monto)
                    @else
                        @soles($descuento->descuento_monto)
                    @endif
                )
            @endif
        </div>
        @if ($descuento->is_dolarizado)
            <div class="badge badge-primary">
                ≈ @toSoles(floatval($descuento_monto))
                @if (isset($descuento->descuento_porcentaje) && intval($descuento->descuento_porcentaje) !== 0)
                    (- @nro($descuento->descuento_porcentaje)%)
                @elseif (isset($descuento->descuento_monto) && intval($descuento->descuento_monto) !== 0)
                    (- ≈ @toSoles($descuento->descuento_monto))
                @endif
            </div>
        @endif
    </div>
</div>

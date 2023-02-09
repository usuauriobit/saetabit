<div>
        @include('components.intranet.section-cliente', [
            'cliente' => $comprador,
            'no_ruc' => $this->no_ruc
        ])
    {{-- @if ($this->is_with_venta)
    @else --}}
        {{-- <div class="card-white">
            <div class="card-body">
                <div class="alert">
                    <div class="flex-1">
                        <label>
                            Esta adquisición de pasaje(s) no pasará por caja.
                            <strong>Sin embargo </strong> la relación de pasajes con monto S/. 0.00
                            aparecerán en relación de reportes.
                        </label>
                    </div>
                </div>
            </div>
        </div> --}}
    {{-- @endif --}}
</div>

<div x-data>
    @include('livewire.intranet.comercial.cliente.show.info-card')
    <div class="" x-cloak>
        <div>
            @can('intranet.comercial.cliente.pago.index')
                <div x-show="$wire.tab == 'pagos'" x-transition:enter.duration.500ms>
                    @include('livewire.intranet.comercial.cliente.show.section-pagos')
                </div>
            @endcan
            @can('intranet.comercial.cliente.pasaje.index')
                <div x-show="$wire.tab == 'vuelos'" x-transition:enter.duration.500ms>
                    @include('livewire.intranet.comercial.cliente.show.section-vuelos')
                </div>
            @endcan
            @can('intranet.comercial.cliente.guia-despacho.index')
                @if (get_class($cliente) == 'App\Models\Persona')
                    <div x-show="$wire.tab == 'encomiendas'" x-transition:enter.duration.500ms>
                        @include('livewire.intranet.comercial.cliente.show.section-encomiendas')
                    </div>
                @endif
            @endcan
        </div>
    </div>
</div>

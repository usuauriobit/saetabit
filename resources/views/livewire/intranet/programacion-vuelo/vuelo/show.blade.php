<div x-data="app()" x-init="$wire.on('avionSetted', () => {
    toEditAvion = false
})">
    <div class="">
        <div class="bg-white">
            <x-item.vuelo-horizontal-simple transparent :vuelos="[$vuelo]" />
            <div class="w-full tabs tabs-boxed">
                <a class="tab {{ $tab == 'resumen' ? ' tab-active' : '' }}" wire:click="setTab('resumen')">Resúmen</a>
                <a class="tab {{ $tab == 'pasajeros' ? ' tab-active' : '' }}"
                    wire:click="setTab('pasajeros')">Pasajeros</a>
                <a class="tab {{ $tab == 'cargas' ? ' tab-active' : '' }}" wire:click="setTab('cargas')">Cargas y encomiendas</a>
                <a class="tab {{ $tab == 'avion' ? ' tab-active' : '' }}" wire:click="setTab('avion')">
                    Avión
                    @if (!$vuelo->avion)
                        <i class="text-red-500 las la-dot-circle"></i>
                    @endif
                </a>
                <a class="tab {{ $tab == 'tripulacion' ? ' tab-active' : '' }}"
                    wire:click="setTab('tripulacion')">Tripulación
                    @if (!$vuelo->piloto)
                        <i class="text-red-500 las la-dot-circle"></i>
                    @endif
                </a>
                <a class="tab {{ $tab == 'relacionados' ? ' tab-active' : '' }}" wire:click="setTab('relacionados')">
                    Vuelos en ruta
                    <span class="ml-2 badge badge-accent">
                        @if (optional(optional($vuelo->vuelo_ruta)->vuelos)->count())
                            + {{ optional(optional($vuelo->vuelo_ruta)->vuelos)->count() - 1 }}
                        @endif
                    </span>
                </a>
                <a class="tab {{ $tab == 'incidencias' ? ' tab-active' : '' }}"
                    wire:click="setTab('incidencias')">Incidencias</a>
                <a class="tab {{ $tab == 'reportes' ? ' tab-active' : '' }}"
                    wire:click="setTab('reportes')">Reportes</a>
                @can('intranet.comercial.pasaje.comprobantes.index')
                    <a class="tab {{ $tab == 'comprobantes' ? ' tab-active' : '' }}"
                        wire:click="setTab('comprobantes')">Comprobantes</a>
                @endcan
                <a class="tab {{ $tab == 'otros' ? ' tab-active' : '' }}" wire:click="setTab('otros')">Otros</a>
                <a class="tab" wire:loading>
                    @include('components.loader-horizontal-sm')
                </a>
            </div>
        </div>
    </div>

    <div class="mt-4">

        <div class="card-body">
            @if ($tab == 'resumen')
                <livewire:intranet.programacion-vuelo.vuelo.show.section-resumen key="{{ now() }}"
                    :vuelo="$vuelo">
            @endif
            @if ($tab == 'pasajeros')
                <livewire:intranet.programacion-vuelo.vuelo.show.section-pasajeros :vuelo="$vuelo"
                    key="{{ now() }}">
            @endif
            @if ($tab == 'cargas')
                <livewire:intranet.programacion-vuelo.vuelo.show.section-cargas :vuelo="$vuelo"
                    key="{{ now() }}">
            @endif
            @if ($tab == 'avion')
                <livewire:intranet.programacion-vuelo.vuelo.show.section-avion :vuelo="$vuelo"
                    key="{{ now() }}">
            @endif
            @if ($tab == 'tripulacion')
                <livewire:intranet.programacion-vuelo.vuelo.show.section-tripulacion :vuelo="$vuelo"
                    key="{{ now() }}">
            @endif
            @if ($tab == 'relacionados')
                @include('livewire.intranet.comercial.vuelo.components.tab_relacionados')
            @endif
            @if ($tab == 'incidencias')
                <livewire:intranet.programacion-vuelo.vuelo.show.section-incidencias :vuelo="$vuelo"
                    key="{{ now() }}">
            @endif
            @if ($tab == 'reportes')
                <livewire:intranet.programacion-vuelo.vuelo.show.section-reportes :vuelo="$vuelo"
                    key="{{ now() }}">
            @endif
            @if ($tab == 'comprobantes')
                @can('intranet.programacion-vuelo.vuelo.comprobantes.index')
                    <div wire:key="sectionComprobantes">
                        @include('livewire.intranet.programacion-vuelo.vuelo.show.section-comprobantes')
                    </div>
                @endcan
            @endif
            @if ($tab == 'otros')
                @include('livewire.intranet.comercial.vuelo.components.tab_otros')
            @endif
        </div>
    </div>
    <script>
        var options = {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            locale: {
                firstDayOfWeek: 1,
                weekdays: {
                    shorthand: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                    longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                },
                months: {
                    shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Оct', 'Nov', 'Dic'],
                    longhand: ['Enero', 'Febreo', 'Мarzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre',
                        'Octubre', 'Noviembre', 'Diciembre'
                    ],
                },
            },
        };

        function app() {
            return {
                tab: 'resumen',
                toEditAvion: false
            }
        }
        document.addEventListener('livewire:load', function() {
            flatpickr("#input_hora_despegue", {
                ...options,
                defaultDate: @this.monitoreo_form['hora_despegue']
            });
            flatpickr("#input_hora_aterrizaje", {
                // enableTime: true,
                ...options,
                defaultDate: @this.monitoreo_form['hora_aterrizaje']
            });
        })
    </script>
</div>

@section('script')
@endsection

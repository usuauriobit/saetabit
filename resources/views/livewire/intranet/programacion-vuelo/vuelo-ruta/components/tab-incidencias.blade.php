<div x-data="{tab_incidencia: 'incidencia_{{ $vuelo_ruta->vuelos[0]->codigo }}'}">

    <div class="">
        <div class="w-full tabs tabs-boxed">
            @foreach ($vuelo_ruta->vuelos as $vuelo)
                <a class="tab "
                    @click="tab_incidencia = 'incidencia_'+'{{ $vuelo->codigo }}'"
                    :class="{ 'tab-active ' : tab_incidencia == 'incidencia_{{ $vuelo->codigo }}' }">
                    Vuelo {{ $vuelo->codigo }}
                </a>
            @endforeach
        </div>
        @foreach ($vuelo_ruta->vuelos as $vuelo)
            <div x-show="tab_incidencia == 'incidencia_{{ $vuelo->codigo }}'" x-transition:enter.duration.500ms>
                <livewire:intranet.programacion-vuelo.vuelo.show.section-incidencias :vuelo="$vuelo">
            </div>
        @endforeach
    </div>
</div>

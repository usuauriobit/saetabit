<div x-data="{tab: 'avion'}">
    <div class="my-4 tabs tabs-boxed">
        <a class="tab" @click="tab = 'avion'" :class="{ 'tab-active' : tab == 'avion' }">De avión</a>
        <a class="tab" @click="tab = 'tripulacion'" :class="{ 'tab-active' : tab == 'tripulacion' }">De tripulación</a>
        <a class="tab" @click="tab = 'fecha'" :class="{ 'tab-active' : tab == 'fecha' }">De Fecha</a>
        <a class="tab" @click="tab = 'ruta'" :class="{ 'tab-active' : tab == 'ruta' }">De Ruta</a>
        {{-- <a class="tab" @click="tab = 'vuelo'" :class="{ 'tab-active' : tab == 'vuelo' }">De vuelo</a> --}}
    </div>
    <div>
        <div x-show="tab == 'avion'">
            <livewire:intranet.comercial.vuelo.components.section-incidencias.section-incidencia-avion :vuelo="$vuelo"/>
        </div>
        <div x-show="tab == 'tripulacion'">
            <livewire:intranet.comercial.vuelo.components.section-incidencias.section-incidencia-tripulacion :vuelo="$vuelo"/>
        </div>
        <div x-show="tab == 'fecha'">
            <livewire:intranet.comercial.vuelo.components.section-incidencias.section-incidencia-fecha :vuelo="$vuelo"/>
        </div>
        <div x-show="tab == 'ruta'">
            <livewire:intranet.comercial.vuelo.components.section-incidencias.section-incidencia-ruta :vuelo="$vuelo"/>
            {{-- <livewire:intranet.comercial.vuelo.components.section-incidencias.section-incidencia-vuelo :vuelo="$vuelo"/> --}}
        </div>
    </div>

</div>

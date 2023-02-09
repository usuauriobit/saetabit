<div x-data class=" p-6">
    @section('title', __('Tarifas'))
    <div class="cabecera">
        <x-master.item label="{{ ucfirst('Tarifas') }}" sublabel="Lista de Tarifas">
            {{-- <x-slot name="actions">
                <a href="{{ route('intranet.comercial.tarifa.create') }}" class="btn btn-primary"> <i class="la la-plus"></i>
                    Agregar</a>
            </x-slot> --}}
        </x-master.item>
    </div>

    <div class="mb-4 tabs tabs-boxed">
        <a class="tab" :class="{ 'tab-active': $wire.tab == 'comerciales' }"
            @click="$wire.setTab('comerciales')">Tarifas comerciales</a>
        <a class="tab" :class="{ 'tab-active': $wire.tab == 'subvencionados' }"
            @click="$wire.setTab('subvencionados')">Tarifas subvencionados</a>
        <a class="tab" :class="{ 'tab-active': $wire.tab == 'no-regular' }"
            @click="$wire.setTab('no-regular')">Tarifas No regular</a>
    </div>

    <div class="my-4 ">
        @foreach ($ubicaciones as $ubicacion)
            <button
                class="p-4 mt-2 badge badge-accent {{ $ubicacion_selected !== $ubicacion->id ? 'badge-outline' : '' }}"
                wire:click="setUbicacionSelected({{ $ubicacion->id }})">
                {{ $ubicacion->ubigeo->distrito }}
            </button>
        @endforeach
    </div>

    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
        @foreach ($this->rutas as $ruta)
            @include('livewire.intranet.comercial.tarifa.index.card-info')
        @endforeach
    </div>
    @if (isset($tarifa_edit))
        <x-master.modal id-modal="modalEditarTarifa" label="Editar tarifa">
            <livewire:intranet.comercial.tarifa.edit wire:key="tarifaEditModal{{ now() }}" :tarifa="$tarifa_edit" />
        </x-master.modal>
    @endif
    @if (isset($create_ruta))
        <x-master.modal idModal="createModal">
            <livewire:intranet.comercial.tarifa.create wire:key="createModal{{ now() }}" :ruta="$create_ruta" />
        </x-master.modal>
    @endif

</div>
@section('script')
    <script>
        Livewire.on('openModalEditTarifa', () => {
            window.location.href = "#modalEditarTarifa"
        })
        Livewire.on('openModalCreateTarifa', () => {
            window.location.href = "#createModal"
        })
    </script>
@endsection

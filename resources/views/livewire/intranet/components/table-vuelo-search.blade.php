<div>
    <x-master.item>
        <x-slot name="actions">
            <div class="grid grid-cols-4 gap-4 align-items-end">

                <x-master.select label="Tipo de vuelo"/>
                @if (!$origen)
                    <livewire:intranet.comercial.vuelo.components.input-ubicacion
                        label="Seleccionar origen"
                        nameEvent="origenSelected"
                    />
                @else
                    <x-master.item label="Origen" :sublabel="$origen->descripcion">
                        <x-slot name="actions">
                            <button class="btn btn-outline btn-secondary" wire:click="removeOrigen">
                                <i class="la la-refresh"></i>
                                Volver a elegir
                            </button>
                        </x-slot>
                    </x-master.item>
                @endif
                @if ()
                    <livewire:intranet.comercial.vuelo.components.input-ubicacion
                        label="Seleccionar destino"
                        nameEvent="destinoSelected"
                    />
                @else
                    <x-master.item label="Destino" :sublabel="$destino->descripcion">
                        <x-slot name="actions">
                            <button class="btn btn-outline btn-secondary" wire:click="removeDestino">
                                <i class="la la-refresh"></i>
                                Volver a elegir
                            </button>
                        </x-slot>
                    </x-master.item>
                @endif
                <button class="btn btn-primary" wire:click="searchVuelos">
                    <i class="la la-search"></i> Buscar
                </button>
            </div>
        </x-slot>
    </x-master.item>
    <table class="table table-striped w-full mt-3">
        <thead>
            <tr>
                <th>Origen</th>
                <th>Destino</th>
                <th>Nro escalas</th>
                <th>Nro asientos <br> disponibles</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($vuelos as $vuelo)
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

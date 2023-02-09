<div>
    <h4 class="text-lg font-semibold">Datos para Proforma</h4>
    <form wire:submit.prevent="generarPdf()">
        <div wire:loading class="w-full">
            <div class="loader">Cargando...</div>
        </div>
        <div wire:loading.remove>
            <div class="grid grid-cols-2 gap-4">
                <x-master.select name="form.tipo_vuelo_id" label="Tipo de Vuelo" wire:model.defer="form.tipo_vuelo_id" :options="$tipo_vuelos" required></x-master.select>
                <x-master.input name="form.fecha" label="Fecha" wire:model.defer="form.fecha" type="date" required />
            </div>
            <x-master.input name="form.cliente" label="Cliente" wire:model.defer="form.cliente" type="text" required />
            <div class="mt-6">
                @if (!$avion)
                    <livewire:intranet.comercial.vuelo.components.input-avion />
                @else
                    <x-master.item label="Avión" :sublabel="$avion->matricula">
                        <x-slot name="avatar">
                            <i class="las la-plane"></i>
                        </x-slot>
                        <x-slot name="actions">
                            <button wire:click="removeAvion" class="btn btn-outline btn-sm btn-error"><i class="la la-history"></i>Volver a elegir</button>
                        </x-slot>
                    </x-master.item>
                @endif
            </div>
            <div class="mt-6">
                @if (!$ubicacion_origen)
                    <livewire:intranet.comercial.vuelo.components.input-ubicacion label="Buscar ubicación de origen" type="origen"/>
                @else
                    <x-master.item label="Origen" :sublabel="$ubicacion_origen->distrito">
                        <x-slot name="actions">
                            <button class="btn btn-outline btn-secondary" wire:click="removeUbicacionOrigen">
                                <i class="la la-refresh"></i>
                                Volver a elegir
                            </button>
                        </x-slot>
                    </x-master.item>
                @endif
            </div>
            <div class="mt-6">
                @if (!$ubicacion_destino)
                    <livewire:intranet.comercial.vuelo.components.input-ubicacion label="Buscar ubicación de destino" type="destino"/>
                @else
                    <x-master.item label="Destino" :sublabel="$ubicacion_destino->distrito">
                        <x-slot name="actions">
                            <button class="btn btn-outline btn-secondary" wire:click="removeUbicacionDestino">
                                <i class="la la-refresh"></i>
                                Volver a elegir
                            </button>
                        </x-slot>
                    </x-master.item>
                @endif
            </div>
            <x-master.input name="form.precio" label="Precio" wire:model.defer="form.precio" type="number" step="0.01" required />
        </div>
        <div class="modal-action">
            <a href="#" class="btn btn-ghost">Cancelar</a>
            <button type="submit" wire:loading.attr="disabled" class="btn btn-success">
                Generar
            </button>
        </div>
    </form>
</div>

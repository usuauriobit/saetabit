<span class="text-lg font-bold text-gray-500">Origen</span>
@if (isset($form['origen_id']))
    <div class="">
        <x-item.ubicacion :ubicacion="$ubicacion_origen">
            <x-slot name="actions">
                <button class="btn btn-sm btn-primary btn-outline"
                    wire:click="removeUbicacionOrigen">
                    <i class="la la-refresh"></i>
                </button>
            </x-slot>
        </x-item.ubicacion>
    </div>
@else
    <livewire:intranet.comercial.vuelo.components.input-ubicacion type="origen" />
@endif
<div class="mt-4 ">
    <span class="mt-4 text-lg font-bold text-gray-500">Destino</span>
</div>
@if (isset($form['destino_id']))
    <div class="">
        <x-item.ubicacion :ubicacion="$ubicacion_destino">
            <x-slot name="actions">
                <button class="btn btn-sm btn-primary btn-outline"
                    wire:click="removeUbicacionDestino">
                    <i class="la la-refresh"></i>
                </button>
            </x-slot>
        </x-item.ubicacion>
    </div>
@else
    <livewire:intranet.comercial.vuelo.components.input-ubicacion type="destino" />
@endif

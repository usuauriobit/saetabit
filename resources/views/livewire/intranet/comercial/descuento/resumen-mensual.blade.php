<div class="cabecera p-6">
    <x-master.item label="Resumen de descuentos aplicados" sublabel="Resumen por fechas y rutas">
        <x-slot name="actions">
            {{-- <div class="flex items-end gap-4">
                <div class="p-2 border-2 border-primary rounded-box">
                    @if (!$this->ruta)
                        <livewire:intranet.comercial.vuelo.components.input-ruta just-comercial />
                    @else
                        <div class="flex items-end gap-4">
                            <x-item.ruta :ruta="$this->ruta" :isSimple="true"/>
                            <button class="mt-3 btn btn-primary btn-outline" wire:click="deleteRuta" >
                                <div wire:loading>
                                    @include('components.loader-horizontal-sm')
                                </div>
                                <div wire:loading.remove>
                                    <i class="la la-refresh"></i>
                                </div>
                            </button>
                        </div>
                    @endif
                </div>
                <x-master.select
                    label="Clasificación"
                    :options="$clasificacions"
                    wire:model="clasificacion_id"
                />
                <x-master.select
                    label="Estado"
                    :options="$estados"
                    wire:model="estado_id"
                /> --}}
</div>
</x-slot>
</x-master.item>
</div>

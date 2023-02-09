<div class="mt-4">
    @if (isset($tiempo_avion_tramo))
    <div class="card-white max-w-2xl mx-auto">
        <div class="card-body">
            <div class="text-2xl font-bold">Editar registro</div>
            <x-master.item label="Avion" sublabel="{{ optional($tiempo_avion_tramo->avion)->matricula }}"></x-master.item>
            <x-master.item label="Tramo" class="my-4" >
                <x-slot name="sublabel">
                    {{ optional(optional($tiempo_avion_tramo->tramo)->origen)->distrito }}
                    <i class="las la-arrow-right"></i>
                    {{ optional(optional($tiempo_avion_tramo->tramo)->destino)->distrito }}
                </x-slot>
            </x-master.item>
            <div class="alert alert-info">
                <div class="flex items-center">
                    <i class="las la-info-circle mr-4"></i>
                    <span>El tiempo de vuelo también será modificado en el tramo inverso.</span>
                </div>
            </div>
            <div>
                <x-master.input label="Tiempo de vuelo (min)" wire:model="form.tiempo_vuelo" type="number" step="0.01"></x-input>
                <button wire:loading.attr='disabled' onclick="confirm('¿Está seguro de guardar? ')||event.stopImmediatePropagation()" wire:click="save" class="btn btn-primary w-full mt-4">Guardar</button>
            </div>
        </div>
    </div>
    @else
    <div class="card-white white max-w-2xl mx-auto">
        <div class="card-body">
            <div class="text-2xl font-bold">Crear registro</div>
            <div class="my-4">
                @if ($tramo_selected)
                    <x-master.item label="Tramo" class="my-4" >
                        <x-slot name="sublabel">
                            {{ optional($tramo_selected->origen)->distrito }}
                            <i class="las la-arrow-right"></i>
                            {{ optional($tramo_selected->destino)->distrito }}
                        </x-slot>
                        <x-slot name="actions">
                            <button wire:click="deleteTramo" class="btn btn-error btn-sm">
                                <i class="las la-times"></i>
                            </button>
                        </x-slot>
                    </x-master.item>
                @else
                    <livewire:intranet.components.input-tramo :with-escala="false">
                @endif
            </div>
            <div>
                <x-master.input label="Tiempo de vuelo (min)" wire:model="form.tiempo_vuelo" type="number" step="0.01"></x-input>
                <button wire:loading.attr='disabled' onclick="confirm('¿Está seguro de guardar?')||event.stopImmediatePropagation()" wire:click="store" class="btn btn-primary w-full mt-4">Guardar</button>
            </div>
        </div>
    </div>
    @endif
    {{-- The best athlete wants his opponent at his best. --}}
</div>

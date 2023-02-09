<div>
    @if ($isCliente)
        <div class="p-6 card bordered">
            <strong>Tipo de persona</strong>
            @if (!$noRuc)
                <div class="form-control">
                    <label class="cursor-pointer label">
                        <span class="label-text">Con RUC</span>
                        <input type="radio" wire:model="tipoCliente" checked="checked" class="radio radio-primary"
                            value="persona_juridica">
                    </label>
                </div>
            @endif
            <div class="form-control">
                <label class="cursor-pointer label">
                    <span class="label-text">Sin RUC</span>
                    <input type="radio" wire:model="tipoCliente" checked="checked" class="radio radio-primary"
                        value="persona_natural">
                </label>
            </div>
        </div>
    @endif
    @if (!$is_manually)
        <div class="flex items-end gap-4">

            <x-master.input type="text" name="search" :label="$tipoCliente == 'persona_natural' ? $label : 'Buscar empresa o persona jurídica'" wire:model.defer="search" :placeholder="$tipoCliente == 'persona_natural' ? 'Buscar por dni o documento' : 'Buscar por ruc'"
                :disabled="$disabled">
                <x-slot name="suffix">
                    <button type="button" wire:click="searchPersona" class="btn btn-primary">
                        <i class="la la-search"></i>
                    </button>
                </x-slot>
            </x-master.input>
            @if (!$isCliente)
                <button wire:click="setManually" type="button" class="btn btn-success">
                    <i class="la la-plus"></i> Agregar manualmente
                </button>
            @endif
        </div>
    @else
        <livewire:intranet.configuracion.persona.create :is-component="true" />
    @endif

</div>

<div class="p-4">
    <form wire:submit.prevent="save">
        <x-master.item class="mb-4" label="Registro de personal">
            <x-slot name="actions">
                <button type="submit" wire:loading.attr="disabled" class="btn btn-primary"> <i class="la la-save"></i>
                    Guardar</button>
            </x-slot>
        </x-master.item>
        <div wire:loading class="w-full">
            <div class="loader">Cargando...</div>
        </div>
        <div>
            <div class="card-white card-body">
                @foreach ($errors->all() as $message)
                    <div class="alert alert-warning mb-2" role="alert">
                        {{ $message }}
                    </div>
                @endforeach
                <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                    <div class="col-span-1"  wire:loading.remove>
                        @if ($this->persona)
                        <x-master.item label="Persona">
                            <x-slot name="sublabel">
                                {{ $this->persona->nombre_short }}
                                <div class="badge success">
                                    {{ $this->persona->nro_doc }}
                                </div>
                            </x-slot>
                            <x-slot name="actions">
                                <button class="btn btn-primary btn-outline" wire:click="eliminarPersona">
                                    <i class="la la-trash"></i>
                                </button>
                            </x-slot>
                        </x-master.item>
                        @else
                            <livewire:intranet.components.input-persona
                                create-persona-modal="#createRemitenteModal"
                                emit-event="personaFounded" label="Buscar persona" />
                        @endif
                    </div>
                    <div class="col-span-1">
                        <x-master.select name="form.oficina_id" label="Oficina" wire:model.defer="form.oficina_id"
                            :options="$oficinas">
                        </x-master.select>
                        <x-master.input name="form.fecha_ingreso" label="Fecha ingreso" wire:model.defer="form.fecha_ingreso"
                            type="date"></x-master.input>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

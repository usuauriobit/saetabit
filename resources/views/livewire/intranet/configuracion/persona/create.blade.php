<div >
    <div class="card-white">
        <div class="card-body">
            @include('components.alert-errors')
            <h4 class="text-lg font-semibold">{{ $persona ? 'Editar persona' : 'Registrar persona' }}</h4>
            <form wire:submit.prevent="save">
                <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
                    <x-master.select name="form.nacionalidad_id" label="Nacionalidad" wire:model.defer="form.nacionalidad_id" :options="$nacionalidads"/>

                    @if ($this->ubigeo)
                        <x-master.item
                            label="{{ $this->ubigeo->distrito }}"
                            sublabel='{{ "{$this->ubigeo->provincia}, {$this->ubigeo->departamento}" }}'>
                            <x-slot name="actions">
                                <button type="button" class="btn btn-sm" wire:click="removeUbigeo">
                                    <i class="text-lg la la-close"></i>
                                </button>
                            </x-slot>
                        </x-master.item>
                    @else
                        <livewire:intranet.components.input-ubigeo label="Ubigeo (Locación actual)" />
                    @endif

                    @if ($this->lugar_nacimiento)
                        <x-master.item
                            label="{{ $this->lugar_nacimiento->distrito }}"
                            sublabel='{{ "{$this->lugar_nacimiento->provincia}, {$this->lugar_nacimiento->departamento}" }}'>
                            <x-slot name="actions">
                                <button type="button" class="btn btn-sm" wire:click="removeLugarNacimiento">
                                    <i class="text-lg la la-close"></i>
                                </button>
                            </x-slot>
                        </x-master.item>
                    @else
                        <livewire:intranet.components.input-ubigeo eventName="lugarNacimientoSetted" label="Lugar de nacimiento (En caso de ser peruano)" />
                    @endif

                    {{-- <x-master.select name="form.ubigeo_id" label="Ubigeo" wire:model.defer="form.ubigeo_id" :options="$ubigeos"/>
                    <x-master.select name="form.lugar_nacimiento_id" label="Lugar nacimiento" wire:model.defer="form.lugar_nacimiento_id" :options="$ubigeos"/> --}}
                </div>
                <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
                    <x-master.select name="form.tipo_documento_id" label="Tipo documento" wire:model="form.tipo_documento_id" :options="$tipo_documentos"/>
                    <x-master.input name="form.nro_doc" label="Nro doc" wire:model.defer="form.nro_doc"/>
                    <x-master.select name="form.sexo" label="Sexo" wire:model.defer="form.sexo" :options="[['id' => 1, 'descripcion' => 'Masculino'], ['id' => 0, 'descripcion' => 'Femenino']]"/>
                </div>
                <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
                    <x-master.input name="form.nombres" label="Nombres" wire:model.defer="form.nombres" type="text" required />
                    <x-master.input name="form.apellido_paterno" label="Apellido paterno" wire:model.defer="form.apellido_paterno" type="text"/>
                    <x-master.input name="form.apellido_materno" label="Apellido materno" wire:model.defer="form.apellido_materno" type="text"/>
                </div>
                <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                    <x-master.input name="form.fecha_nacimiento" label="Fecha nacimiento" wire:model.defer="form.fecha_nacimiento" type="date"/>
                    @if (!$isComponent)
                        <div>
                            @if (isset($form['photo']))
                                Imagen Preview:
                                <img src="{{ $form['photo']->temporaryUrl() }}">
                            @else
                                <img src="{{ $persona->image_url ?? null }}">
                            @endif
                            <x-master.input name="form.photo" label="Imagen" wire:model.defer="form.photo" type="file"/>
                        </div>
                    @endif
                </div>

                <div class="modal-action">
                    @if ($isComponent)
                        <a href="#" type="button" wire:click="emitCancel" class="btn btn-ghost">Cancelar</a>
                    @endif
                    {{-- <a href="{{ $routeRedirect }}" class="btn btn-ghost">Cancelar</a> --}}
                    <button type="submit" wire:loading.attr="disabled" class="btn btn-primary"> <i class="la la-save"></i>
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

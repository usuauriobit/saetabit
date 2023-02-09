<x-master.modal id-modal="createOficinaModal">
    <h4 class="text-lg font-semibold">Registro de usuario</h4>
    <form wire:submit.prevent="save">
        <div wire:loading class="w-full">
            <div class="loader">Cargando...</div>
        </div>
        <div wire:loading.remove>
            <x-master.select name="form.personal_id" label="Personal" desc="nombre_completo" wire:model.defer="form.personal_id" :options="$personals"></x-master.select>
            <x-master.input name="form.email" label="Email" wire:model.defer="form.email" type="email"></x-master.input>
            @if (!isset($user))
                <x-master.input name="form.password" label="Contraseña" wire:model.defer="form.password" type="password"></x-master.input>
                <x-master.input name="form.password_confirmation" label="Repetir contraseña" wire:model.defer="form.password_confirmation" type="password"></x-master.input>
            @endif
            <div class="grid grid-cols-1 lg:grid-cols-2">
                <div>

                    <strong>Roles</strong>
                    @foreach ($roles as $rol)
                        {{-- @php
                            $checked = '';
                            if(isset($user)){
                                foreach ($user->roles as $user_rol)
                                    if($user_rol->id == $rol->id)
                                        $checked = 'checked=""';
                            }
                        @endphp --}}
                        <div class="form-control">
                            <label class="cursor-pointer label">
                                <div class="flex items-center">
                                    <input name="form.roles.{{ $loop->index }}" wire:model.defer="form.roles.{{ $rol->id }}" value="{{$rol->id}}" type="checkbox" class="toggle">
                                    <span class="label-text"> &nbsp;&nbsp;&nbsp; {{$rol->name}}</span>
                                </div>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="modal-action">
            <a href="#" class="btn btn-ghost">Cancelar</a>
            <button type="submit" wire:loading.attr="disabled" class="btn btn-primary"> <i class="la la-save"></i>
                Guardar
            </button>
        </div>
    </form>
</x-master.modal>

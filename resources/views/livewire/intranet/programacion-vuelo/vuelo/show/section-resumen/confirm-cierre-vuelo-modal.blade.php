@if (!$vuelo->is_closed)
    <x-master.modal id-modal="cerrarVueloModal" label="Registro de cierre de vuelo">
        <form wire:submit.prevent="closeFlight">
            <div wire:loading class="w-full">
                <div class="loader">Cargando...</div>
            </div>
            <div wire:loading.remove>
                {{-- <x-master.input autocomplete="off" label="Ingrese su contraseña" type="password"
                    name="close_form.password" wire:model.defer="close_form.password">
                </x-master.input> --}}
                {{-- <input type="text" type="password" name="close_form.password" wire:model.defer="close_form.password" class="input w-full max-w-xs" /> --}}
                <div class="form-control w-full max-w-xs">
                    <label class="label">
                      <span class="label-text">Ingrese su contraseña</span>
                    </label>
                    <input type="password" name="close_form.password" wire:model.defer="close_form.password" class="input input-bordered w-full max-w-xs" />
                  </div>
            </div>
            <div class="modal-action">
                <a href="#" class="btn btn-ghost">Cancelar</a>
                <button type="submit" wire:loading.attr="disabled" class="btn btn-primary"> <i
                        class="la la-save"></i>
                    Cerrar</button>
            </div>
        </form>
    </x-master.modal>
@endif

<div>
    <x-dynamic-component :component="$componentDeclared" >
            <div wire:loading class="w-full">
                <div class="loader">Cargando...</div>
            </div>
            <div wire:loading.remove>
                <x-master.input
                    name="password_validation_req"
                    label="Ingrese su contraseña para confirmar la acción"
                    type="password"
                    data-lpignore="true"
                    wire:model.defer="password_validation_req"
                    autocomplete="new-password"
                    :upperCase="false"/>
                <x-master.input
                    name="observacion"
                    autocomplete="off"
                    label="Observación"
                    type="text"
                    wire:model.defer="observacion"/>
            </div>
            <div class="modal-action">
                @if ($hasCancelBtn)
                    <a href="#" class="btn btn-ghost">Cancelar</a>
                @endif
                <button
                    type="button"
                    wire:click="confirm"
                    wire:loading.attr="disabled" class="btn btn-primary">
                    <i class="la la-save"></i>
                    Aceptar
                </button>
            </div>
    </x-dynamic-component>
</div>

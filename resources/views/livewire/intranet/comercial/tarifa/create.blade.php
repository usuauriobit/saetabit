<div x-data>
    @section('title', __('Tarifas'))

    <form wire:submit.prevent="save">
        <div class="alert alert-info">
            <div class="flex-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    class="w-6 h-6 mx-2 stroke-current">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <label>También se agregará el registro a la ruta de vuelta</label>
            </div>
        </div>
        <x-item.ruta :ruta="$ruta" />
        {{-- <x-master.select name="form.ruta_id"  label="Ruta" wire:model.defer="form.ruta_id" :options="$rutas">
        </x-master.select> --}}
        <x-master.select name="form.tipo_pasaje_id" label="Tipo pasajero" wire:model.defer="form.tipo_pasaje_id"
            :options="$tipo_pasajes" />
        <x-master.input name="form.descripcion" label="Descripcion" wire:model.defer="form.descripcion"
            type="text" required />
        @if ($this->is_dolarizado)
            <x-master.input name="form.precio" prefix="$" label="Precio (Dólares)"
                wire:model.debounce.500ms="form.precio" type="number" required step='0.01' />
            <span wire:loading.remove>
                ≈ @soles($this->precio_soles)
            </span>
            <div wire:loading>
                @include('components.loader-horizontal-sm')
            </div>
        @else
            <x-master.input name="form.precio" prefix="S/" label="Precio" wire:model.debounce.500ms="form.precio"
                type="number" required step='0.01' />
        @endif
        <div class="modal-action">
            <a href="#" class="btn btn-ghost">Cancelar</a>
            <button type="submit" wire:loading.attr="disabled" class="btn btn-primary"> <i class="la la-save"></i>
                Guardar</button>
        </div>
    </form>
</div>

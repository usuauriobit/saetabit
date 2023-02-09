<div x-data>
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
        <div>
            <x-master.input name="form.descripcion" label="Descripción" wire:model.defer="form.descripcion">
            </x-master.input>
            <div class="grid grid-cols-2 gap-4">
                <x-master.input name="form.cantidad" label="Cantidad" type="number" step="1"
                    wire:model.defer="form.cantidad"></x-master.input>

                <x-master.input name="form.peso" label="Peso (Kg)" type="number" step="0.01"
                    wire:model.defer="form.peso">
                    <x-slot name="prefix">
                        <i class="las la-weight-hanging"></i>
                    </x-slot>
                </x-master.input>

            </div>
            <x-master.input :disabled="$guiaDespacho->is_free" prefix="S/." name="form.importe" label="Importe total" type="number" step="0.01"
                wire:model.debounce.500ms="form.importe" />

            <br>
            <div class="form-control">
                <label class="label cursor-pointer flex">
                    <div class="flex items-center">
                        <input type="checkbox" wire:model="form.is_valorado" class="checkbox" />
                        &nbsp;
                        <span class="label-text font-bold">¿Es un artículo valorado?</span>
                    </div>
                </label>
            </div>
            @if ($form['is_valorado'])
                <x-master.input :upperCase="false" name="form.monto_valorado" label="Monto de valoración (S/.)" wire:model.defer="form.monto_valorado"
                    type="number" step="0.01">
                </x-master.input>
            @endif
        </div>
        <div>
            <div class="grid grid-cols-2 gap-4">
                <div class="form-control">
                    <label class="cursor-pointer label">
                        <div class="flex items-center">
                            <input type="radio" wire:model="form.is_sobre" name="form.is_sobre" value="1"
                                class="mr-2 radio">
                            <div>
                                <img style="height:80px" src="{{ asset('img/repo/sobre-saeta.png') }}" alt="">
                                Sobre
                            </div>
                        </div>
                    </label>
                </div>
                <div class="form-control">
                    <label class="cursor-pointer label">
                        <div class="flex items-center">
                            <input type="radio" wire:model="form.is_sobre" name="form.is_sobre" value="0"
                                class="mr-2 radio radio-primary">
                            <div>
                                <img style="height:80px" src="{{ asset('img/repo/box-saeta.png') }}" alt="">
                                Paquete
                            </div>
                        </div>
                    </label>
                </div>
            </div>
            <div class="my-4" x-show="$wire.form.is_sobre == 0">
                <strong>Dimensiones</strong>
                <div class="grid items-center grid-cols-1 gap-4 lg:grid-cols-2">
                    <x-master.input name="form.alto" label="Alto (cm)" type="number" step="0.01"
                        wire:model.defer="form.alto">
                        <x-slot name="prefix">
                            <i class="las la-arrows-alt-v"></i>
                        </x-slot>
                    </x-master.input>
                    <x-master.input name="form.ancho" label="Ancho (cm)" type="number" step="0.01"
                        wire:model.defer="form.ancho">
                        <x-slot name="prefix">
                            <i class="las la-arrows-alt-h"></i>
                        </x-slot>
                    </x-master.input>
                    <x-master.input name="form.largo" label="Largo (cm)" type="number" step="0.01"
                        wire:model.defer="form.largo">
                        <x-slot name="prefix">
                            <i class="las la-level-up-alt"></i>
                        </x-slot>
                    </x-master.input>
                    {{-- <img src="{{ asset('img/repo/box-size.jpg') }}" alt=""> --}}
                </div>

            </div>
        </div>
    </div>
    <div class="modal-action">
        <a href="#" class="btn btn-ghost">Cancelar</a>
        <button type="button" wire:click="save" wire:loading.attr="disabled" class="btn btn-primary"> <i
                class="la la-save"></i>
            Guardar
        </button>
    </div>
</div>

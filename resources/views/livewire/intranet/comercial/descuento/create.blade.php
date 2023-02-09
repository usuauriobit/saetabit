<div>
    @if (!$finished)
        <div class="max-w-xl mx-auto card-white">
            <div class="card-body">

                <span class="mb-4 text-2xl font-bold">
                    {{ $is_edit ? 'Editar' : 'Registro de' }} descuento
                </span>
                @if (!$this->ruta)
                    @if (!$is_edit)
                        <livewire:intranet.comercial.vuelo.components.input-ruta />
                    @endif
                @else
                    <x-item.ruta :ruta="$this->ruta" />
                    @if (!$is_edit)
                        <button class="w-full mt-3 btn btn-primary btn-outline" wire:click="deleteRuta">Volver a
                            seleccionar ruta</button>
                    @endif
                @endif

                <x-master.select :options="$tipo_pasajes" label="Tipo de pasaje" wire:model.defer="form.tipo_pasaje_id" />

                @if (!$is_edit)
                    <div class="p-2 mt-2 border-2 border-primary rounded-box">
                        <x-master.select :options="$descuento_clasificacions" label="Clasificación"
                            wire:model="form.descuento_clasificacion_id" />
                        @isset($this->clasificacion)
                            @switch($this->clasificacion->descripcion)
                                @case('Días de anticipación')
                                    <x-master.input type="number" step="1" label="Días de anticipación"
                                        wire:model.defer="form.dias_anticipacion" />
                                @break

                                @case('Rango de edades')
                                    <div class="grid grid-cols-2 gap-4">
                                        <x-master.input type="number" step="1" label="Edad mínima"
                                            wire:model.defer="form.edad_minima" />
                                        <x-master.input type="number" step="1" label="Edad máxima"
                                            wire:model.defer="form.edad_maxima" />
                                    </div>
                                @break

                                @case('Interno')
                                    <span class="text-sm text-gray-500">
                                        Para traslado de personal o situaciones internas,
                                        este descuento no aparecerá ni será aplicado en adquisiciones desde el landing page
                                    </span>
                                @break
                            @endswitch
                        @endisset
                    </div>
                @else
                    <x-master.item class="my-4" label="Clasificación" sublabel="{{ $this->clasificacion->descripcion }}" />
                @endif

                @if (isset($ruta))
                    <div class="p-2 mt-2 border-2 border-primary rounded-box">
                        <x-master.select :options="$categoria_descuentos" label="Categoría de descuento"
                            wire:model="form.categoria_descuento_id" />
                        @switch($this->categoria->descripcion)
                            @case('Porcentaje')
                                <x-master.input type="number" step="0.01" label="Porcentaje de descuento"
                                    wire:model.debounce.500ms="form.descuento_porcentaje">
                                    <x-slot name="suffix">
                                        <span>%</span>
                                    </x-slot>
                                </x-master.input>
                            @break

                            @case('Monto restado')
                                @if ($ruta->tipo_vuelo->is_comercial)
                                    <x-master.input prefix="$" type="number" step="0.01"
                                        label="Monto que restará a la tarifa (Dólares)"
                                        wire:model.debounce.500ms="form.descuento_monto" />
                                    ≈ @toSoles($this->form['descuento_monto'])
                                @else
                                    <x-master.input prefix="$" type="number" step="0.01"
                                        label="Monto que restará a la tarifa (Soles)"
                                        wire:model.debounce.500ms="form.descuento_monto" />
                                @endif
                            @break

                            @default
                                @if ($ruta->tipo_vuelo->is_comercial)
                                    <x-master.input prefix="$" type="number" step="0.01" label="Monto que se cobrará (Dólares)"
                                        wire:model.debounce.500ms="form.descuento_fijo" />
                                    ≈ @toSoles($this->form['descuento_fijo'])
                                @else
                                    <x-master.input prefix="$" type="number" step="0.01"
                                        label="Monto que restará a la tarifa (Soles)"
                                        wire:model.debounce.500ms="form.descuento_monto" />
                                @endif
                        @endswitch
                    </div>
                @else
                    <div class="alert alert-info mt-2">
                        Selecciona una ruta para ver las opciones de descuento
                    </div>
                @endif

                <x-master.input label="Descripción" wire:model.defer="form.descripcion" />

                <x-master.input label="Fecha de expiración" wire:model.defer="form.fecha_expiracion" type="date" />
                <x-master.input label="Nro máximo" wire:model="form.nro_maximo" type="number" step="1" />

                <div class="my-4 form-control">
                    <label class="cursor-pointer label">
                        <div>
                            <input value="1" type="checkbox" name="form.is_automatico"
                                class="radio checked:bg-red-500" wire:model.defer="form.is_automatico">
                            <span class="label-text">El descuento se aplica automáticamente</span>
                        </div>
                        <br>
                    </label>
                    <span class="text-sm text-gray-500">Esta opción aplicará el cálculo para el descuento automático
                        desde la página de adquisición de pasajes en el landing page</span>
                </div>
                @can('intranet.comercial.descuento.create')
                    <button onclick="confirm('¿Está seguro?')||event.stopImmediatePropagation()" wire:click="save"
                        class="btn btn-primary">
                        <i class="text-xl la la-save"></i> Guardar
                    </button>
                @endcan
            </div>
        </div>
    @else
        <div class="card-white">
            <div class="text-center card-body">
                <span class="my-4 text-2xl">Se registró correctamente</span>

                <a class="btn btn-outline" href="{{ route('intranet.comercial.descuento.index') }}">
                    <i class="la la-arrow-left"></i> Ir a la lista de descuentos
                </a>

            </div>
        </div>
    @endif
    {{-- Success is as dangerous as failure. --}}
</div>

<div>
    <div class="container mx-auto ">
        <div class="grid grid-cols-4 gap-4 my-10">
            <div class="col-span-3">
                @foreach ($this->type as $type)
                    @include('livewire.landing-page.components.adquirir-pasajes-page.section-type', [
                        'type' => $type,
                        'fecha' => $this->{'fecha_' . $type . '_obj'}
                            ? $this->{'fecha_' . $type . '_obj'}->format('d ') .
                                $this->{'fecha_' . $type . '_obj'}->formatLocalized('%B ') .
                                $this->{'fecha_' . $type . '_obj'}->format('Y')
                            : 'Seleccione una fecha',
                    ])

                    @forelse ($this->{'vuelos_'.$type.'_founded'} as $vuelos)
                        <livewire:intranet.comercial.adquisicion-pasaje.components.item-vuelo-select
                            wire:key="{{ $type }}{{ now() }}" :vuelos="$vuelos" :paramEmitEvent="['type' => $type, 'index' => $loop->index]"
                            hideAsientosDisponibles hideCodigo :is-already-selected="!empty($this->{'vuelos_' . $type . '_selected'}) &&
                                $vuelos[0]['id'] == $this->{'vuelos_' . $type . '_selected'}[0]['id']" />
                    @empty
                        <div class="my-6 text-center">
                            No se encontraron vuelos para esta fecha
                        </div>
                    @endforelse
                    <br>
                @endforeach
            </div>
            <div class="col-span-1 mb-10">
                @if (config('app.BUY_ONLINE'))
                    <livewire:landing-page.components.adquirir-pasajes-page.section-costo wire:key="'sc'{{ now() }}"
                        :vuelos_ida_selected="$vuelos_ida_selected" :vuelos_vuelta_selected="$vuelos_vuelta_selected" :is_ida_vuelta="$is_ida_vuelta" :nro_pasajes="$nro_pasajes" />
                @else
                    <div class="card-white">
                        <div class="card-body">
                            <div class="text-2xl">
                                <i style="font-size: 50px" class="las la-info-circle text-primary mb-2"></i>
                            </div>
                            <div class="text-lg">
                                <span class="font-bold text-xl">¡Atención!</span>
                                <br>
                                <span class="text-gray-500 mt-2">
                                    El sistema de compra de pasajes en línea se encuentra en mantenimiento.
                                    <br> <br>
                                    Por favor, comuníquese con nosotros para realizar su compra.
                                </span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

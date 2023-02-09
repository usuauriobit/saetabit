<div class="p-6">
    @include('components.alert-errors')
    <div class="rounded-box"
        style="background-image: url('{{ asset('img/default/colorful9.jpg') }}'); background-position:; background-repeat: no-repeat; background-size: cover;">
        <div class="grid grid-cols-1 gap-4 p-4 lg:grid-cols-5">
            <div class="col-span-1 lg:col-span-3 ">
                @include('livewire.intranet.comercial.vuelo.components.create-simple.section-vuelo-form')
            </div>
            @if ($this->has_cliente)
                <div class="col-span-1 lg:col-span-2">

                    @include('components.intranet.section-cliente')

                    <div class="mt-2 card-white">
                        <div class="card-body">
                            @if ($this->tipo_vuelo->is_charter)
                                <x-master.input label="Glosa" wire:model.defer="form.glosa"></x-master.input>
                            @endif
                            <x-master.input label="Monto total" wire:model.defer="form.monto" prefix="S/" type="number">
                            </x-master.input>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- {{ var_dump($this->vuelos_generados_model[0]->nro_asientos_disponibles) }} --}}

    @include('livewire.intranet.comercial.vuelo.components.create-simple.section-list-vuelos-generados')

    <script>
        document.addEventListener('livewire:load', function() {
            // Your JS here.
            flatpickr(".input_date", {
                enableTime: true,
                locale: {
                    firstDayOfWeek: 1,
                    weekdays: {
                        shorthand: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                        longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes',
                            'Sábado'],
                    },
                    months: {
                        shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Оct',
                            'Nov', 'Dic'
                        ],
                        longhand: ['Enero', 'Febreo', 'Мarzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto',
                            'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                        ],
                    },
                },
            });
        })
    </script>
</div>

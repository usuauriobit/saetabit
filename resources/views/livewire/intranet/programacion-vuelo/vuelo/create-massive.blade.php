<div x-data>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/color-calendar/dist/css/theme-basic.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/color-calendar/dist/css/theme-glass.css" />
    <script src="https://cdn.jsdelivr.net/npm/color-calendar/dist/bundle.min.js"></script>

    <div class="px-6 pt-6">
        <x-master.item class="my-4" label="Programación de vuelos - {{ $tipo_vuelo->descripcion }}"
            sublabel="Formulario de generación de vuelos">
            <x-slot name="avatar">
                <i class="las la-list"></i>
            </x-slot>
            <x-slot name="actions">
                <div x-show="$wire.tab == 'formulario' && $wire.ruta">
                    <button x-show="$wire.ruta" class="w-full my-4 btn btn-primary"
                    wire:click="generarVuelosProgramados">Generar</button>
                </div>
                @if (count($this->vuelos_programados) > 0)
                    <button class="btn btn-primary"
                        onclick="confirm('¿Está seguro?') || event.stopImmediatePropagation() " wire:click="save"
                        wire:loading.attr="disabled">
                        <div wire:loading.remove>
                            <i class="la la-save"></i>
                            Guardar
                        </div>
                        <div wire:loading class="text-primary">
                            @include('components.loader-horizontal-sm', [($color = 'white')]) __________
                        </div>
                    </button>
                @endif
            </x-slot>
        </x-master.item>
        @include('components.alert-errors')

        <div class="mb-4 tabs">
            <a class="tab tab-bordered" :class="{ 'tab-active': $wire.tab == 'formulario' }"
                @click="$wire.tab = 'formulario'">Filtro</a>
            <a class="tab tab-bordered" :class="{ 'tab-active': $wire.tab == 'resultados' }"
                @click="$wire.setTabResultados()">Resultados</a>
        </div>
    </div>

    <div x-show="$wire.tab == 'formulario'">
        @if ($ruta)
            <livewire:intranet.programacion-vuelo.vuelo.create-massive.tarifas-disponibles-listener :ruta="$ruta" />
        @endif
        @include('livewire.intranet.comercial.vuelo.components.create-massive.tab_formulario')
    </div>
    <div x-show="$wire.tab == 'resultados'">
        @include('livewire.intranet.comercial.vuelo.components.create-massive.tab_resultados')
    </div>
    <script>
        window.addEventListener('refreshJS', () => {
            flatpickr(".input_time", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                locale: {
                    firstDayOfWeek: 1,
                    weekdays: {
                        shorthand: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                        longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes',
                            'Sábado'
                        ],
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
    <script>
        window.addEventListener('setCalendar', vuelos_programados => {
            console.log('VUELOS PROGRAMADOS', vuelos_programados);
            const myEvents = vuelos_programados.detail.map(function(val) {
                console.log('VUELO', val);

                return {
                    start: val['fecha_hora_vuelo_programado'],
                    end: val['fecha_hora_aterrizaje_programado'],
                    // name: val['destino']['codigo_iata'],
                    // desc: val['destino']['codigo_iata'],
                    name: 'Vuelo',
                    desc: 'Vuelo',
                }
            })

            new Calendar({
                id: '#color-calendar',
                eventsData: myEvents,
                calendarSize: 'small',
                theme: 'glass',
            })
            console.log(myEvents);
        })
    </script>
</div>

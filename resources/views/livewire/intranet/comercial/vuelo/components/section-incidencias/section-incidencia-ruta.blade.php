<div class="">
    @if ($this->can_registrar_incidencia)
        <div class="cabecera p-6">
            <x-master.item label="Incidencia de ruta" sublabel="Lista de incidencias">
                <x-slot name="actions">
                    <a href="#addEscalaModal" class="btn btn-primary">Agregar escala</a>
                </x-slot>
            </x-master.item>
        </div>
    @endif
    <div class="card-white">
        @if (!$vuelo->incidencias_escala)
            <div class="card-body">
                <div class="alert alert-info">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6"
                            fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <div>
                            No hay incidencia registrada
                        </div>
                    </div>
                </div>
            </div>
        @else
            <table class="table table-striped table-hover w-full">
                <thead>
                    <tr>
                        <th>Vuelo 1</th>
                        <th>Ubicación de escala</th>
                        <th>Vuelo 2</th>
                        <th>Descripción</th>
                        <th>Fecha de registro</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vuelo->incidencias_escala as $incidencia)
                        <tr>
                            <td>{{ optional($incidencia->vuelo_primario)->codigo }}</td>
                            <td>
                                <strong>
                                    {{ optional($incidencia->escala_ubicacion)->codigo_default }}
                                </strong>
                                <p class="text-gray-500">
                                    {{ optional(optional($incidencia->escala_ubicacion)->ubigeo)->distrito }}
                                </p>
                            </td>
                            <td>{{ optional($incidencia->vuelo_secundario_generado)->codigo }}</td>
                            <td>{{ $incidencia->descripcion }}</td>
                            <td>{{ optional($incidencia->created_at)->format('Y-m-d g:i a') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        @if (!$this->can_registrar_incidencia && !$vuelo->incidencias_escala)
            <div class="mt-2">
                @include('livewire.intranet.comercial.vuelo.components.section-incidencias.section-incidencia-ruta.alert-cant-registrar')
            </div>
        @endif
    </div>
    @include('livewire.intranet.comercial.vuelo.components.section-incidencias.section-incidencia-ruta.modal-add-incidencia-escala')
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

<div>
    @if ($this->can_registrar_incidencia)
        <div class="cabecera p-6">
            <x-master.item label="Incidencia de fechas" sublabel="Lista de incidencias">
                <x-slot name="actions">
                    <a href="#addFechaIncidenciaModal" class="btn btn-primary">Registrar</a>
                </x-slot>
            </x-master.item>
        </div>
    @endif
    <div class="card-white">
        <table class="table table-striped w-full">
            <thead>
                <tr>
                    <th>Vuelo</th>
                    <th>Hora de vuelo <br /> anterior</th>
                    <th>Hora de aterrizaje <br /> anterior</th>
                    <th>Hora de vuelo <br /> posterior</th>
                    <th>Hora de aterrizaje <br /> posterior</th>
                    <th>Descripción</th>
                    <th>Fecha de registro</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vuelo->incidencias_fecha as $incidencia)
                    <tr>
                        <td>{{ optional($incidencia->vuelo)->codigo }}</td>
                        <td>
                            {{ optional($incidencia->fecha_hora_vuelo_anterior)->format('Y-m-d') }}
                            <div class="text-gray-500">
                                {{ optional($incidencia->fecha_hora_vuelo_anterior)->format('g:i a') }}
                            </div>
                        </td>
                        <td>
                            {{ optional($incidencia->fecha_hora_aterrizaje_anterior)->format('Y-m-d') }}
                            <div class="text-gray-500">
                                {{ optional($incidencia->fecha_hora_aterrizaje_anterior)->format('g:i a') }}
                            </div>
                        </td>
                        <td>
                            {{ optional($incidencia->fecha_hora_vuelo_posterior)->format('Y-m-d') }}
                            <div class="text-gray-500">
                                {{ optional($incidencia->fecha_hora_vuelo_posterior)->format('g:i a') }}
                            </div>
                        </td>
                        <td>
                            {{ optional($incidencia->fecha_hora_aterrizaje_posterior)->format('Y-m-d') }}
                            <div class="text-gray-500">
                                {{ optional($incidencia->fecha_hora_aterrizaje_posterior)->format('g:i a') }}
                            </div>
                        </td>
                        <td>{{ $incidencia->descripcion }}</td>
                        <td>
                            {{ optional($incidencia->created_at)->format('Y-m-d') }}
                            <div class="text-gray-500">
                                {{ optional($incidencia->created_at)->format('g:i a') }}
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @include('livewire.intranet.comercial.vuelo.components.section-incidencias.section-incidencia-fecha.modal-add-incidencia-fecha')
    <script>
        window.addEventListener('refreshJS', () => {
            flatpickr(".input_date_time", {
                enableTime: true,
                noCalendar: false,
                dateFormat: "Y-m-d H:i",
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

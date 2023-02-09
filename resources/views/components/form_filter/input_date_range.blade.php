<div class="" x-data="{
    isIdaVuelta: @entangle('is_ida_vuelta'),
    fecha_ida: @entangle('fecha_ida'),
    fecha_vuelta: @entangle('fecha_vuelta'),
    {{-- fechas_disponibles: @entangle('fechas_disponibles'), --}}
    picker: null
}" x-init="() => {
    picker = datePicker(isIdaVuelta, $wire, true);
    {{-- console.log('DATE', $wire) --}}
    window.livewire.on('type-changed', () => {
        console.log(picker, isIdaVuelta)
        if (picker) {
            picker.destroy()
        }
        picker = datePicker(isIdaVuelta, $wire);
    })
}">
    <div class="grid grid-cols-2 gap-4">
        <div class='col-span-2'>
            <label id="listbox-label" class="block text-sm font-medium text-gray-700">Fecha</label>
            <input x-ref="startDate" id="start-date" style="padding-top: 5pt; padding-bottom: 5pt"
                class="w-full pl-3 pr-10 mt-1 text-left bg-white border border-gray-300 rounded-md shadow-sm cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                type="text" placeholder="Ingresa una fecha" autocomplete="off">

            <input type="text" hidden wire:model="fecha_ida">
            <input type="text" hidden wire:model="fecha_vuelta">
        </div>
        {{-- <template x-if="isIdaVuelta">
            <div >
                <label id="listbox-label-end" class="block text-sm font-medium text-gray-700">Fecha</label>
                <input id="end-date" style="padding-top: 7.5pt; padding-bottom: 7.5pt" class="w-full pl-3 pr-10 mt-1 text-left bg-white border border-gray-300 rounded-md shadow-sm cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"  type="text" placeholder="Ingresa una fecha"  autocomplete="off" >
            </div>
        </template> --}}
    </div>
    <script>
        function datePicker(isIdaVuelta, $wire, firstLoad = false) {
            return new Litepicker({
                element: document.getElementById('start-date'),
                singleMode: !isIdaVuelta,
                tooltipText: {
                    one: 'día',
                    other: 'días'
                },
                mobileFriendly: true,
                numberOfMonths: 2,
                numberOfColumns: 2,
                minDate: new Date(),
                lang: 'es-ES',
                format: 'DD MMMM YYYY',
                lockDaysFilter: (date1, date2, pickedDated) => {
                    if ($wire.fechas_disponibles.length > 0) {
                        return !$wire.fechas_disponibles.includes(date1.format('YYYY-MM-DD'));
                    }
                    return false;
                },
                setup: (picker) => {
                    picker.on('selected', (date1, date2) => {
                        $wire.set('fecha_ida', dayjs(date1.dateInstance).format('YYYY-MM-DD'))
                        if (date2) {
                            $wire.set('fecha_vuelta', dayjs(date2.dateInstance).format('YYYY-MM-DD'))
                        } else {
                            $wire.set('fecha_vuelta', null)
                        }
                    })
                    if (firstLoad) {
                        if ($wire.fecha_ida) {
                            picker.on('render', ui => {
                                console.log('UI', picker, $wire.fecha_ida, new Date($wire
                                    .fecha_vuelta));
                                if (!$wire.is_ida_vuelta) {
                                    picker.setDate(dayjs($wire.fecha_ida))
                                } else {
                                    picker.setDateRange(dayjs($wire.fecha_ida), dayjs($wire
                                        .fecha_vuelta))
                                }
                            })
                        }
                    }
                }
                // tooltipNumber: (totalDays) => {
                //     return totalDays;
                // }
            });
        }
    </script>
</div>

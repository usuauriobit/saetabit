<div class="p-5 my-3 bg-white shadow-lg rounded-box grid grid-cols-2 md:grid-cols-2 gap-4 ">
    <div class="">
        <x-master.input name="form.nro_asientos" wire:model.defer="form.nro_asientos" label="Nro de asientos ofertados" type="number" step="1" />
        <div class="grid gap-4 grid-cols-1 md:grid-cols-2">
            <x-master.input name="form.fecha_inicio" type="date" wire:model.defer="form.fecha_inicio" label="Fecha de inicio" />
            <x-master.input name="form.fecha_final" type="date" wire:model.defer="form.fecha_final" label="Fecha final" />
        </div>
    </div>
    <div class="">
        <strong>Elegir los días de la semana</strong>
        <div class="grid grid-cols-2 pt-2 md:grid-cols-2 lg:grid-cols-4">
            @foreach ($semana as $dia)
            <div class="mt-4">
                <input wire:model.defer="semana_filtered" type="checkbox" class="toggle -mb-1" value="{{ $dia }}">
                <span class="">{{ $dia }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>

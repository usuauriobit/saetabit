<div class="p-4 rounded-box"
style="background-image: url('{{ asset('img/default/colorful3.jpg') }}'); background-position:; background-repeat: no-repeat; background-size: cover;">
    <div class="flex items-center gap-4 my-4">
        <div class="flex-none " wire:ignore.self id="color-calendar"></div>
        <div class="flex-auto text-center text-white ">
            <div class="text-6xl font-bold">
                {{$this->cantidad_vuelos}}
            </div>
            <div class="text-2xl">
                Vuelos generados automáticamente
            </div>
            <div class="my-4 text-md text-opacity-30">
                Estos vuelos aún no están guardados en la base de datos y han sido generados según el formulario de la pestaña Filtro
            </div>
            <a class="tab" wire:loading class="mt-4">
                @include('components.loader-horizontal-sm', ['color' => 'white'])
            </a>
        </div>
    </div>
</div>
@if ($vuelos_programados)
    @foreach ($this->vuelos_programados_model->groupBy(fn($q) => $q->fecha_hora_vuelo_programado->format('Y-m-d') ) as $fecha => $vuelos)
        <div class="my-4">
            <h5><strong>{{ $fecha }}</strong></h5>
        </div>
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-3 md:grid-cols-2">
            @foreach ($vuelos as $vuelo)
                <x-item.card-vuelo-simple :vuelo="$vuelo" />
            @endforeach
        </div>
    @endforeach
@endif


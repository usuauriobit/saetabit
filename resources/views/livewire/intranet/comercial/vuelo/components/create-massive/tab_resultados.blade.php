@if (count($vuelos_programados) == 0)
    <div class="my-20 text-center">
        <div class="text-xl">
            <i class="text-4xl las la-stream"></i>
            <br>
            <br>
            <strong>No se generó ningún vuelo</strong>
        </div>
    </div>
@else
<div class="p-6">
    @include('livewire.intranet.comercial.vuelo.components.create-massive.section-calendar')
</div>
@endif

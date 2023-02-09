@if($tipo_vuelo->descripcion == 'Subvencionado')
    @include('livewire.intranet.comercial.vuelo.components.create-massive.tab_formulario_subvencionado')
@endif
@include('livewire.intranet.comercial.vuelo.components.create-massive.filtro1')
@include('livewire.intranet.comercial.vuelo.components.create-massive.filtro2')

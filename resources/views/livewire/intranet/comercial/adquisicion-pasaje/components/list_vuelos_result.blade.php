<div>
    @foreach ($this->{$type.'_vuelos_founded_model'} as $vuelos)
        <livewire:intranet.comercial.adquisicion-pasaje.components.item-vuelo-select
            wire:key="{{$type}}{{now()}}"
            :vuelos="$vuelos"
            :paramEmitEvent="[ 'type' => $type, 'index' => $loop->index]"
            :is-already-selected="
                !empty($this->{$type.'_vuelos_selected'})
                && $vuelos[0]['id']
                == $this->{$type.'_vuelos_selected'}[0]['id']"
        >
    @endforeach
</div>

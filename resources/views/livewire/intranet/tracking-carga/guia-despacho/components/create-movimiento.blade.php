<div x-data>
    <div class="tabs tabs-boxed">
        <a class="tab {{ $tab == 'vuelo'    ? ' tab-active' : '' }}" wire:click="setTab('vuelo')">Registrar vuelo</a>
        <a class="tab {{ $tab == 'oficina'  ? ' tab-active' : '' }}" wire:click="setTab('oficina')">Registrar oficina</a>
    </div>
    <div>
        <div x-show="$wire.tab == 'vuelo'">
            <livewire:intranet.components.input-vuelo/>
        </div>
        <div x-show="$wire.tab == 'oficina'">
            <div class="flex my-4">
                <div class="flex-1">
                    <x-master.select
                        label="Oficina"
                        :options="Auth::user()->oficinas"
                        wire:model="oficina_selected_id"
                        name="oficina_selected"
                        >
                    </x-master.select>
                    @if ($oficina_selected_id)
                        <button wire:click="setOficina" class="w-full mt-4 btn btn-primary">
                            <i class="la la-check"></i> Guardar
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card-white">
    <div class="border collapse w-96 rounded-box border-base-300 collapse-arrow">
        <input type="checkbox">
        <div class="text-xl font-medium collapse-title">
          Historial de cambios
        </div>
        <div class="collapse-content">
            <x-master.item class="my-2" label="Fecha de creación">
                <x-slot name="sublabel">
                    {{ optional($doc->created_at)->format('Y-m-d H:i:s') ?? '-' }}
                </x-slot>
            </x-master.item>
            <x-master.item class="my-2" label="Usuario (Creación)">
                <x-slot name="sublabel">
                    {{ optional($doc->user_created)->name ?? '-' }}
                </x-slot>
            </x-master.item>
            <x-master.item class="my-2" label="Fecha de última edición">
                <x-slot name="sublabel">
                    {{ optional($doc->updated_at)->format('Y-m-d H:i:s') ?? '-' }}
                </x-slot>
            </x-master.item>
            <x-master.item class="my-2" label="Usuario (Edición)">
                <x-slot name="sublabel">
                    {{ optional($doc->user_edited)->name ?? '-' }}
                </x-slot>
            </x-master.item>
            <x-master.item class="my-2" label="Fecha de eliminación">
                <x-slot name="sublabel">
                    {{ optional($doc->deleted_at)->format('Y-m-d H:i:s') ?? '-' }}
                </x-slot>
            </x-master.item>
            <x-master.item class="my-2" label="Usuario (Eliminación)">
                <x-slot name="sublabel">
                    {{ optional($doc->user_deleted)->name ?? '-' }}
                </x-slot>
            </x-master.item>
        </div>
    </div>

</div>


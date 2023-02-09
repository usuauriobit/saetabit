<div class="mb-4">
  @if ($remitente)
      <x-master.item label="Remitente">
          <x-slot name="avatar">
              <i class="la la-user"></i>
          </x-slot>
          <x-slot name="sublabel">
              {{ $remitente->nombre_completo }}
              <div class="font-bold text-gray-500">
                  {{ $remitente->nro_doc }}
              </div>
          </x-slot>
          <x-slot name="actions">
              <button type="button" class="btn btn-sm btn-danger"
                  wire:click="deleteRemitente">
                  <i class="la la-times"></i>
              </button>
          </x-slot>
      </x-master.item>
  @else
      <livewire:intranet.components.input-persona
          create-persona-modal="#createRemitenteModal"
          emit-event="remitenteFounded" label="Buscar persona remitente">
      </livewire:intranet.components.input-persona>
  @endif

</div>
<div>
  @if ($consignatario)
      <x-master.item label="Consignatario">
          <x-slot name="avatar">
              <i class="la la-user"></i>
          </x-slot>
          <x-slot name="sublabel">
              {{ $consignatario->nombre_completo }}
              <div class="font-bold text-gray-500">
                  {{ $consignatario->nro_doc }}
              </div>
          </x-slot>
          <x-slot name="actions">
              <button type="button" class="btn btn-sm btn-danger"
                  wire:click="deleteConsignatario">
                  <i class="la la-times"></i>
              </button>
          </x-slot>
      </x-master.item>
  @else
      <livewire:intranet.components.input-persona
          create-persona-modal="#createConsignatarioModal"
          emit-event="consignatarioFounded" label="Buscar persona remitente">
      </livewire:intranet.components.input-persona>
  @endif
</div>

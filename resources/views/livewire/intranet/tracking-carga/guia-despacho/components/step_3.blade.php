<x-master.input disabled name="form.codigo" label="Código de seguimiento"
    wire:model.defer="form.codigo" type="text" required
    altLabelBL="{{ !isset($guia_despacho) ? 'Código generado (Puede variar según la cola de almacenamiento)' : '' }}">
</x-master.input>

<div class="form-control">
    <label class="label cursor-pointer flex">
        <div class="flex items-center">
            <input type="checkbox" wire:model="form.is_free" class="checkbox" />
            &nbsp;
            <span class="label-text font-bold">¿Es un envío sin costo?</span>
        </div>
    </label>
</div>

@if ($form['is_free'])
<div class="mt-2">
    @if ($aproved_by)
        <x-master.item class="my-3" label="Aprobado por:" sublabel="{{optional($aproved_by)->user_name}}"></x-master.item>
    @else
        <a class="btn btn-info w-full"  href="#modalApproveFree">Aprobar</a>
        <small>
            Se requiere la contraseña de un usuario con los permisos para autorizar esta acción.
        </small>
        <livewire:intranet.components.modal-password-validation modalName="modalApproveFree" eventName="approvedFree" permission="intranet.tracking-carga.guia-despacho.create-free" />
    @endif
</div>
@endif

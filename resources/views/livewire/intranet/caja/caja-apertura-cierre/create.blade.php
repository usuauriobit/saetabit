<div class="p-6">
    @include('components.alert-errors')
    <form wire:submit.prevent="save">
        <x-master.item class="text-2xl" label="{{ ucfirst('Apertura - Cierre - ' . ($caja ? $caja->descripcion : $apertura_cierre->caja->descripcion)) }}" sublabel="">
            <x-slot name="actions">
                @if ($apertura_cierre)
                    <button class="btn btn-danger btn-sm mr-2">Cerrar Caja</button>
                @endif
                @if ($caja)
                    <a href="{{ route('intranet.caja.caja.show', $caja) }}" class="btn btn-primary btn-sm">Volver</a>
                @endif
                @if ($apertura_cierre)
                    <a href="{{ route('intranet.caja.caja.show', $apertura_cierre->caja_id) }}" class="btn btn-primary btn-sm">Volver</a>
                @endif
            </x-slot>
        </x-master.item>
        @if ($caja)
            <div class="card-white mt-2">
                <x-master.input name="form.fecha_apertura" label="Fecha Apertura" wire:model.defer="form.fecha_apertura" type="datetime-local" readonly required></x-master.input>
                <div class="form-control mt-3">
                    <label class="label">
                        <span class="label-text">Observaciones (Opcional)</span>
                    </label>
                    <textarea class="textarea textarea-bordered" name="form.observacion_apertura" wire:model.defer="form.observacion_apertura"></textarea>
                </div>
                <button class="btn btn-success mt-2 btn-sm w-full">Aperturar</button>
            </div>
        @endif
        @if ($apertura_cierre)
            <div class="card-white mt-2">
                <div class="card-body">
                    <div class="grid grid-cols-3 gap-4">
                        <x-master.item label="Fecha Cierre"  sublabel="{{ $form['fecha_cierre'] }}"/>
                        <x-master.item label="Cajero"  sublabel="{{ $apertura_cierre->user_created->name }}"/>
                        <x-master.item label="Descripción"  sublabel="{{ $apertura_cierre->caja->descripcion }}"/>
                    </div>
                </div>
            </div>
            <div class="card-white mt-2">
                <div class="grid grid-cols-3 gap-4">
                    <div class="table-responsive col-span-2">
                        <table class="table table-bordered w-full mt-3">
                            <thead>
                                <tr>
                                    <th class="text-center">N°</th>
                                    <th class="text-center">Denominacion</th>
                                    <th class="text-center">Cantidad</th>
                                    <th class="text-center">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; $total_denominacion = 0; @endphp
                                @foreach ($denominaciones as $denominacion)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $denominacion->denominacion }}</td>
                                        <td class="text-right" width="30%">
                                            <x-master.input name="form.denominaciones.{{ $denominacion->id }}" label="" wire:model="form.denominaciones.{{ $denominacion->id }}" type="number" />
                                        </td>
                                        <td class="text-right" width="30%">
                                            @php
                                                $total_denominacion = $denominacion->valor * floatval( $form['denominaciones'][$denominacion->id] ?? 0);
                                                $total += $total_denominacion;
                                            @endphp
                                            {{ number_format($total_denominacion, 2, '.', ',') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            {{-- <tfoot>
                                <tr>
                                    <th colspan="3" class="text-center">
                                        <div class="text-2xl">Total Cierre</div>
                                    </th>
                                    <td class="text-right">
                                        <div class="text-4xl">
                                            @soles($total)
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-center">
                                        <div class="text-2xl">Total Efectivo</div>
                                    </th>
                                    <td class="text-right">
                                        <div class="text-4xl">
                                            @soles($apertura_cierre->total_efectivo)
                                        </div>
                                    </td>
                                </tr>
                            </tfoot> --}}
                        </table>
                    </div>
                    <table class="table table-bordered w-full mt-3">
                        <thead>
                            <tr>
                                <th colspan="3" class="text-center">
                                    <div class="text-2xl">Total Cierre</div>
                                </th>
                                <td class="text-right">
                                    <div class="text-4xl">
                                        @soles($total)
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th colspan="3" class="text-center">
                                    <div class="text-2xl">Total Efectivo</div>
                                </th>
                                <td class="text-right">
                                    <div class="text-4xl">
                                        @soles($apertura_cierre->total_efectivo)
                                    </div>
                                </td>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        @endif
    </form>
</div>

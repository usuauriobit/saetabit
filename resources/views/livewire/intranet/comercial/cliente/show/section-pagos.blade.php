<x-master.item class="py-4" label="{{ ucfirst('Historial de pagos') }}" sublabel="Lista de pagos">
    <x-slot name="avatar"><i class="text-xl la la-list"></i></x-slot>
</x-master.item>
<div class="card-white ">
    <div class="card-body">
        <div>
            <div class="mt-2 overflow-x-auto">
                <table class="table w-full">
                    <tr>
                        <th>Fecha</th>
                        <th>Importe</th>
                        <th>Estado</th>
                        <th>Detalle</th>
                        {{-- <th>Acción</th> --}}
                    </tr>
                    @foreach ($cliente->ventas as $venta)
                        <tr>
                            <td>
                                <small>
                                    {{ optional($venta->created_at)->format('Y-m-d') }} <br>
                                    {{ optional($venta->created_at)->format('g:i a') }}
                                </small>
                            </td>
                            <td>@soles($venta->importe)</td>
                            <td>
                                <div class="badge {{$venta->status_badge_color}}"> {{$venta->status}} </div>
                            </td>
                            <td>
                                <ul>
                                    @foreach ($venta->detalle as $item)
                                        <li>
                                            {{$item->descripcion}}
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            {{-- <td>
                                <a href="#" class="btn btn-sm btn-primary btn-outline">
                                    <i class="la la-eye"></i>
                                </a>
                            </td> --}}
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>

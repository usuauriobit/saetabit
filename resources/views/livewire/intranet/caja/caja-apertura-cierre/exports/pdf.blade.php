
@inject('service', 'App\Services\AperturaCierreService')

@php
    $tipo_pagos = App\Models\TipoPago::get();
@endphp

<style>
    body {
        font-size: 12px;
    }
    footer {
        position: fixed;
        bottom: -60px;
        left: 0px;
        right: 0px;
        height: 50px;
    }
    table {
        border-collapse: collapse;
    }
</style>

@include('livewire.intranet.caja.caja-apertura-cierre.exports.cabecera')

@include('livewire.intranet.caja.caja-apertura-cierre.exports.resumen')

<div style="page-break-after:always;"></div>

@include('livewire.intranet.caja.caja-apertura-cierre.exports.cabecera')

@include('livewire.intranet.caja.caja-apertura-cierre.exports.detallado')

@include('livewire.intranet.caja.caja-apertura-cierre.exports.extornos')


{{--
    <tr>
        <th style="border-top:1px solid black; border-left: 1px solid black; border-bottom: 1px solid black;">
            ITEM
        </th>
    </tr>
--}}



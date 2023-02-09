<?php

use App\Http\Livewire\Intranet\TrackingCarga as TrackingCarga;
use App\Http\Controllers\TrackingCarga as TrackingCargaLaravel;
use App\Http\Controllers\Export as Export;
use Illuminate\Support\Facades\Route;

Route::prefix('tracking-carga')->as('tracking-carga.')->group(function () {
    Route::get('/', TrackingCarga\Index::class)->name('index');
    Route::prefix('guia-despacho')->as('guia-despacho.')->group(function () {
        Route::get('/', TrackingCarga\GuiaDespacho\Index::class)->name('index');
        Route::get('/create/{oficina_id}', TrackingCarga\GuiaDespacho\Create::class)->name('create');
        Route::get('/show/{guia_despacho}', TrackingCarga\GuiaDespacho\Show::class)->name('show');
        Route::get('/edit/{guia_despacho}', TrackingCarga\GuiaDespacho\Create::class)->name('edit');
    });
});
?>

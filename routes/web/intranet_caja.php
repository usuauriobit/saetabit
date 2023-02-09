<?php

use App\Http\Livewire\Intranet\Caja as Caja;
use App\Http\Controllers\Caja as CajaLaravel;
use App\Http\Controllers\Export as Export;
use Illuminate\Support\Facades\Route;

Route::prefix('caja')->as('caja.')->group(function () {
    Route::prefix('caja')->as('caja.')->group(function () {
        Route::get('/', Caja\Caja\Index::class)->name('index')->middleware(['permission:intranet.caja.caja.index']);
        Route::get('/{caja}', Caja\Caja\Show::class)->name('show')->middleware(['permission:intranet.caja.caja.show']);
    });

    Route::prefix('venta')->as('venta.')->group(function () {
        Route::get('/', Caja\Venta\Index::class)->name('index')->middleware(['permission:intranet.caja.venta.index']);
        Route::get('/{venta}', Caja\Venta\Show::class)->name('show')->middleware(['permission:intranet.caja.venta.show']);
    });

    Route::prefix('caja-apertura-cierre')->as('caja-apertura-cierre.')->group(function () {
        Route::get('/', Caja\CajaAperturaCierre\Index::class)->name('index')->middleware(['permission:intranet.caja.caja-apertura-cierre.index']);
        Route::get('/{caja_id}/create', Caja\CajaAperturaCierre\Create::class)->name('create')->middleware(['permission:intranet.caja.caja-apertura-cierre.create']);
        Route::get('/{apertura_cierre_id}/edit', Caja\CajaAperturaCierre\Create::class)->name('edit')->middleware(['permission:intranet.caja.caja-apertura-cierre.edit']);
        Route::get('/{apertura_cierre_id}/show', Caja\CajaAperturaCierre\Show::class)->name('show')->middleware(['permission:intranet.caja.caja-apertura-cierre.show']);
        Route::get('{apertura_cierre_id}/export', [Export\CierreCajaExportController::class, 'exportCierre'])->name('export')->middleware(['permission:intranet.caja.caja-apertura-cierre.export']);
    });

    Route::get('extorno', Caja\Extorno\Index::class)->name('extorno.index')->middleware(['permission:intranet.caja.extorno.create']);

    Route::prefix('caja-movimiento')->as('caja-movimiento.')->group(function () {
        Route::get('/{caja}/create', Caja\CajaMovimiento\Create::class)->name('create')->middleware(['permission:intranet.caja.caja-movimiento.create']);
    });
    Route::prefix('facturacion')->as('facturacion.')->group(function () {
        Route::get('/create', Caja\Facturacion\Create::class)->name('create')->middleware(['permission:intranet.caja.facturacion.create']);
    });
    Route::prefix('comprobante')->as('comprobante.')->group(function () {
        Route::get('/', Caja\Comprobante\Index::class)->name('index')->middleware(['permission:intranet.caja.comprobante.index']);
        Route::get('/{comprobante}/show', Caja\Comprobante\Show::class)->name('show')->middleware(['permission:intranet.caja.comprobante.show']);
    });
    Route::prefix('cuenta-cobrar')->as('cuenta-cobrar.')->group(function () {
        Route::get('/', Caja\CuentaCobrar\Index::class)->name('index')->middleware(['permission:intranet.caja.cuenta-cobrar.index']);
        Route::get('/show/{cuenta_cobrar}', Caja\CuentaCobrar\Show::class)->name('show')->middleware(['permission:intranet.caja.cuenta-cobrar.show']);
        Route::get('/facturar/{cuenta_cobrar}', Caja\CuentaCobrar\Facturar::class)->name('facturar')->middleware(['permission:intranet.caja.cuenta-cobrar.facturar']);
    });
    Route::prefix('devolucion')->as('devolucion.')->group(function () {
        Route::get('/', Caja\Devolucion\Index::class)->name('index')->middleware(['permission:intranet.caja.devolucion.index']);
        Route::get('/create', Caja\Devolucion\Create::class)->name('create')->middleware(['permission:intranet.caja.devolucion.create']);
        Route::get('/{devolucion}/show', Caja\Devolucion\Show::class)->name('show')->middleware(['permission:intranet.caja.devolucion.show']);
    });
    Route::prefix('mantenimiento')->as('mantenimiento.')->group( function () {
        Route::get('caja', Caja\Mantenimiento\Caja\Index::class)->name('caja.index')->middleware(['permission:intranet.caja.mantenimiento.caja.index']);
        Route::get('caja/{caja}', Caja\Mantenimiento\Caja\Show::class)->name('caja.show')->middleware(['permission:intranet.caja.mantenimiento.caja.show']);
    });
});
?>

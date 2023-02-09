<?php

use App\Http\Livewire\Intranet\ProgramacionVuelo as ProgramacionVuelo;
use App\Http\Controllers\ProgramacionVuelo as ProgramacionVueloLaravel;
use App\Http\Controllers\Export as Export;
use Illuminate\Support\Facades\Route;

Route::prefix('programacion-vuelo')->as('programacion-vuelo.')->group(function () {

    Route::prefix('vuelo')->as('vuelo.')->group(function () {
        Route::get('/', ProgramacionVuelo\Vuelo\Index::class)->name('index');
        Route::get('search', ProgramacionVuelo\Vuelo\Search::class)->name('search');
        Route::get('show/{vuelo}', ProgramacionVuelo\Vuelo\Show::class)->name('show');
        Route::get('create', ProgramacionVuelo\Vuelo\Create::class)->name('create');
        Route::get('create-simple/{tipo_vuelo_id}', ProgramacionVuelo\Vuelo\CreateSimple::class)->name('create-simple');
        Route::get('create-massive/{tipo_vuelo_id}', ProgramacionVuelo\Vuelo\CreateMassive::class)->name('create-massive');

        Route::prefix('export')->as('export.')->group(function () {
            Route::get('/preliminar-pasajeros/{vuelo}', [Export\VueloExportController::class, 'exportPreliminarPasajerosPdf'])->name('preliminar-pasajeros.pdf');
            Route::get('/preliminar-cargas/{vuelo}', [Export\VueloExportController::class, 'exportPreliminarCargasPdf'])->name('preliminar-cargas.pdf');
            Route::get('/manifiesto-pasajeros/{vuelo}', [Export\VueloExportController::class, 'exportManifiestoPasajerosPdf'])->name('manifiesto-pasajeros.pdf');
            Route::get('/manifiesto-cargas/{vuelo}', [Export\VueloExportController::class, 'exportManifiestoCargasPdf'])->name('manifiesto-cargas.pdf');
            Route::get('/manifiesto-resumen/{vuelo}', [Export\VueloExportController::class, 'exportManifiestoResumenPdf'])->name('manifiesto-resumen.pdf');
        });
        Route::get('resumen-comercial', ProgramacionVuelo\Vuelo\ResumenComercial::class)->name('resumen-comercial');
    });


    Route::prefix('vuelo-ruta')->as('vuelo-ruta.')->group(function () {
        Route::get('/', ProgramacionVuelo\VueloRuta\Index::class)->name('index');
        Route::get('show/{vuelo_ruta}', ProgramacionVuelo\VueloRuta\Show::class)->name('show');
    });
    Route::prefix('vuelo-massive')->as('vuelo-massive.')->group(function () {
        Route::get('/', ProgramacionVuelo\VueloMassive\Index::class)->name('index');
        Route::get('/show/{vuelo_massive}', ProgramacionVuelo\VueloMassive\Show::class)->name('show');
    });

});
?>

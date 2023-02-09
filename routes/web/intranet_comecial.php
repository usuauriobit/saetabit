<?php

use App\Http\Livewire\Intranet\Comercial as Comercial;
use App\Http\Controllers\Comercial as ComercialLaravel;
use App\Http\Controllers\Export as Export;
use Illuminate\Support\Facades\Route;

Route::prefix('comercial')->as('comercial.')->group(function () {
    Route::get('/', Comercial\Index::class)->name('index');
    Route::prefix('tarifa')->as('tarifa.')->group(function () {
        Route::get('/', Comercial\Tarifa\Index::class)->name('index');
        Route::get('create', Comercial\Tarifa\Create::class)->name('create');
    });

    Route::get('pdf', [ComercialLaravel\PdfController::class, 'cierreCaja'])->name('pdf');

    Route::prefix('adquisicion-pasaje')->as('adquisicion-pasaje.')->group(function () {
        Route::get('/', Comercial\AdquisicionPasaje\Index::class)->name('index');
        Route::get('create', Comercial\AdquisicionPasaje\Create::class)->name('create');
    });

    Route::prefix('vuelo-charter')->as('vuelo_charter.')->group(function () {
        Route::prefix('comercial')->as('comercial.')->group(function () {
            Route::get('/', Comercial\VueloCharter\Comercial\Index::class)->name('index');
            Route::get('create', Comercial\VueloCharter\Comercial\Create::class)->name('create');
        });
        Route::prefix('emergencia-medica')->as('emergencia_medica.')->group(function () {
            Route::get('/', Comercial\VueloCharter\EmergenciaMedica\Index::class)->name('index');
        });
        Route::prefix('convenio')->as('convenio.')->group(function () {
            Route::get('/', Comercial\VueloCharter\Convenio\Index::class)->name('index');
        });
    });
    Route::prefix('pasajero')->as('pasajero.')->group(function () {
        Route::get('/', Comercial\Pasajero\Index::class)->name('index');
        Route::get('/{persona}', Comercial\Pasajero\Show::class)->name('show');
    });
    Route::prefix('cliente')->as('cliente.')->group(function () {
        Route::get('/', Comercial\Cliente\Index::class)->name('index');
        Route::get('/{cliente_id}/{cliente_model}', Comercial\Cliente\Show::class)->name('show');
    });
    Route::prefix('pasaje-cambio')->as('pasaje-cambio.')->group(function () {
        Route::get('/', Comercial\PasajeCambio\Index::class)->name('index');
    });
    Route::prefix('pasaje-abierto')->as('pasaje-abierto.')->group(function () {
        Route::get('/', Comercial\PasajeAbierto\Index::class)->name('index');
    });
    Route::prefix('pasaje')->as('pasaje.')->group(function () {
        Route::get('/search', Comercial\Pasaje\Search::class)->name('search');
        Route::get('/show/{pasaje_id}', Comercial\Pasaje\Show::class)->name('show');
        Route::prefix('export')->as('export.')->group(function () {
            Route::get('/boarding-pass-pdf/{pasaje}', [Export\BoardingPassExportController::class, 'exportPdf'])->name('boarding-pass');
            Route::get('/documento-informativo-pdf/{pasaje}', [Export\DocumentoInformativoExportController::class, 'exportPdf'])->name('documento-informativo');
        });
    });

    Route::prefix('vuelo-credito')->as('vuelo-credito.')->group(function () {
        Route::get('/', Comercial\VueloCredito\Index::class)->name('index');
        Route::get('/{vuelo_credito}', Comercial\VueloCredito\Show::class)->name('show');
    });

    Route::prefix('descuento')->as('descuento.')->group(function () {
        Route::get('/', Comercial\Descuento\Index::class)->name('index');
        Route::get('/create', Comercial\Descuento\Create::class)->name('create');
        Route::get('/edit/{descuento}', Comercial\Descuento\Create::class)->name('edit');
        Route::get('/resumen-mensual', Comercial\Descuento\ResumenMensual::class)->name('resumen-mensual');
    });
});
?>

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Intranet as Intranet;

Route::prefix('configuracion')->as('configuracion.')->group(function () {
    Route::get('/', Intranet\Configuracion\Index::class)->name('index');
    Route::prefix('oficina')->as('oficina.')->group(function () {
        Route::get('/', Intranet\Configuracion\Oficina\Index::class)->name('index');
    });
    Route::prefix('persona')->as('persona.')->group(function () {
        Route::get('/', Intranet\Configuracion\Persona\Index::class)->name('index');
        Route::get('create', Intranet\Configuracion\Persona\Create::class)->name('create');
        Route::get('edit/{persona}', Intranet\Configuracion\Persona\Create::class)->name('edit');
    });
    Route::prefix('pasaje_cambio_tarifa')->as('pasaje_cambio_tarifa.')->group(function () {
        Route::get('/', Intranet\Configuracion\PasajeCambioTarifa\Index::class)->name('index');
        Route::get('edit/{pasaje_cambio_tarifa}', Intranet\Configuracion\PasajeCambioTarifa\Edit::class)->name('edit');
    });
    Route::prefix('tarifa-bulto')->as('tarifa_bulto.')->group(function () {
        Route::get('/', Intranet\Configuracion\TarifaBulto\Index::class)->name('index');
        Route::get('edit/{tarifa_bulto}', Intranet\Configuracion\TarifaBulto\Edit::class)->name('edit');
    });
    Route::prefix('tasa-cambio-valor')->as('tasa-cambio-valor.')->group(function () {
        Route::get('/', Intranet\Configuracion\TasaCambioValor\Index::class)->name('index');
        Route::get('tasa-cambio-valor', Intranet\Configuracion\TasaCambioValor\Create::class)->name('create');
        Route::get('tasa-cambio-valor/{tasa_cambio_valor}', Intranet\Configuracion\TasaCambioValor\Create::class)->name('edit');
    });
    Route::prefix('personal')->as('personal.')->group(function () {
        Route::get('/', Intranet\Configuracion\Personal\Index::class)->name('index');
        Route::get('/create', Intranet\Configuracion\Personal\Create::class)->name('create');
        Route::get('/{personal}/edit', Intranet\Configuracion\Personal\Create::class)->name('edit');
    });

    Route::get('tripulacion', Intranet\Configuracion\Tripulacion\Index::class)->name('tripulacion.index');
    Route::get('usuarios', Intranet\Configuracion\User\Index::class)->name('user.index');
    Route::get('tramo', Intranet\Configuracion\Tramo\Index::class)->name('tramo.index');
    Route::get('categoria_vuelo', Intranet\Configuracion\CategoriaVuelo\Index::class)->name('categoria_vuelo.index');
    Route::get('tipo_vuelo', Intranet\Configuracion\TipoVuelo\Index::class)->name('tipo_vuelo.index');
    Route::get('ruta', Intranet\Configuracion\Ruta\Index::class)->name('ruta.index');
    Route::get('tiempo_tramo', Intranet\Configuracion\TiempoTramo\Index::class)->name('tiempo_tramo.index');
    Route::get('cuenta-bancaria-referencial', Intranet\Configuracion\CuentaBancariaReferencial\Index::class)->name('cuenta-bancaria-referencial.index');
});
?>

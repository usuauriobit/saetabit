<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Intranet as Intranet;

Route::prefix('mantenimiento')->as('mantenimiento.')->group(function () {
    Route::get('/', Intranet\Mantenimiento\Index::class)->name('index');
    Route::get('tipo_avion', Intranet\Mantenimiento\TipoAvion\Index::class)->name('tipo_avion.index');
    Route::get('ubicacion', Intranet\Mantenimiento\Ubicacion\Index::class)->name('ubicacion.index');
    Route::get('tipo_motor', Intranet\Mantenimiento\TipoMotor\Index::class)->name('tipo_motor.index');
    Route::get('estado_avion', Intranet\Mantenimiento\EstadoAvion\Index::class)->name('estado_avion.index');
    Route::get('fabricante', Intranet\Mantenimiento\Fabricante\Index::class)->name('fabricante.index');
    Route::get('tipo_pista', Intranet\Mantenimiento\TipoPista\Index::class)->name('tipo_pista.index');
    Route::prefix('avion')->as('avion.')->group(function () {
        Route::get('/', Intranet\Mantenimiento\Avion\Index::class)->name('index');
        Route::get('/{avion}', Intranet\Mantenimiento\Avion\Show::class)->name('show');
        // Route::get('create', Intranet\Mantenimiento\Avion\Create::class)->name('create');
        // Route::get('edit', Intranet\Mantenimiento\Avion\Create::class)->name('edit');
    });
    Route::prefix('tiempo-avion-tramo')->as('tiempo-avion-tramo.')->group(function () {
        Route::get('create/{avion}', Intranet\Mantenimiento\TiempoAvionTramo\Create::class)->name('create');
        Route::get('edit/{tiempo_avion_tramo}', Intranet\Mantenimiento\TiempoAvionTramo\Create::class)->name('edit');
    });
    Route::prefix('landing-page')->as('landing-page.')->group(function () {
        Route::get('/', Intranet\Mantenimiento\LandingPage\SeccionHero\Index::class)->name('seccion-hero.index');
        Route::get('create', Intranet\Mantenimiento\LandingPage\SeccionHero\Create::class)->name('seccion-hero.create');
        Route::get('edit', Intranet\Mantenimiento\LandingPage\SeccionHero\Create::class)->name('seccion-hero.edit');
    });

});
?>

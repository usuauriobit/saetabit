<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Intranet as Intranet;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('intranet/login', Intranet\Login::class)->name('intranet.login');
Route::prefix('intranet')->as('intranet.')->middleware(['access_to_intranet'])->group(function () {
    Route::get('/', Intranet\Index::class)->name('index');
    include('intranet_comecial.php');
    include('intranet_caja.php');
    include('intranet_tracking_carga.php');
    include('intranet_programacion_vuelo.php');
    include('intranet_configuracion.php');
    include('intranet_mantenimiento.php');
});


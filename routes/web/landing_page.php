<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\LandingPage;

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

Route::get('/', LandingPage\Index::class)->name('landing_page.index');
Route::get('/tracking', LandingPage\Tracking::class)->name('landing_page.tracking');
Route::get('/tarifa', LandingPage\Tarifa\Index::class)->name('landing_page.tarifa');
Route::get('/contactanos', LandingPage\Nosotros::class)->name('landing_page.nosotros');
Route::get('/adquirir-pasajes', LandingPage\AdquirirPasajesPage::class)->name('landing_page.adquirir-pasajes');
Route::get('/registrar-pasajeros', LandingPage\RegistrarPasajeros::class)->name('landing_page.registrar-pasajeros');
Route::get('/checkout/{codigo_orden}', LandingPage\RegistrarPago::class)->name('landing_page.registrar-pago');

Route::view('/condiciones-uso', 'livewire.landing-page.condiciones-uso')->name('landing_page.condiciones-uso');

Route::get('auth/profile', LandingPage\Auth\Profile::class)->name('landing_page.auth.profile');

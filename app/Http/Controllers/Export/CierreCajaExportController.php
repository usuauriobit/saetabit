<?php

namespace App\Http\Controllers\Export;

use App\Http\Controllers\Controller;
use App\Models\CajaAperturaCierre;
use Illuminate\Http\Request;
use PDF;

class CierreCajaExportController extends Controller
{
    public static function exportCierre($id)
    {
        return PDF::loadView('livewire.intranet.caja.caja-apertura-cierre.exports.pdf', [
                        'apertura_cierre' => CajaAperturaCierre::find($id),
                    ])->stream();
    }
}

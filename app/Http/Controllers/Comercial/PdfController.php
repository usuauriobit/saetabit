<?php

namespace App\Http\Controllers\Comercial;

use App\Http\Controllers\Controller;
use App\Models\CajaAperturaCierre;
use Illuminate\Http\Request;
use App\Models\GuiaDespacho;
use App\Models\Oficina;
use App\Models\Pasaje;
use App\Models\Vuelo;
use PDF;

class PdfController extends Controller
{
    public function index()
    {
        $pdf = PDF::loadView('livewire.intranet.proforma-pdf', [
            'form' => [
                'fecha' => '2021-12-13',
                'cliente' => 'UNIDAD EJECUTORA',
                'avion_id' => '1',
                'origen_id' => '2',
                'destino_id' => '10',
                'precio' => '30000',
            ],
        ]);

        return $pdf->stream();
    }

    public function stickerGuiaDespacho()
    {
        $pdf = PDF::loadView('livewire.intranet.tracking-carga.guia-despacho.exports.pdfSticker', [
            'guia-despacho' => GuiaDespacho::first(),
        ]);

        return $pdf->stream();
    }

    public function pdfVuelo()
    {
        $pdf = PDF::loadView('livewire.intranet.comercial.vuelo.exports.pdf', [ 'vuelo' => Vuelo::find(26) ]);
        return $pdf->stream();
    }

    public function pdfManifiestoCarga()
    {
        $pdf = PDF::loadView('livewire.intranet.comercial.vuelo.exports.pdf_manifiesto_carga', [
                    'vuelo' => Vuelo::find(26)
                ])->setPaper('a4', 'landscape');
        return $pdf->stream();
    }

    public function cierreCaja($id = null)
    {
        $pdf = PDF::loadView('livewire.intranet.caja.caja-apertura-cierre.exports.pdf', [ 'apertura_cierre' => CajaAperturaCierre::find(1) ]);
        return $pdf->stream();
    }

}

<?php
namespace App\Http\Controllers\Export;

use App\Models\Pasaje;
use App\Models\Vuelo;
use PDF;
class VueloExportController {

    public static function exportPreliminarCargasPdf(Vuelo $vuelo){
        return PDF::loadView('livewire.intranet.programacion-vuelo.vuelo.exports.pdf_manifiesto_carga', [
            'vuelo' => $vuelo,
            'is_manifiesto' => false
        ])
        ->setPaper('a4', 'landscape')
        ->stream();
    }
    public static function exportPreliminarPasajerosPdf(Vuelo $vuelo){
        return PDF::loadView('livewire.intranet.programacion-vuelo.vuelo.exports.pdf_preliminar_pasajeros', [
            'vuelo' => $vuelo
        ])
        ->setPaper('a4', 'portrait')
        ->stream();
    }
    public static function exportManifiestoPasajerosPdf(Vuelo $vuelo){
        return PDF::loadView('livewire.intranet.programacion-vuelo.vuelo.exports.pdf_manifiesto_pasajeros', [
            'vuelo' => $vuelo
        ])
        ->setPaper('a4', 'portrait')
        ->stream();
    }
    // public static function exportManifiestoCargasPdf(Vuelo $vuelo){
    //     return PDF::loadView('livewire.intranet.programacion-vuelo.vuelo.exports.pdf_manifiesto_carga', [
    //         'vuelo' => $vuelo,
    //     ])
    //     ->setPaper('a4', 'portrait')
    //     ->stream();
    // }
    public static function exportManifiestoResumenPdf(Vuelo $vuelo){
        return PDF::loadView('livewire.intranet.programacion-vuelo.vuelo.exports.pdf_manifiesto_resumen', [
            'vuelo' => $vuelo
        ])
        ->setPaper('a4', 'portrait')
        ->stream();
    }

    public static function exportManifiestoCargasPdf(Vuelo $vuelo){
        return PDF::loadView('livewire.intranet.programacion-vuelo.vuelo.exports.pdf_manifiesto_carga', [
            'vuelo' => $vuelo,
            'is_manifiesto' => true
        ])
        ->setPaper('a4', 'landscape')
        ->stream();
    }
}
?>

<?php
namespace App\Http\Controllers\Export;

use App\Models\Pasaje;
use App\Models\TarifaBulto;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;
class BoardingPassExportController {
    public static function exportPdf(Pasaje $pasaje){
        $pasaje->update([
            'checkin_date_time' => date('Y-m-d H:i:s'),
            'is_asistido'       => true
        ]);
        return PDF::loadView('livewire.intranet.comercial.pasaje.exports.boarding-pass', [
            'pasaje' => $pasaje,
            'tarifa_bulto' => TarifaBulto::where('tipo_vuelo_id', $pasaje->vuelos[0]->tipo_vuelo->id)->first()
        ])
        // ->setPaper('a4', 'portrait')
        ->stream();
    }
}
?>

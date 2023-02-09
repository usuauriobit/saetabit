<?php
namespace App\Http\Controllers\Export;

use App\Models\Pasaje;
use PDF;
class DocumentoInformativoExportController {
    public static function exportPdf(Pasaje $pasaje){
        return PDF::loadView('livewire.intranet.comercial.pasaje.exports.documento-informativo', [
            'pasaje' => $pasaje,
        ])
        ->setPaper('a5', 'portrait')
        ->stream();
    }
}
?>

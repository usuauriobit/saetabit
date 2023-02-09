<?php
namespace App\Http\Livewire\Intranet\ProgramacionVuelo\Vuelo\ShowTraits;

trait ExportTrait{
    public function print($type)
    {
        switch ($type) {
            case 'preliminar_pasajeros':
                $this->exportPreliminarPasajeros();
                break;
            case 'preliminar_cargas':
                $this->exportPreliminarCargas();
                break;
            case 'manifiesto_pasajeros':
                $this->exportManifiestoPasajeros();
                break;
            case 'manifiesto_cargas':
                $this->exportManifiestoCargas();
                break;
            case 'resumen_vuelo':
                $this->exportResumenVuelo();
                break;
            default:
                $this->emit('notify', 'error','No existe un reporte para este tipo de petición');
                break;
        }
    }

    public function exportPreliminarPasajeros(){
        $pdfContent = PDF::loadView('livewire.intranet.comercial.vuelo.exports.pdf_preliminar_pasajeros', [ 'vuelo' => $this->vuelo ])
        ->setPaper('a4', 'landscape')
        ->output();
        return response()->streamDownload( fn () => print($pdfContent), "Manifiesto Carga - Vuelo N°{$this->vuelo->id}.pdf" );
    }
    public function exportPreliminarCargas(){

    }
    public function exportManifiestoPasajeros(){

    }
    public function exportManifiestoCargas(){
        $pdfContent = PDF::loadView('livewire.intranet.comercial.vuelo.exports.pdf_manifiesto_carga', [ 'vuelo' => $this->vuelo ])
            ->setPaper('a4', 'landscape')
            ->output();
        return response()->streamDownload( fn () => print($pdfContent), "Manifiesto Carga - Vuelo N°{$this->vuelo->id}.pdf" );
    }
    public function exportResumenVuelo(){
        $pdfContent = PDF::loadView('livewire.intranet.comercial.vuelo.exports.pdf', [ 'vuelo' => $this->vuelo ])
            ->output();
        return response()->streamDownload( fn () => print($pdfContent), "Vuelo N°{$this->vuelo->id}.pdf" );
    }
}
?>

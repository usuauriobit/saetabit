<?php
namespace App\Http\Livewire\LandingPage\Components\AdquirirPasajesPage\Traits;

use App\Services\TasaCambioService;

trait TarifaMontoTrait {
    public function getMontoTotalIdaProperty(){
        $tcs = new TasaCambioService();
        $monto = 0;
        foreach ($this->tarifas_ida as $tarifa) {
            $monto += $tarifa['tarifa']['is_dolarizado']
                ? $tcs->getMontoSoles($tarifa['total'])
                : $tarifa['total'] ;
        }
        return $monto;
    }
    public function getMontoTotalVueltaProperty(){
        $tcs = new TasaCambioService();
        $monto = 0;
        foreach ($this->tarifas_vuelta as $tarifa) {
            $monto += $tarifa['tarifa']['is_dolarizado']
                ? $tcs->getMontoSoles($tarifa['total'])
                : $tarifa['total'] ;
        }
        return $monto;
    }

    public function getMontoTotalProperty(){
        return $this->monto_total_ida + $this->monto_total_vuelta;
    }
}
?>

<?php

namespace App\Schedule;

use App\Models\Pasaje;
use Illuminate\Support\Carbon;

class DeletePasajesSinPagar {
    public function __invoke() {
        $dos_horas_antes = Carbon::now()->subHours(2);

        Pasaje::whereDate('created_at', '<=', $dos_horas_antes)
            ->whereHas('venta_detalle', function ($q){
                $q->whereHas('venta', function ($q){
                    $q->doesntHave('caja_movimiento');
                });
            })
            ->update(['is_caducado' => true])
            ->delete();
    }
}
?>

<?php

namespace App\Http\Livewire\Intranet\Caja\CajaAperturaCierre;

use App\Models\CajaAperturaCierreBillete;
use App\Models\DenominacionBillete;
use App\Models\CajaAperturaCierre;
use App\Models\CajaMovimiento;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Tarjeta;
use PDF;

class Show extends Component
{
    use WithPagination;

    public $apertura_cierre_id;
    public $tab = 'resumen';

    public function mount($apertura_cierre_id)
    {
        $this->apertura_cierre = CajaAperturaCierre::find($apertura_cierre_id);
        $this->tarjetas = Tarjeta::get();
    }

    public function render()
    {
        return view('livewire.intranet.caja.caja-apertura-cierre.show', [
            'denominaciones' => CajaAperturaCierreBillete::whereAperturaCierreId($this->apertura_cierre->id)->paginate(5),
            'movimientos' => CajaMovimiento::whereAperturaCierreId($this->apertura_cierre->id)->paginate(5)
        ]);
    }

    public function setTab($tab)
    {
        $this->tab = $tab;
    }

    public function print()
    {
        $pdfContent = PDF::loadView('livewire.intranet.caja.caja-apertura-cierre.exports.pdf', [
                            'apertura_cierre' => $this->apertura_cierre,
                        ])
                        // ->setPaper('a5', 'landscape')
                        ->output();
        return response()->streamDownload(
                    fn () => print($pdfContent),
                    "Cierre Caja N°{$this->apertura_cierre->codigo}.pdf"
                );
    }
}

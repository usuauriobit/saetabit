<?php

namespace App\Http\Livewire\Intranet\Caja\Extorno;

use App\Models\CajaMovimiento;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public $tab = 'solicitud';
    public $desde = null;
    public $hasta = null;

    public function mount()
    {
        $this->desde = date('Y-m-d');
        $this->hasta = date('Y-m-d');
    }

    public function setTab($tab)
    {
        $this->tab = $tab;
    }

    public function render()
    {
        return view('livewire.intranet.caja.extorno.index', [
            'solicitudes' => CajaMovimiento::whereNotNull('solicitud_extorno_by')
                                ->whereHas('caja', function ($query) {
                                    $query->whereOficinaId(Auth::user()->personal->oficina_id);
                                })
                                ->paginate(10),
            'extornos' => CajaMovimiento::onlyTrashed()
                                ->whereHas('caja', function ($query) {
                                    $query->whereOficinaId(Auth::user()->personal->oficina_id);
                                })
                                ->when($this->desde, function ($query) {
                                    $query->whereDate('solicitud_extorno_date', '>=', $this->desde);
                                })
                                ->when($this->hasta, function ($query) {
                                    $query->whereDate('solicitud_extorno_date', '<=', $this->hasta);
                                })
                                ->paginate(10)
        ]);
    }

    public function extornarMovimiento($caja_movimiento_id)
    {
        $movimiento = CajaMovimiento::find($caja_movimiento_id);
        $movimiento->update(['solicitud_extorno_aproved_by' => Auth::user()->id]);
        foreach ($movimiento->documentable->detalle as $key => $value) {
            $value->documentable()->delete();
            $value->delete();
        }

        $movimiento->documentable()->delete();
        $movimiento->delete();

        $this->emit('notify', 'success', 'El movimiento se extorno correctamente 😃.');
    }

    public function rechazarExtorno($caja_movimiento_id)
    {
        $movimiento = CajaMovimiento::find($caja_movimiento_id);
        $movimiento->update([
            'solicitud_extorno_by' => null,
            'solicitud_extorno_date' => null,
            'motivo_extorno' => null
        ]);
    }
}

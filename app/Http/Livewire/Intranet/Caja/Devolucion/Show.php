<?php

namespace App\Http\Livewire\Intranet\Caja\Devolucion;

use App\Models\Devolucion;
use App\Models\Pasaje;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Show extends Component
{
    public Devolucion $devolucion;

    public function render()
    {
        return view('livewire.intranet.caja.devolucion.show');
    }

    public function approve()
    {
        DB::transaction( function () {
            $this->devolucion->update([
                'reviewed_by_id' => Auth::user()->id,
                'date_reviewed' => date('Y-m-d'),
                'status_reviewed' => 'Aprobado'
            ]);

            $model = $this->devolucion->placelable->documentable_type::find($this->devolucion->placelable->documentable_id);
            $model->delete();
        });

        $this->devolucion->refresh();
    }

    public function toRefuse()
    {
        $this->devolucion->update([
            'reviewed_by_id' => Auth::user()->id,
            'date_reviewed' => date('Y-m-d'),
            'status_reviewed' => 'Rechazado'
        ]);

        $this->devolucion->refresh();
    }
}

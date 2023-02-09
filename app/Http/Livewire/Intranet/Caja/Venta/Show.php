<?php

namespace App\Http\Livewire\Intranet\Caja\Venta;

use App\Models\Caja;
use Illuminate\Support\Facades\Request;
use App\Models\CajaAperturaCierre;
use App\Models\CajaMovimiento;
use App\Models\VentaDetalle;
use Livewire\Component;
use App\Models\Venta;

class Show extends Component
{
    public Venta $venta;
    public $caja_apertura_id;
    public $caja_id;
    public $nro_pagination = 10;
    public $form = [];
    public $venta_detalle = null;
    public $tab = 'detalle';

    protected function rules(){
        $rules = [
			'form.descripcion' => 'required|string',
			'form.cantidad' => 'required|numeric|min:0.01',
			'form.monto' => 'required|numeric|min:0.01',
        ];

        return $rules;
    }

    protected $queryString = [
        'caja_apertura_id',
        'caja_id'
    ];

    public $listeners = [
        'movimientoCreated' => '$refresh'
    ];

    public function setTab($tab){
        $this->tab = $tab;
    }

    public function mount()
    {
        $this->caja_apertura_cierre = CajaAperturaCierre::find($this->caja_apertura_id);
        $this->caja = Caja::find($this->caja_id);
        // dd($this->caja);
    }

    public function render()
    {
        return view('livewire.intranet.caja.venta.show', [
            'detalle' => $this->venta->detalle()->latest()->paginate($this->nro_pagination),
            'movimientos' => $this->venta->caja_movimiento()->latest()->paginate($this->nro_pagination),
        ]);
    }

    public function createVentaDetalle()
    {

    }
    public function editDetalle(VentaDetalle $venta_detalle)
    {
        $this->venta_detalle = $venta_detalle;
        $this->form = $venta_detalle->toArray();
    }
    public function save()
    {
        $this->venta_detalle ? $this->update() : $this->store();
        $this->return();
    }
    public function store()
    {
        $form = $this->validate();
        $this->venta_detalle = VentaDetalle::create(array_merge($form['form'], [
                'documentable_type' => $this->venta->detalle[0]->documentable_type,
                'documentable_id' => $this->venta->detalle[0]->documentable_id,
                'venta_id' => $this->venta->id,
        ]));
    }
    public function update()
    {
        $form = $this->validate();
        $this->venta_detalle->update($form['form']);
    }
    public function return()
    {
        $this->form = [];
        $this->venta_detalle = null;
        $this->emit('closeModals');
        $this->emit('notify', 'success', 'Se registró correctamente 😃.');
    }
    public function destroyMovimiento($id)
    {
        CajaMovimiento::find($id)->delete();
        $this->emit('notify', 'success', 'Se eliminó el movimiento correctamente 😃.');
    }
}

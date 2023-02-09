<?php

namespace App\Http\Livewire\Intranet\Caja\Devolucion;

use App\Models\Banco;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Auth;
use App\Models\DevolucionMotivo;
use App\Models\VentaDetalle;
use Livewire\Component;
use Carbon\Carbon;

class Create extends Component
{
    public $venta_detalle_id = null;
    public $form = [];
    public $devolucion = null;

    protected function rules(){
        $rules = [
			'form.oficina_id' => 'required|exists:oficinas,id',
			'form.banco_id' => 'required|exists:bancos,id',
			'form.devolucion_motivo_id' => 'required|exists:devolucion_motivos,id',
			'form.importe' => 'required|numeric|min:0.01',
			'form.gastos_administrativos' => 'required|numeric|min:0.00',
			'form.fecha' => 'required|date',
			'form.observacion' => 'nullable',
			'form.nro_cuenta_bancaria' => 'required',
        ];

        return $rules;
    }

    protected $queryString = ['venta_detalle_id'];

    public function mount()
    {
        $this->venta_detalle = VentaDetalle::find($this->venta_detalle_id);
        $this->motivos = DevolucionMotivo::orderBy('descripcion')->get();
        $this->bancos = Banco::get();
        $this->form['oficina_id'] = Auth::user()->personal->oficina_id;
        $this->form['importe'] = $this->venta_detalle->importe;
        $this->form['gastos_administrativos'] = $this->calculoDescuentos();
        $this->form['fecha'] = date('Y-m-d');
    }

    public function render()
    {
        return view('livewire.intranet.caja.devolucion.create');
    }

    public function save()
    {
        $this->devolucion ? $this->update() : $this->store();
        $this->return();
    }

    public function store()
    {
        $form = $this->validate();
        $this->devolucion = $this->venta_detalle->devolucion()->create($form['form']);
        // $this->venta_detalle->documentable()->delete();
    }

    public function return()
    {
        return redirect()->route('intranet.caja.devolucion.index')->with('success', 'Devolución generada correctamente');
    }

    public function getImporteADevolverProperty()
    {
        $gastos = (array_key_exists('gastos_administrativos', $this->form)) ? (double) $this->form['gastos_administrativos'] : 0;
        return round($this->form['importe'] - $gastos, 2);
    }

    public function calculoDescuentos()
    {
        if ($this->venta_detalle->documentable_type == 'App\Models\Pasaje') {
            if($this->venta_detalle->documentable->tipo_vuelo->descripcion == 'Comercial')
                return $this->form['gastos_administrativos'] = 42;


            if ($this->venta_detalle->documentable->tipo_vuelo->descripcion == 'Subvencionado') {
                $diferencia_horas = Carbon::now()->diffInHours($this->venta_detalle->documentable->vuelo_origen->fecha_hora_vuelo_programado->format('Y-m-d H:i:s'));

                if ($diferencia_horas > 72)
                    return $this->form['gastos_administrativos'] = 20;

                if ($diferencia_horas > 48)
                    return $this->form['gastos_administrativos'] = round((double) $this->form['importe'] * 0.5, 2);
            }
        }

        return $this->form['gastos_administrativos'] = 0;
    }
}

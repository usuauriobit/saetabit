<?php

namespace App\Http\Livewire\Intranet\Caja\Comprobante;

use App\Models\Caja;
use Barryvdh\Debugbar\Facades\Debugbar;
use App\Services\FacturacionService;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use App\Models\Comprobante;
use Livewire\Component;
use Carbon\Carbon;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $nro_documento = '';
    public $nro_pagination = 10;
    public $error = null;
    public $serie = null;
    public $correlativo = null;
    public $desde = null;
    public $desde_c = null;
    public $hasta = null;
    public $hasta_h = null;
    public $cajas = [];
    public $caja = null;
    public $form = [];

    protected function rules()
    {
        $rules = [
			'form.comprobante_id' => 'required|exists:comprobantes,id',
			'form.motivo_anulacion' => 'required|string',
        ];

        return $rules;
    }

    public function mount()
    {
        $this->cajas = Caja::whereIn('id', Auth::user()->personal->cajas->pluck('id'))->get();
        $this->desde_c = date('Y-m-d');
        $this->hasta_c = date('Y-m-d');
        $this->desde = date('Y-m-d');
        $this->hasta = date('Y-m-d');
    }

    public function render()
    {
        $search = '%'.$this->search .'%';
        $nro_documento = '%'.$this->nro_documento .'%';

        return view('livewire.intranet.caja.comprobante.index', [
            'items' => Comprobante::withTrashed()
                    ->latest()
                    ->when($this->serie, function ($query) {
                        $query->where('serie', 'like', "%$this->serie%");
                    })
                    ->when($this->correlativo, function ($query) {
                        $query->where('correlativo', 'like', "%$this->correlativo%");
                    })
                    ->when($this->desde, function ($query) {
                        $query->whereDate('fecha_emision', '>=', $this->desde);
                    })
                    ->when($this->hasta, function ($query) {
                        $query->whereDate('fecha_emision', '<=', $this->hasta);
                    })
                    ->when($this->caja, function ($query) {
                        $query->whereHas('documentable.caja_movimiento', function ($query) {
                            $query->whereCajaId($this->caja);
                        });
                    })
                    ->paginate(10),
            'comprobantes_disponibles' => Comprobante::whereNull('comprobante_modifica_id')
                                            ->when(strlen($this->search) > 2, function($query) use ($search){
                                                $query->where('denominacion', 'like', $search);
                                            })
                                            ->when(strlen($this->nro_documento) > 2, function($query) use ($nro_documento){
                                                $query->where('nro_documento', 'like', $nro_documento);
                                            })
                                            ->paginate(10),
        ]);
    }

    public function enviarJson($comprobante_id)
    {
        $comprobante = Comprobante::find($comprobante_id);
        FacturacionService::enviarJson($comprobante, "generar_comprobante");
        $this->emit('notify','success', 'Comprobante enviado');
    }

    public function motivoAnulacion($comprobante_id)
    {
        $this->form['comprobante_id'] = $comprobante_id;
    }

    public function anularComprobante()
    {
        $form = $this->validate();
        $comprobante = Comprobante::withTrashed()->find($form['form']['comprobante_id']);
        FacturacionService::enviarJson($comprobante, "generar_anulacion");
        $comprobante->update([
            'anulacion_by' => Auth::user()->id,
            'motivo_anulacion' => $form['form']['motivo_anulacion']
        ]);
        $comprobante->delete();

        $this->return();
    }

    public function showError($id)
    {
        $this->error = optional(Comprobante::find($id)->ultima_respuesta ?? null)->errors;
        Debugbar::info(optional(Comprobante::find($id)->ultima_respuesta ?? null)->errors);
    }

    public function enviarDatosFacturacion($comprobante_id)
    {
        $comprobante = Comprobante::find($comprobante_id);

        if ($this->caja != null) {
            return redirect()->route('intranet.caja.facturacion.create', [
                        'caja_apertura_cierre_id' => $comprobante->caja_apertura_cierre_id,
                        'comprobante_id' => $comprobante->id,
                        'caja_id' => $this->caja
                    ]);
        } else {
            $this->emit('notify', 'error', 'Debe seleccionar una caja para poder emitir un comprobante');
        }
    }

    public function return()
    {
        $this->form = [];
        $this->emit('closeModals');
        $this->emit('notify', 'success', 'Se anuló correctamente el comprobante 😃.');
        // redirect()->route('intranet.caja.caja.show', $this->caja ?? $this->apertura_cierre->caja_id);
    }
}

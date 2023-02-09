<?php

namespace App\Http\Livewire\Intranet\Caja\Caja;

use App\Models\Caja;
use App\Models\CajaMovimiento;
use App\Models\CajaTipoComprobante;
use App\Models\Cliente;
use App\Models\Persona;
use App\Models\Venta;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Livewire\Component;

class Show extends Component
{
    use WithPagination;

    public Caja $caja;
    public $search = '';
    public $search_ventas = '';
    public $search_ventas_cliente = '';
    public $current_date;
    public $nro_pagination = 10;
    public $form = [];
    public $listeners = [
        'daySelected' => 'setDay'
    ];

    protected function rules(){
        $rules = [
			'form.caja_movimiento_id' => 'required|exists:caja_movimientos,id',
			'form.motivo_extorno' => 'required|string',
        ];

        return $rules;
    }

    public function mount()
    {
        $this->current_date = date('Y-m-d');
        $this->nro_movimientos_sin_facturar = CajaMovimiento::doesntHave('documentable.comprobante')
                                                ->whereAperturaCierreId(optional($this->caja->apertura_pendiente ?? null)->id)
                                                ->where('monto', '>', 0)
                                                ->count();
        $this->caja_comprobantes = CajaTipoComprobante::get();
    }

    public function render()
    {
        $search_ventas = '%'.$this->search_ventas .'%';
        $search_ventas_cliente = '%'.$this->search_ventas_cliente .'%';

        return view('livewire.intranet.caja.caja.show', [
            'items' => CajaMovimiento::withTrashed()
                                ->whereAperturaCierreId(optional($this->caja->apertura_pendiente ?? null)->id)
                                ->orderBy('fecha', 'desc')
                                ->orderBy('id', 'desc')
                                ->paginate($this->nro_pagination),
            'ventas_disponibles' => Venta::query()
                                        // ->whereOficinaId($this->caja->oficina_id)
                                        ->doesntHave('caja_movimiento')
                                        ->when(strlen($this->search_ventas) > 2, function($query) use ($search_ventas){
                                            return $query->where( function ($query) use ($search_ventas) {
                                                $query->orWhereHasMorph(
                                                    'clientable',
                                                    [Persona::class, Cliente::class],
                                                    function ($query, $type) use ($search_ventas) {
                                                        $column = $type === Persona::class ? 'nro_doc' : 'ruc';
                                                        $query->where($column, 'like', $search_ventas);
                                                    }
                                                );
                                            });
                                        })
                                        ->when(strlen($this->search_ventas_cliente) > 2, function($query) use ($search_ventas_cliente){
                                            return $query->where( function ($query) use ($search_ventas_cliente) {
                                                $query->orWhereHasMorph(
                                                    'clientable',
                                                    [Persona::class, Cliente::class],
                                                    function ($query, $type) use ($search_ventas_cliente) {
                                                        if ($type === Persona::class)
                                                            $query->whereNombreLike($search_ventas_cliente);
                                                        else
                                                            $query->where('razon_social', 'like', $search_ventas_cliente);
                                                    }
                                                );
                                            });
                                        })
                                        ->latest()
                                        ->paginate(10)
        ]);
    }
    public function setDay($date)
    {
        $this->current_date = $date;
    }
    public function getFechaProperty()
    {
        return Carbon::parse($this->current_date)->formatLocalized('%d %B %Y');
    }
    public function createExtorno($caja_movimiento_id)
    {
        $this->form['caja_movimiento_id'] = $caja_movimiento_id;
    }
    public function storeExtorno()
    {
        $movimiento = CajaMovimiento::find($this->form['caja_movimiento_id']);
        $movimiento->update([
            'solicitud_extorno_by' => Auth::user()->id,
            'solicitud_extorno_date' => date('Y-m-d H:i:s'),
            'motivo_extorno' => $this->form['motivo_extorno']
        ]);

        $this->form = [];
        $this->emit('closeModals');
        $this->emit('notify', 'success', 'Solicitud de extorno generado correctamente 😃.');
    }

    public function refresh(){
        return redirect()->route('intranet.caja.caja.show', $this->caja->id)->with('success', 'sadadad');
    }

    public function createMovimiento($venta_id)
    {
        // $venta = Venta::find($venta_id);
        // $apertura_pendiente = ($this->caja->apertura_pendiente) ? $this->caja->apertura_pendiente->id : null;
        return redirect()->route('intranet.caja.venta.show', [
            'venta' => Venta::find($venta_id),
            'caja_apertura_id' => ($this->caja->apertura_pendiente) ? $this->caja->apertura_pendiente->id : null,
            'caja_id' => $this->caja->id
        ]);
    }
}

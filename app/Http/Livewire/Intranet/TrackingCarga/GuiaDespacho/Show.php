<?php

namespace App\Http\Livewire\Intranet\TrackingCarga\GuiaDespacho;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\GuiaDespachoDetalle;
use App\Models\MotivoAnulacion;
use App\Models\GuiaDespacho;
use App\Models\Oficina;
use App\Models\Venta;
use App\Services\TasaCambioService;
use Illuminate\Support\Str;
use Livewire\Component;
use PDF;

class Show extends Component
{
    public GuiaDespacho $guia_despacho;
    public $nro_pagination = 10;
    public $guia_despacho_detalle = null;
    public $motivos_anulacion = null;
    public $edit_guia_despacho_detalle_id = [];
    public $form = [];

    public $listeners = [
        'detalleSetted' => '$refresh',
        'anularGuiaDespachoConfirmated' => 'destroy'
    ];

    // public function mount(Request $request){
    //     $this->guia_despacho = GuiaDespacho::find($request)
    // }

    public function render(){
        $this->motivos_anulacion = MotivoAnulacion::get();
        return view('livewire.intranet.tracking-carga.guia-despacho.show', [
            'detalle' => $this->guia_despacho->detalles()->latest()->paginate($this->nro_pagination),
            'motivos_anulacion' => $this->motivos_anulacion,
        ]);
    }

    public function createDetalle(){
        $this->edit_guia_despacho_detalle_id = null;
    }
    public function editDetalle($id){
        $this->edit_guia_despacho_detalle_id = $id;
    }

    // public function beforeDestroy(GuiaDespacho $guia_despacho){
    //     // dd($this->motivos_anulacion);
    //     $this->guia_despacho = $guia_despacho;
    //     $this->form = [];
    // }
    public function destroy(GuiaDespacho $guia_despacho){
        // $guia_despacho->update(['motivo_anulacion_id' => $this->form['motivo_anulacion_id']]);
        $guia_despacho->delete();
        $this->guia_despacho->refresh();
        $this->emit('notify', 'success', 'Se anuló correctamente 😃.');
    }
    public function destroyDetalle(GuiaDespachoDetalle $guiaDespacho_detalle){
        $guiaDespacho_detalle->forceDelete();
        $this->emit('notify', 'success', 'Se eliminó correctamente 😃.');
    }
    public function return() {
        $this->edit_guia_despacho_detalle_id = [];
        $this->emit('closeModals');
        $this->emit('notify', 'success', 'Se registró correctamente 😃.');
    }
    public function print()
    {
        $pdfContent = PDF::loadView('livewire.intranet.tracking-carga.guia-despacho.exports.pdf', [
                            'guia_despacho' => $this->guia_despacho,
                            'oficinas' => Oficina::get(),
                        ])
                        ->setPaper('a5', 'landscape')
                        ->output();
        return response()->streamDownload(
                    fn () => print($pdfContent),
                    "Guía Despacho N°{$this->guia_despacho->codigo}.pdf"
                );
    }
    public function printSticker()
    {
        $pdfContent = PDF::loadView('livewire.intranet.tracking-carga.guia-despacho.exports.pdfSticker', [
                            'guia_despacho' => $this->guia_despacho,
                        ])
                        ->output();
        return response()->streamDownload(
                    fn () => print($pdfContent),
                    "Guía Despacho N°{$this->guia_despacho->codigo}.pdf"
                );
    }
    public function saveGuia(){
        $this->guia_despacho->update(['is_saved' => true]);
        $venta = Venta::create([
            'clientable_id' => $this->guia_despacho->remitente_id,
            'clientable_type' => get_class($this->guia_despacho->remitente)
        ]);

        foreach ($this->guia_despacho->detalles as $detalle) {
            $strCantidad = Str::padLeft(intval($detalle->cantidad), 2, '0');
            $venta->detalle()->create([
                'cantidad'      => $detalle->cantidad,
                'descripcion'   => "{$strCantidad} {$detalle->descripcion} ({$detalle->peso} kg.)",
                'monto'         => $detalle->importe,
                'documentable_id'   => $detalle->id,
                'documentable_type' => get_class($detalle),
            ]);
        }

        $this->emit('notify', 'success', 'Se guardó correctamente 😃.');
        $this->emit('notify', 'success', 'Se generó un movimiento pendiente en caja.');

        $this->guia_despacho->refresh();
    }

}

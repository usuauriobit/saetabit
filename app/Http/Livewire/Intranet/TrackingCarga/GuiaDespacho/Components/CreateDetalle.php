<?php

namespace App\Http\Livewire\Intranet\TrackingCarga\GuiaDespacho\Components;

use App\Models\GuiaDespacho;
use App\Models\GuiaDespachoDetalle;
use App\Models\GuiaDespachoStep;
use App\Services\TasaCambioService;
use Livewire\Component;

class CreateDetalle extends Component
{
    public $guiaDespachoDetalleId = null;
    public $guiaDespachoDetalle;
    public GuiaDespacho $guiaDespacho;
    public $form = [
        'is_sobre'      => false,
        'descripcion'   => '',
        'cantidad'      => 1,
        'peso'          => 0,
        'importe'       => 0,
        'alto'          => null,
        'ancho'         => null,
        'largo'         => null,
        'is_valorado'   => false,
        'monto_valorado'=> null,
    ];
    public function rules(){
        return [
            'form.is_sobre'     => 'required|boolean',
            'form.descripcion'  => 'required',
            'form.cantidad'     => 'required|numeric',
            'form.peso'         => 'required|numeric',
            'form.importe'      => 'required|numeric',
            'form.alto'         => 'nullable|numeric',
            'form.ancho'        => 'nullable|numeric',
            'form.largo'        => 'nullable|numeric',
            'is_valorado'       => 'required|boolean',
            'monto_valorado'    => $this->form['is_valorado'] ? 'required' : 'nullable',
        ];
    }
    public function mount(){
        if($this->guiaDespachoDetalleId){
            $this->guiaDespachoDetalle = GuiaDespachoDetalle::find($this->guiaDespachoDetalleId);
            $this->form = optional($this->guiaDespachoDetalle)->toArray();
        }
    }
    // public function getImporteSolesProperty(){
    //     return (new TasaCambioService())->getMontoSoles(( (float) $this->form['importe']) ?? 0);
    // }
    public function render() {
        return view('livewire.intranet.tracking-carga.guia-despacho.components.create-detalle');
    }
    public function save(){
        $this->guiaDespachoDetalle
            ? $this->update()
            : $this->store();
        $this->return();
    }
    public function store(){
        $data = $this->validate()['form'];
        $this->guiaDespacho->detalles()->create($data);
        $this->emit('notify', 'success', 'Se registró correctamente.');
    }
    public function update(){
        $data = $this->validate()['form'];
        $this->guiaDespachoDetalle->update($data);
        $this->emit('notify', 'success', 'Se editó correctamente.');
    }
    public function return(){
        $this->emit('closeModals');
        $this->emit('detalleSetted');
    }

    // public function createDetalle(){
    //     $this->form_guiaDespacho_detalle = [];
    //     $this->guiaDespacho_detalle = null;
    // }
    // public function editDetalle(GuiaDespachoDetalle $guiaDespacho_detalle){
    //     $this->guiaDespacho_detalle = $guiaDespacho_detalle;
    //     $this->form_guiaDespacho_detalle = $guiaDespacho_detalle->toArray();
    // }
    // public function destroyDetalle(GuiaDespachoDetalle $guiaDespacho_detalle){
    //     $guiaDespacho_detalle->forceDelete();
    //     $this->emit('notify', 'success', 'Se eliminó correctamente 😃.');
    // }
    // public function saveDetalle(){
    //     if($this->guiaDespacho_detalle)
    //         $this->updateDetalle();
    //     else
    //         $this->storeDetalle();
    //     $this->guiaDespacho->refresh();
    //     $this->return();
    // }
    // public function storeDetalle(){
    //     $form_guiaDespacho_detalle = $this->validate();
    //     $this->guiaDespacho_detalle = GuiaDespachoDetalle::create(array_merge(
    //         $form_guiaDespacho_detalle['form_guiaDespacho_detalle'],
    //         ['guiaDespacho_id' => $this->guiaDespacho->id]
    //     ));
    // }
    // public function updateDetalle(){
    //     $form_guiaDespacho_detalle = $this->validate();
    //     $this->guiaDespacho_detalle->update($form_guiaDespacho_detalle['form_guiaDespacho_detalle']);
    // }
}

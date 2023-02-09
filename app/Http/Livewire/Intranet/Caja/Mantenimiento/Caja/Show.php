<?php

namespace App\Http\Livewire\Intranet\Caja\Mantenimiento\Caja;

use App\Models\Caja;
use App\Models\CajaTipoComprobante;
use App\Models\Personal;
use App\Models\TipoComprobante;
use Livewire\Component;

class Show extends Component
{
    public Caja $caja;
    public $caja_tipo_comprobante = null;
    public $form = null;
    public $array_cajeros = [];

    protected function rules(){
        $rules = [
			'form.tipo_comprobante_id' => 'required',
			'form.serie' => 'required',
        ];

        return $rules;
    }

    public function hydrate()
    {
        $this->emit('loadSelect2Hydrate');
    }

    public function mount()
    {
        $this->tipo_comprobantes = TipoComprobante::get();
        $this->cajeros = Personal::whereOficinaId($this->caja->oficina_id)->get();
        $this->array_cajeros = $this->caja->cajeros->pluck('id');
    }

    public function render()
    {
        return view('livewire.intranet.caja.mantenimiento.caja.show');
    }

    public function create()
    {
        $this->form['serie'] = $this->caja->serie;
    }

    public function edit($id)
    {
        $this->caja_tipo_comprobante = CajaTipoComprobante::find($id);
        $this->form = $this->caja_tipo_comprobante;
    }

    public function save()
    {
        $this->caja_tipo_comprobante ? $this->update() : $this->store();
        $this->return();
    }

    public function store()
    {
        $form = $this->validate();
        $this->caja_tipo_comprobante = $this->caja->comprobantes()->create($form['form']);
    }

    public function update()
    {
        $form = $this->validate();
        $this->caja_tipo_comprobante->update($form['form']);
    }

    public function return()
    {
        $this->form = [];
        $this->caja_tipo_comprobante = null;
        $this->emit('closeModals');
        $this->emit('notify', 'success', 'Se registró correctamente 😃.');
        $this->caja->refresh();
    }

    public function asignarCajeros()
    {
        // dd($this->array_cajeros);
        $this->caja->cajeros()->sync($this->array_cajeros);
        $this->caja->refresh();
        $this->emit('closeModals');
        $this->emit('notify', 'success', 'Cajeros asignados correctamente 😃.');
    }
}

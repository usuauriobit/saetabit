<?php

namespace App\Http\Livewire\Intranet\Caja\Caja;

use App\Models\Caja;
use App\Models\Oficina;
use App\Models\Personal;
use App\Models\TipoCaja;
use Livewire\Component;

class Create extends Component
{
    public $caja;
    public $oficinas;
    public $tipo_caja;
    public $personal;

    public $form;

    public function rules() {
        $rules = [
            'form.oficina_id' => 'required|exists:oficinas,id',
            'form.cajero_id' => 'required|exists:personals,id',
            'form.tipo_caja_id' => 'required|exists:tipo_cajas,id',
            'form.descripcion' => 'required|string',
        ];

        return $rules;
    }

    public function mount($caja = null)
    {
        if(!is_null($caja)) {
            $this->caja = Caja::find($caja);
            $this->form = $this->caja->toArray();
        }
        $this->oficinas = Oficina::get();
        $this->tipo_caja = TipoCaja::get();
        $this->personal = Personal::get();
    }

    public function render()
    {
        return view('livewire.intranet.caja.caja.create');
    }

    public function save(){
        ($this->caja) ? $this->update() : $this->store();

        $this->return();
    }

    public function store()
    {
        $form = $this->validate();
        $this->caja = Caja::create($form['form']);
    }

    public function update()
    {
        $form = $this->validate();
        $this->caja->update($form['form']);
    }

    public function return()
    {
        $this->form = [];
        return redirect()->route('intranet.caja.caja.show', $this->caja);
    }
}

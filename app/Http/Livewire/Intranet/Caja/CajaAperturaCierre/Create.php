<?php

namespace App\Http\Livewire\Intranet\Caja\CajaAperturaCierre;

use App\Models\Caja;
use App\Models\CajaAperturaCierre;
use App\Models\DenominacionBillete;
use App\Rules\Caja\MontoCierreCaja;
use Barryvdh\Debugbar\Facades\Debugbar as Debugbar;
use Livewire\Component;

class Create extends Component
{
    public $caja = null;
    public $apertura_cierre = null;
    public $denominaciones = null;
    public $form = [
        'denominaciones' => []
    ];
    protected function rules()
    {
        if($this->apertura_cierre){
            $rules = [
                'form.fecha_cierre' => 'required|date',
                'form.denominaciones' => ['required', 'array', new MontoCierreCaja($this->apertura_cierre->id)]
            ];
        } else {
            $rules = [
                'form.fecha_apertura' => 'required|date',
                'form.observacion_apertura' => 'nullable|string',
            ];
        }
        return $rules;
    }

    public function mount($caja_id = null, $apertura_cierre_id = null)
    {
        if($apertura_cierre_id) {
            $this->apertura_cierre = CajaAperturaCierre::find($apertura_cierre_id);
            $this->denominaciones = DenominacionBillete::get();
            $this->form['fecha_cierre'] = date('Y-m-d\TH:i');

            foreach ($this->denominaciones as $dominacion) {
                $this->form['denominaciones'][$dominacion['id']] = 0;
            }
        }

        if($caja_id) {
            $this->caja = Caja::find($caja_id);
            $this->form['fecha_apertura'] = date('Y-m-d\TH:i');
        }


    }

    public function render()
    {
        return view('livewire.intranet.caja.caja-apertura-cierre.create');
    }

    public function save()
    {
        $this->apertura_cierre ? $this->update() : $this->store();
        // $this->return();
    }

    public function store()
    {
        $form = $this->validate();
        $this->apertura_cierre = CajaAperturaCierre::create(array_merge($form['form'], ['caja_id' => $this->caja->id]));
        $this->form = [];
        $this->emit('closeModals');
        redirect()->route('intranet.caja.caja.show', $this->caja ?? $this->apertura_cierre->caja_id);
    }

    public function update()
    {
        $form = $this->validate();
        $this->apertura_cierre->update($form['form']);
        collect($form['form']['denominaciones'])
            ->each( function ($item, $key) {
                $this->apertura_cierre->billetes()->create([
                    'denominacion_id' => $key,
                    'cantidad' => ($item != '' || $item != null) ? (double) $item : 0,
                ]);
            });

        $this->form = [];
        $this->emit('closeModals');
        redirect()->route('intranet.caja.caja-apertura-cierre.show', $this->apertura_cierre->id);
    }

    public function return()
    {
        $this->form = [];
        $this->emit('closeModals');
        redirect()->route('intranet.caja.caja.show', $this->caja ?? $this->apertura_cierre->caja_id);
    }
}

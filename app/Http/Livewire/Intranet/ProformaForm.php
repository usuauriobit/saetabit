<?php

namespace App\Http\Livewire\Intranet;

use App\Models\Ubicacion;
use App\Models\TipoVuelo;
use Livewire\Component;
use App\Models\Avion;
use PDF;

class ProformaForm extends Component
{
    public $form = [];
    public $avion = null;
    public $ubicacion_origen = null;
    public $ubicacion_destino = null;
    public $listeners = [
        'avionSelected' => 'setAvion',
        'ubicacionSelected' => 'setUbicacion'
    ];
    protected $rules = [
			'form.tipo_vuelo_id' => 'required',
			'form.fecha' => 'required',
			'form.cliente' => 'required',
			'form.avion_id' => 'required',
			'form.origen_id' => 'required',
			'form.destino_id' => 'required',
			'form.precio' => 'required',
    ];
    public function render()
    {
        $tipo_vuelos = TipoVuelo::whereCategoriaVueloId(4)->get();
        return view('livewire.intranet.proforma-form', compact('tipo_vuelos'));
    }
    public function setAvion(Avion $avion)
    {
        $this->avion = $avion;
        $this->form['avion_id'] = $avion->id;
    }

    public function removeAvion()
    {
        $this->avion = null;
        $this->form['avion_id'] = null;
    }
    public function setUbicacion($type, Ubicacion $ubicacion)
    {
        if($type == 'origen'){
            $this->ubicacion_origen  = $ubicacion;
            $this->form['origen_id'] = $ubicacion->id;

        }elseif($type == 'destino'){
            $this->ubicacion_destino = $ubicacion;
            $this->form['destino_id'] = $ubicacion->id;

        }elseif($type == 'escala'){
            $this->form['escalas'][] = [
                'data' => $ubicacion,
            ];
        }
    }
    public function removeUbicacionOrigen()
    {
        $this->ubicacion_origen  = null;
        $this->form['origen_id'] = null;
    }
    public function removeUbicacionDestino()
    {
        $this->ubicacion_destino = null;
        $this->form['destino_id'] = null;
    }
    public function generarPdf()
    {
        $form = $this->validate($this->rules);
        $notas = $this->obtenerNotas(TipoVuelo::find($form['form']['tipo_vuelo_id']));
        $pdfContent = PDF::loadView('livewire.intranet.proforma-pdf', [ 'form' => $form['form'], 'notas' => $notas ])->output();
        $this->return();
        return response()->streamDownload(
            fn () => print($pdfContent),
            "Proforma - {$form['form']['cliente']} - {$form['form']['fecha']}.pdf"
        );
    }
    public function return()
    {
        $this->form = [];
        $this->emit('closeModals');
        $this->emit('notify', 'success', 'Proforma generada correctamente 😃.');
    }
    public function obtenerNotas($tipo_vuelo)
    {
        $array = [];
        switch ($tipo_vuelo->id) {
            case '4':
                    $array = [];
                break;
            case '5':
                    $array = [];
                break;
            case '6':
                    $array = [
                        'Vuelo incluye el pago de los impuestos TUUA.',
                        'El vuelo incluye medico a bordo y ambulancia en lima.',
                        'Aeronave con capacidad para trasladar 01 paciente en camilla más familiar.',
                    ];
                break;
            case '7':
                    $array = [];
            default:
                    $array = [];
                break;
        }

        return $array;
    }
}

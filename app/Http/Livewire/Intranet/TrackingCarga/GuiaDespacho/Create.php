<?php

namespace App\Http\Livewire\Intranet\TrackingCarga\GuiaDespacho;

use App\Models\GuiaDespacho;
use App\Models\Oficina;
use App\Models\Persona;
use App\Models\Ubicacion;
use App\Models\User;
use App\Services\PersonaService;
use App\Services\UserPasswordService;
use Illuminate\Http\Request;
use Livewire\Component;

class Create extends Component
{

    public $oficina;
    public $guia_despacho;
    public $form = [
        'is_free' => false,
    ];
    public $remitente = null;
    public $consignatario = null;
	public $rutas, $remitentes, $consignatarios, $detalless;
    public $step = 1;
    public $codigo;
    public $aproved_by;

    public function rules(){
        return [
            [
                'form.remitente_id' => 'required',
                'form.consignatario_id' => 'required',
            ],
            [
                'form.origen_id' => 'required',
                'form.destino_id' => 'required',
            ],
            [
                'form.is_free' => 'required',
                'form.codigo' => 'required',
                // 'form.password_approved' => $this->form['is_free'] ? 'required' : 'nullable',
            ]
        ];
    }

    // protected function rules(){
    //     $rules = [
    //         [
    //             'form.remitente_id' => 'required',
    //             'form.consignatario_id' => 'required',
    //         ],
    //         [
    //             'form.origen_id' => 'required',
    //             'form.destino_id' => 'required',
    //         ],
    //         [
    //             'form.fecha' => 'required',
    //             'form.codigo' => 'required',
    //         ]
    //     ];

    //     // if($this->guia_despacho){
    //     //     $rules = array_merge($rules,[
    //     //         // RULES EXTRA FOR EDITING PURPOSES
    //     //     ]);
    //     // }
    //     return $rules;
    // }
    public $listeners = [
        // STEP 1
        'ubicacionSelected' => 'setUbicacion',
        'remitenteFounded' => 'setRemitente',
        'consignatarioFounded' => 'setConsignatario',
        'approvedFree' => 'setApprovedFree'
    ];
    public function mount($guia_despacho = null, $oficina_id = null){
        if(!is_null($guia_despacho)){
            $this->guia_despacho = GuiaDespacho::find($guia_despacho);
            $this->oficina = $this->guia_despacho->oficina;

            $this->remitente = $this->guia_despacho->remitente;
            $this->consignatario = $this->guia_despacho->consignatario;

            $this->ubicacion_origen  = $this->guia_despacho->origen;
            $this->ubicacion_destino = $this->guia_despacho->destino;

            $this->form = $this->guia_despacho->toArray();
            $this->form['consignatario_search'] = $this->consignatario->documento;
            $this->form['remitente_search'] = $this->remitente->documento;
        }else{
            $this->oficina = Oficina::find($oficina_id);
            $this->form['codigo'] = GuiaDespacho::generateCodigo();
            $this->form['oficina_id'] = $this->oficina->id;

            $origen_segun_oficina = Ubicacion::where('ubigeo_id', $this->oficina->ubigeo_id)->first();
            $this->ubicacion_origen  = $origen_segun_oficina ?? null;
            $this->form['origen_id'] = $origen_segun_oficina->id ?? null;
        }

		$this->rutas = \App\Models\Ruta::get();
		$this->remitentes = \App\Models\Persona::get();
		$this->consignatarios = \App\Models\Persona::get();
		$this->detalless = \App\Models\GuiaDespachoDetalle::get();

    }
    public function render()
    {
        return view('livewire.intranet.tracking-carga.guia-despacho.create');
    }
    // public function create(){
    //     $this->form = [];
    //     $this->guia_despacho = null;
    //     $this->remitente      = null;
    //     $this->consignatario  = null;
    // }
    // public function show(GuiaDespacho $guia_despacho){
    //     $this->guia_despacho = $guia_despacho;
    // }
    // public function destroy(GuiaDespacho $guia_despacho){
    //     $guia_despacho->delete();
    //     $this->emit('notify', 'success', 'Se eliminó correctamente 😃.');
    // }
    public function save(){
        $this->validate($this->rules()[$this->step-1]);
        $this->validatePersonas();
        // \Debugbar::info('PASA');

        if($this->guia_despacho)
            $this->update();
        else
            $this->store();
    }
    public function store(){
        $data = $this->form;
        $data['codigo'] = GuiaDespacho::generateCodigo();
        // \Debugbar::info($data);
        if($data['is_free'] && !$this->aproved_by){
            $this->emit('notify', 'error', 'No se puede crear una guía gratuita sin autorización.');
            return;
        }

        $this->guia_despacho = GuiaDespacho::create($data);

        $this->return();
    }
    public function update(){
        $this->validate([
            'form.codigo' => 'required|unique:guia_despachos,codigo,'.$this->guia_despacho->id,
        ]);
        $this->guia_despacho->update($this->form);

        $this->return();
    }
    public function return() {
        // $this->form = [];
        // $this->emit('closeModals');
        // $this->emit('notify', 'success', 'Se registró correctamente 😃.');
        return redirect()->route('intranet.tracking-carga.guia-despacho.show', $this->guia_despacho);
    }
    public function validatePersonas(){
        if(!$this->remitente || !$this->consignatario){
            $this->emit('notify', 'error', 'No se registró remitente o consignatario');
        }
    }
    public function setRemitente(Persona $persona){
        $this->remitente      = $persona;
        $this->form['remitente_id'] = $persona->id;
    }
    public function deleteRemitente(){
        $this->remitente      = null;
        $this->form['remitente_id'] = null;
    }
    public function setConsignatario(Persona $persona){
        $this->consignatario      = $persona;
        $this->form['consignatario_id'] = $persona->id;
    }
    public function deleteConsignatario(){
        $this->consignatario      = null;
        $this->form['consignatario_id'] = null;
    }
    public function setUbicacion($type, Ubicacion $ubicacion){
        if($type == 'origen'){
            $this->ubicacion_origen  = $ubicacion;
            $this->form['origen_id'] = $ubicacion->id;

        }elseif($type == 'destino'){
            $this->ubicacion_destino = $ubicacion;
            $this->form['destino_id'] = $ubicacion->id;
        }
        $this->emit('cleanUbicacionInput');
    }
    public function removeUbicacionOrigen(){
        $this->ubicacion_origen  = null;
        $this->form['origen_id'] = null;
    }
    public function removeUbicacionDestino(){
        $this->ubicacion_destino = null;
        $this->form['destino_id'] = null;
    }

    public function backStep(){
        $this->step--;
    }
    public function nextStep(){
        $this->validate($this->rules()[$this->step-1]);
        $this->step++;
    }

    public function setApprovedFree($eventId, $observacion, $userId){
        $this->aproved_by = User::find($userId);
    }
}

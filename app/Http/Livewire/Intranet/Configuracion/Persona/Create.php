<?php

namespace App\Http\Livewire\Intranet\Configuracion\Persona;

use Livewire\WithFileUploads;
use App\Models\TipoDocumento;
use App\Models\Nacionalidad;
use Livewire\Component;
use App\Models\Persona;
use App\Models\Ubigeo;
use Illuminate\Support\Facades\Storage;

class Create extends Component
{
    use WithFileUploads;

    public $ubigeos;
    public $nacionalidads;
    public $tipo_documentos;
    public $persona;
    public $form = [
        'nacionalidad_id'       => null,
        'tipo_documento_id'     => null,
        'nro_doc'               => null,
        'ubigeo_id'             => null,
        'sexo'                  => null,
        'lugar_nacimiento_id'   => null,
        'apellido_paterno'      => null,
        'apellido_materno'      => null,
        'nombres'               => null,
        'fecha_nacimiento'      => null,
        'photo'                 => null,
    ];
    public $routeRedirect = '#';
    public $idModal = 'createPersonaModal';
    public $emitName = 'personaCreated';
    public $isComponent = false;
    public function rules(){
        return [
            'form.nacionalidad_id'       => 'nullable|numeric',
            'form.tipo_documento_id'     => 'required|numeric',
            'form.nro_doc'               => 'required|'
                .(optional($this->tipo_documento)->descripcion === 'DNI' ? 'numeric' : 'string'),
            'form.sexo'                  => 'required|numeric|',
            // 'form.ruc'                   => 'nullable|numeric',
            'form.ubigeo_id'             => 'required|numeric',
            'form.lugar_nacimiento_id'   => 'nullable|numeric',
            'form.apellido_paterno'      => 'nullable',
            'form.apellido_materno'      => 'nullable',
            'form.nombres'               => 'required',
            'form.fecha_nacimiento'      => 'required|date',
            'form.photo'                 => 'nullable|image',
        ];
    }
    public $listeners = [
        'lugarNacimientoSetted' => 'setLugarNacimiento',
        'ubigeoSetted' => 'setUbigeo',
    ];
    public function mount($persona = null){

        $this->ubigeos = Ubigeo::all();
        $this->nacionalidads = Nacionalidad::all();
        $this->tipo_documentos = TipoDocumento::all();

        $this->persona = Persona::find($persona);

        $this->form['nacionalidad_id'] = Nacionalidad::whereDescripcion('Perú')->first()->id;
        $this->form['tipo_documento_id'] = $this->tipo_documentos[0]->id;
        $this->form['sexo'] = 1;

        if($this->persona){
            $this->form = $this->persona->toArray();
        }
    }
    public function render()
    {
        return view('livewire.intranet.configuracion.persona.create');
    }
    public function create(){
        $this->form = [];
        $this->persona = null;
    }
    public function edit(Persona $persona){
        $this->persona = $persona;
        $this->form = $persona->toArray();
    }
    public function save(){
        $form = $this->validate();
        ($this->persona) ? $this->update() : $this->store();
    }
    public function store(){
        $form = $this->validate();
        $persona_exist = Persona::whereNroDoc($this->form['nro_doc'])->first();
        if($persona_exist){
            $this->emit('notify', 'error', 'Ya existe una persona con este número de documento');
            return;
        }

        // dd('STORE');
        $form = $this->validate();
        // dd('dfgfdgdf');
        $this->persona = Persona::create($form['form']);
        \Debugbar::info('PERSONA CREADA', $this->persona);

        $this->saveImage();
        $this->return();
    }
    public function update(){
        // $persona_exist = Persona::whereNroDoc($this->form['nro_doc'])->first();
        // if($persona_exist && $persona_exist->id !== $this->persona->id){
        //     $this->emit('notify', 'error', 'Ya existe una persona con este nro de documento');
        //     return;
        // }

        $form = $this->validate();
        $this->persona->update($form['form']);

        $this->saveImage();
        $this->return();
    }
    public function saveImage(){
        if (isset($this->form['photo'])) {
            $url = Storage::putFile('public/personas', $this->form['photo']);
            $this->persona->update([ 'photo_url' => $url ]);
        }
    }
    public function return() {
        \Debugbar::info('PERSONA OBTENIDA', $this->persona);
        // dd($this->persona);
        // return;
        if(!$this->isComponent)
            return redirect()->route('intranet.configuracion.persona.index');

        $this->form = [];
        $this->emit($this->emitName, $this->persona->id);
        $this->emit('closeModals');
        $this->emit('notify', 'success', 'Se registró correctamente 😃.');
        return redirect($this->routeRedirect);
    }
    public function emitCancel(){
        $this->emit('createPersonaCancelled');
    }

    public function setUbigeo($id){
        $this->form['ubigeo_id'] = $id;
    }
    public function removeUbigeo(){
        $this->form['ubigeo_id'] = null;
    }
    public function getUbigeoProperty() {
        return Ubigeo::find($this->form['ubigeo_id']);
    }

    public function setLugarNacimiento($id){
        $this->form['lugar_nacimiento_id'] = $id;
    }
    public function removeLugarNacimiento(){
        $this->form['lugar_nacimiento_id'] = null;
    }
    public function getLugarNacimientoProperty() {
        return Ubigeo::find($this->form['lugar_nacimiento_id']);
    }

    public function getTipoDocumentoProperty(){
        return TipoDocumento::find($this->form['tipo_documento_id']);
    }
}

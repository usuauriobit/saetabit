<?php

namespace App\Http\Livewire\Intranet\Comercial\Descuento;

use App\Models\CategoriaDescuento;
use App\Models\Descuento;
use App\Models\DescuentoClasificacion;
use App\Models\Ruta;
use App\Models\TipoDescuento;
use App\Models\TipoPasaje;
use App\Services\TasaCambioService;
use Carbon\Carbon;
use Livewire\Component;

class Create extends Component {
    // public $is_monto = false;
    public ?Descuento $descuento = null;
    public $is_edit = false;
    // public $clasificacion = null;
    public $ruta = null;
    public $form = [
        'tipo_descuento_id' => '',
        'categoria_descuento_id' => '',
        'descuento_clasificacion_id' => '',
        'tipo_pasaje_id' => '',
        'ruta_id' => null,
        'descripcion' => '',
        'descuento_porcentaje' => 0,
        'descuento_monto' => '',
        'descuento_fijo' => '',
        'fecha_expiracion' => '',
        'codigo_cupon' => '',
        'nro_maximo' => '',

        'is_automatico' => '',
        'is_interno' => '',

        'nro_maximo' => '',
        'edad_minima' => '',
        'edad_maxima' => '',

        'dias_anticipacion' => '',
    ];

    public $listeners = [
        'rutaSelected' => 'setRuta'
    ];

    public $finished = false;

    protected function rules(){
        $rules = [
            'form.tipo_descuento_id' => 'required',
            'form.categoria_descuento_id' => 'required',
            'form.descuento_clasificacion_id' => 'required',
            'form.tipo_pasaje_id' => 'required',
            'form.descripcion' => 'required',
            'form.fecha_expiracion' => 'required',
            'form.nro_maximo' => 'required|numeric|min:0',
        ];
        if(!$this->is_edit){
            $rules['form.ruta_id'] = 'required';
            switch($this->clasificacion->descripcion){
                case 'Días de anticipación':
                    $rules['form.dias_anticipacion'] = 'required';
                    break;
                case 'Rango de edades':
                    $rules['form.edad_minima'] = 'required';
                    $rules['form.edad_maxima'] = 'required';
                    break;
            }
        }

        switch ($this->categoria->descripcion) {
            case 'Monto restado':
                $rules['form.descuento_monto']= 'required';
                break;
            case 'Porcentaje':
                $rules['form.descuento_porcentaje']= 'required';
                break;
            default:
                $rules['form.descuento_fijo']= 'required';
                break;
        }

        return $rules;
    }

    public function mount(){
        $this->categoria_descuentos     = CategoriaDescuento::get();
        $this->descuento_clasificacions = DescuentoClasificacion::get();
        $this->tipo_pasajes             = TipoPasaje::get();

        $this->form['tipo_descuento_id']            = TipoDescuento::whereDescripcion('Pasaje')->first()->id;
        $this->form['categoria_descuento_id']       = $this->categoria_descuentos->first()->id;
        $this->form['descuento_clasificacion_id']   = $this->descuento_clasificacions->first()->id;
        $this->form['tipo_pasaje_id']               = $this->tipo_pasajes->first()->id;

        $this->is_edit = isset($this->descuento);
        if($this->is_edit){
            $this->ruta = $this->descuento->ruta;
            // $this->clasificacion = $this->descuento->descuento_clasificacion;
            $this->form = $this->descuento->toArray();
        }

        $fecha_ultimo_mes = (new Carbon())->endOfMonth();
        $this->form['fecha_expiracion']     = $fecha_ultimo_mes->format('Y-m-d');
    }
    public function render(){
        return view('livewire.intranet.comercial.descuento.create');
    }
    public function setRuta(Ruta $ruta){
        $this->form['ruta_id'] = $ruta->id;
        $this->ruta = $ruta;
    }
    // public function getRutaProperty(){
    //     return Ruta::find($this->form['ruta_id']);
    // }
    public function deleteRuta(){
        $this->form['ruta_id'] = null;
        $this->ruta = null;
    }
    public function getMontoSolesProperty(){
        $monto = 0;
        $tasaCambioService = new TasaCambioService();
        switch (optional($this->categoria)->descripcion) {
            case 'Monto restado':
                $monto = $tasaCambioService->getMontoSoles((float) ($this->form['descuento_monto']) ?? 0);
                break;
            case 'fijo':
                $monto = $tasaCambioService->getMontoSoles((float) ($this->form['descuento_fijo']) ?? 0);
                break;
        }
        return $monto;
    }
    public function getCategoriaProperty(){
        return CategoriaDescuento::find($this->form['categoria_descuento_id']);
    }
    public function getClasificacionProperty(){
        return DescuentoClasificacion::find($this->form['descuento_clasificacion_id']);
    }
    public function save(){
        if($this->is_edit)
            $this->update();
        else
            $this->store();

        $this->finished = true;
    }

    public function store(){
        $data = $this->validate();
        Descuento::create(array_merge($data['form'], [
            'is_dolarizado' => $this->ruta->tipo_vuelo->is_comercial
        ]));
        $this->finished = true;
    }
    public function update(){
        $data = $this->validate();
        $this->descuento->update($data['form']);
        $this->finished = true;
    }

    // public function cleanData(){
    //     switch ($this->categoria->descripcion) {
    //         case 'Monto restado':
    //             $this->form['descuento_porcentaje'] = null;
    //             $this->form['descuento_fijo'] = null;
    //             break;
    //         case 'Porcentaje':
    //             $this->form['descuento_monto'] = null;
    //             $this->form['descuento_fijo'] = null;
    //             break;
    //         default:
    //             $this->form['descuento_porcentaje'] = null;
    //             $this->form['descuento_monto'] = null;
    //             break;
    //     }

    //     switch($this->clasificacion->descripcion){
    //         case 'Días de anticipación':
    //             $this->form['edad_minima'] = null;
    //             $this->form['edad_maxima'] = null;
    //             break;
    //         case 'Rango de edades':
    //             $this->form['dias_anticipacion'] = null;
    //             break;
    //     }
    // }
}

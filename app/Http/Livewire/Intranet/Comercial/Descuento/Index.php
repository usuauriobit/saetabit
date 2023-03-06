<?php

namespace App\Http\Livewire\Intranet\Comercial\Descuento;

use App\Models\CategoriaDescuento;
use App\Models\Descuento;
use App\Models\DescuentoClasificacion;
use App\Models\Ruta;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $nro_pagination = 10;
    public $search = '';
    public $ruta = null;

    public $clasificacions = [
        [
            'id' => null,
            'descripcion' => 'Todos'
        ]
    ];
    public $categorias = [
        [
            'id' => null,
            'descripcion' => 'Todos'
        ]
    ];

    public $estados = [
        [ 'id' => null, 'descripcion' => 'Todos'],
        [ 'id' => 'activos', 'descripcion' => 'Activos'],
        [ 'id' => 'expirados', 'descripcion' => 'Expirados'],
        [ 'id' => 'eliminados', 'descripcion' => 'Eliminados'],
    ];

    public $clasificacion_id = null;
    public $categoria_descuento_id = null;
    public $estado_id = null;

    public $listeners = [
        'rutaSelected' => 'setRuta'
    ];

    public function mount(){
        $this->categorias = array_merge($this->categorias, CategoriaDescuento::get()->toArray());
        $this->clasificacions = array_merge($this->clasificacions, DescuentoClasificacion::get()->toArray());

        // dd($this->clasificacions);
        // TIPOS DE DESCUENTOS:

        // POR CODIGO DE CUPON
        // POR IDA Y VUELTA
        // POR RUTA
        // POR PASAJE (SIN IMPORTAR QUE VUELO O RUTA ES)
    }

    public function render()
    {
        $search = '%'.$this->search .'%';
        return view('livewire.intranet.comercial.descuento.index', [
            'items' => Descuento::
                    // when($this->tab =='codigo_cupon', function($q){
                    //     $q->whereNotNull('codigo_cupon');
                    // })
                    // ->when($this->tab == 'ida_vuelta', function($q){
                    //     $q->where('is_for_ida_vuelta', true);
                    // })
                    // ->when($this->tab == 'ruta', function($q){
                    //     $q->whereNotNull('ruta_id');
                    // })
                    // ->when($this->tab == 'pasaje', function($q){
                    //     $q->whereHas('tipo_descuento', function($q){
                    //         $q->whereDescripcion('Pasaje')
                    //             ->where('is_interno', false);
                    //     });
                    // })
                    // ->when($this->tab == 'interno', function($q){
                    //     $q->where('is_interno', true);
                    // })
                    // ->when(strlen($this->search) > 2, function($q) use ($search){
                    //     return $q->Where('descripcion', 'ilike', $search);
                    // })
                    when($this->estado_id == 'expirados', function($q){
                        $q->whereExpirados();
                    })
                    ->when($this->estado_id == 'eliminados', function($q){
                        $q->where('deleted_at', '!=', null);
                    })
                    ->when($this->ruta, function($q){
                        $q->whereRutaId($this->ruta->id);
                    })
                    ->when($this->estado_id == 'activos', function($q){
                        $q->whereActivos();
                    })
                    ->when($this->clasificacion_id, function($q){
                        $q->where('descuento_clasificacion_id', $this->clasificacion_id);
                    })
                    ->when($this->categoria_descuento_id, function($q){
                        $q->where('categoria_descuento_id', $this->categoria_descuento_id);
                    })
                    ->with(['tipo_descuento', 'categoria_descuento', 'ruta', 'ruta.tramo', 'ruta.tramo.origen', 'ruta.tramo.escala', 'ruta.tramo.destino' ])
                    ->withTrashed()
                    ->paginate($this->nro_pagination)
        ]);
    }
    public function setTab($tab){
        $this->tab = $tab;
    }
    public function destroy(Descuento $descuento){
        $descuento->delete();
        $this->emit('notify', 'success', 'Se eliminó correctamente 😀');
    }
    public function setRuta(Ruta $ruta){
        $this->ruta = $ruta;
    }
    public function deleteRuta(){
        $this->ruta = null;
    }
}

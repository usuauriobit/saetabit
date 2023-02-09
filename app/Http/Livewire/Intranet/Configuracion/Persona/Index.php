<?php

namespace App\Http\Livewire\Intranet\Configuracion\Persona;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Persona;
use App\Models\TipoDocumento;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $persona = null;
    public $nro_pagination = 10;
    public $form = [];
    public $tipo_documento_id = null;
    public $nro_doc = '';
    public $nombre = '';

    protected $listeners = [
        'personaCreated' => 'personaCreated',
        'refresh' => '$refresh',
    ];

    public function mount()
    {
        $this->tipo_documentos = TipoDocumento::get();
    }

    public function render()
    {
		$search = '%'.$this->search .'%';
		$nro_doc = '%'.$this->nro_doc .'%';
		$nombre = '%'.$this->nombre .'%';

        return view('livewire.intranet.configuracion.persona.index', [
            'items' => Persona::orderBy('nombres', 'asc')
            ->when($this->tipo_documento_id, function ($query) {
                $query->whereTipoDocumentoId($this->tipo_documento_id);
            })
            ->when($this->nro_doc, function ($query) use ($nro_doc) {
                $query->where('nro_doc', 'like', $nro_doc);
            })
            ->when($this->nombre, function ($query) use ($nombre) {
                $query->whereNombreLike($nombre);
            })
            ->with(['tipo_documento'])
            ->paginate($this->nro_pagination),
        ]);
    }

    public function show(Persona $persona){
        $this->persona = $persona;
    }
    public function destroy(Persona $persona){
        $persona->delete();
        $this->emit('notify', 'success', 'Se eliminó correctamente 😃.');
    }

    public function personaCreated(){
        $this->emitSelf('refresh');
    }

}

<?php

namespace App\Http\Livewire\Intranet\Comercial\Cliente;

use App\Models\Cliente;
use App\Models\TipoDocumento;
use Livewire\WithPagination;
use App\Models\Persona;
use Livewire\Component;

class Index extends Component
{
    use WithPagination;

    public $tab = 'personas';
    public $tipo_documento_id = null;
    public $nro_documento = '';
    public $search = '';
    public $nro_pagination = 10;

    public function mount()
    {
        $this->tipo_documentos = TipoDocumento::get();
    }
    public function render()
    {
        $search = '%'.$this->search .'%';

        return view('livewire.intranet.comercial.cliente.index', [
            'personas' => Persona::has('ventas')->latest()->with(['tipo_documento', 'ubigeo'])
                            ->when(strlen($this->search) > 2, function($q) use ($search){
                                return $q->filterDatatable($search);
                            })
                            ->when($this->tipo_documento_id, function ($query) {
                                $query->whereTipoDocumentoId($this->tipo_documento_id);
                            })
                            ->when($this->nro_documento, function ($query) {
                                $query->where('nro_doc', 'like', "%{$this->nro_documento}%");
                            })
                            ->paginate($this->nro_pagination),
            'empresas' => Cliente::when($this->nro_documento, function ($query) {
                                $query->where('ruc', 'like', "%{$this->nro_documento}%");
                            })
                            ->when(strlen($this->search) > 2, function ($query) use ($search) {
                                $query->where('razon_social', 'like', $search);
                            })
                            ->paginate($this->nro_pagination),
        ]);
    }
    public function setTab($tab)
    {
        $this->tab = $tab;
        $this->tipo_documento_id = null;
        $this->nro_documento = '';
        $this->search = '';
    }
}

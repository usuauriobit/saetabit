<?php

namespace App\Http\Livewire\Intranet\Configuracion\Oficina;

use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Oficina;
use App\Models\Ubigeo;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $search = '';
    public $nro_pagination = 10;
    public $oficina = null;
	public $ubigeos;
	public $photo;
    public $form = [
        'ubigeo_id' => null,
    ];

    protected function rules(){
        $rules = [
			'form.ubigeo_id' => 'required',
			'form.geo_latitud' => 'nullable',
			'form.geo_longitud' => 'nullable',
			'form.descripcion' => 'nullable',
			'form.direccion' => 'nullable',
			'form.referencia' => 'nullable',
			'form.imagen_path' => 'nullable',
			'form.ruta_facturador' => 'nullable',
			'form.token_facturador' => 'nullable',
            // 'photo' => 'image|max:10000',
            'photo' => 'nullable|image|max:10000',
        ];

        if($this->oficina){
            $rules = array_merge($rules,[
                // RULES EXTRA FOR EDITING PURPOSES
            ]);
        }
        return $rules;
    }

    public function mount(){
		$this->ubigeos = \App\Models\Ubigeo::get();
    }

    public $listeners = [
        'ubigeoSetted' => 'setUbigeo',
    ];
    public function setUbigeo($id){
        $this->form['ubigeo_id'] = $id;
    }
    public function removeUbigeo(){
        $this->form['ubigeo_id'] = null;
    }
    public function getUbigeoProperty() {
        return Ubigeo::find($this->form['ubigeo_id']);
    }

    public function render()
    {
		$search = '%'.$this->search .'%';
        return view('livewire.intranet.configuracion.oficina.index', [
            'items' => Oficina::latest()
            ->when(strlen($this->search) > 2, function($q) use ($search){
				return $q
				->orWhereHas("ubigeo", function($q) use ($search){
                    return $q->where("descripcion", "LIKE", $search);
                })
				->orWhere("geo_latitud", "LIKE", $search)
				->orWhere("geo_longitud", "LIKE", $search)
				->orWhere("descripcion", "LIKE", $search)
				->orWhere("direccion", "LIKE", $search)
				->orWhere("referencia", "LIKE", $search);
            })
            ->paginate($this->nro_pagination),
        ]);
    }
    public function create(){
        $this->form = [
            'ubigeo_id' => null,
        ];
        $this->photo = '';
        $this->oficina = null;
    }
    public function show(Oficina $oficina){
        $this->oficina = $oficina;
        $this->emit('renderMap', [$oficina->geo_latitud, $oficina->geo_longitud]);
    }
    public function edit(Oficina $oficina){
        $this->oficina = $oficina;
        $this->form = $oficina->toArray();
    }
    public function destroy(Oficina $oficina){
        $oficina->delete();
        $this->emit('notify', 'success', 'Se eliminó correctamente 😃.');
    }
    public function save()
    {
        $this->oficina ? $this->update() : $this->store();
        $this->saveImage();
        $this->return();
    }
    public function store()
    {
        $form = $this->validate();
        $this->oficina = Oficina::create($form['form']);

    }
    public function update()
    {
        $form = $this->validate();
        $this->oficina->update($form['form']);
    }
    public function saveImage()
    {
        if ($this->photo) {
            $url = Storage::putFile('public/oficinas', $this->photo);
            $this->oficina->update([ 'imagen_path' => $url ]);
        }
    }
    public function return() {
        $this->form = [
            'ubigeo_id' => null,
        ];
        $this->photo = '';
        $this->emit('closeModals');
        $this->emit('notify', 'success', 'Se registró correctamente 😃.');
    }
}

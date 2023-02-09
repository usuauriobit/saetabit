<?php

namespace App\Http\Livewire\Intranet\Configuracion\User;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $nro_pagination = 10;
    public $user = null;
    public $personals = [];
    public $roles = [];
    public $form = [];
	// public $ubigeos;
    protected function get_rules(){
        if($this->user){
            return [
                'form.personal_id' => 'required',
                'form.email' => 'required|unique:users,email,'.$this->user->id,
                // 'form.roles.*.id' => 'required',
            ];
        }
        return [
            'form.personal_id' => 'required',
			'form.email' => 'required|unique:users,email',
			'form.password' => 'required|string|confirmed|min:4',
            // 'form.roles.*' => 'required',
        ];
    }

    public function mount(){
		$this->personals = \App\Models\Personal::get();
		$this->roles = Role::get();
    }

    public function render()
    {
		$search = '%'.$this->search .'%';
        return view('livewire.intranet.configuracion.user.index', [
            'items' => User::latest()
            ->when(strlen($this->search) > 2, function($q) use ($search){
				return $q->searchFilter($search);
            })
            ->paginate($this->nro_pagination),
        ]);
    }
    public function create(){
        $this->form = [];
        $this->user = null;
    }
    public function show(User $user){
        $this->user = $user;
    }
    public function edit(User $user){
        $this->user = $user;
        $this->form = $user->toArray();
        $roles = [];
        // LO HAGO ASÍ PARA HACER MATCH CON LOS CHECKBOX DEL CREATE, PORQUE AHÍ GENERA CON INDEX COMO ROL->ID
        foreach ($user->roles as $rol)
            $roles[$rol->id] = $rol->id;
        $this->form['roles'] = $roles;
    }
    public function destroy(User $user){
        $user->delete();
        $this->emit('notify', 'success', 'Se eliminó correctamente 😃.');
    }
    public function save(){
        $this->user ? $this->update() : $this->store();
        $this->return();
    }
    public function store(){
        $form = $this->validate($this->get_rules());
        $this->user = User::create([
            'personal_id' => $form['form']['personal_id'],
            'email' => $form['form']['email'],
            'password' => Hash::make($form['form']['password']),
        ]);
        $this->setRoles();
    }
    public function update(){
        $form = $this->validate($this->get_rules());
        $this->user->update([
            'personal_id' => $form['form']['personal_id'],
            'email' => $form['form']['email'],
        ]);
        $this->setRoles();
    }
    public function return() {
        $this->form = [];
        $this->emit('closeModals');
        $this->emit('notify', 'success', 'Se registró correctamente 😃.');
    }
    public function setRoles(){
        // dd($this->form['roles']);
        if(isset($this->form['roles']))
            $this->user->syncRoles($this->form['roles'] ?? []);
    }
}

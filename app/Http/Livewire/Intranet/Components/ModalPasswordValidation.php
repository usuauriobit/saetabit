<?php

namespace App\Http\Livewire\Intranet\Components;

use App\Services\UserPasswordService;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ModalPasswordValidation extends Component
{
    public $modalName = 'modalPasswordValidation';
    public $eventName = 'passwordConfirmed';
    public $eventId = null;
    public $userId = null;
    public $password_validation_req = '';
    public $observacion = '';
    public $withObservacion = false;
    public $permission = null;
    public $isModal = true;
    public $componentDeclared = 'master.modal';
    public $hasCancelBtn = true;
    public $shouldCloseModal = true;
    public function mount(){
        $this->componentDeclared = $this->isModal ? 'master.modal' : 'master.section';
    }
    public function render() {
        return view('livewire.intranet.components.modal-password-validation');
    }
    public function confirm(){
        $data = $this->validate([
            'password_validation_req' => 'required',
            'observacion' => $this->withObservacion ? 'required' : 'nullable'
        ]);

        if($this->permission){
            $user_approved = UserPasswordService::getUserByPassword($data['password_validation_req']);
            if(!$user_approved){
                $this->emit('notify', 'error', 'Contraseña incorrecta.');
                return;
            }
            if(!$user_approved->can($this->permission)){
                $this->emit('notify', 'error', 'No tiene permisos para realizar esta acción.');
                return;
            }
            $this->userId = $user_approved->id;
        }else{
            if(!Hash::check($this->password_validation_req, auth()->user()->password)){
                $this->emit('notify', 'error', 'La constraseña es incorrecta, inténtelo de nuevo');
                return;
            }
            $this->userId = auth()->user()->id;
        }
        $this->emit($this->eventName, $this->eventId, $this->observacion, $this->userId);
        if($this->shouldCloseModal)
            $this->emit('closeModals');

    }
}

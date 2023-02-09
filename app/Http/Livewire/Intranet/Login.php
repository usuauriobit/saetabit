<?php

namespace App\Http\Livewire\Intranet;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $email;
    public $password;
    protected $rules = [
        'email'     => 'required|max:255|email',
        'password'  => 'required',
    ];
    public function booted(){
        if(Auth::check()){
            if(Auth::user()->is_personal){
                return redirect()->route('intranet.index');
            }else{
                return redirect()->route('landing_page.index');
            }
        }
    }
    public function render(){
        return view('livewire.intranet.login');
    }
    public function login(){
        $this->validate();
        $user = User::where('email', $this->email)->first();
        if($user && $user->is_personal){
            Auth::attempt(['email' => $this->email, 'password' => $this->password]);
            return redirect()->route('intranet.index');
        }else{
            $this->emit('notify', 'error', 'Credenciales incorrectas, vuelva a intentarlo');
        }
    }
}

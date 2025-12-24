<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Login extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function login()
    {
        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            session()->regenerate();
            
            $user = Auth::user();
            if ($user->isAdmin()) {
                return redirect()->route('dashboard');
            } else {
                // Rediriger vers la liste de ses bureaux
                return redirect()->route('mes-bureaux');
            }
        }

        $this->addError('email', 'Les identifiants sont incorrects.');
    }

    public function render()
    {
        return view('livewire.login');
    }
}

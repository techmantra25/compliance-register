<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AdminLogin extends Component
{
    public $email;
    public $password;
    public $remember = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];
    public function login()
    {
        $this->validate();

        $credentials = ['email' => $this->email, 'password' => $this->password];
        if (Auth::guard('admin')->attempt($credentials, $this->remember)) {
            session()->regenerate();
            $this->dispatch('toastr:success', message: 'Login successful! Welcome back 👋');
            return redirect()->intended('/admin/dashboard');
        }

        $this->addError('email', 'These credentials do not match our records.');
    }

    public function render()
    {
       return view('livewire.admin-login')->layout('layouts.app');
    }
}

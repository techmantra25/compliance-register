<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class ForgetPassword extends Component
{
    public $email;
    public $password;
    public $password_confirmation;

    public function forgetPassword(){
        $this->validate([
            'email' => 'required|email|exists:admins,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $admin = Admin::where('email', $this->email)->first();
        if($admin){
            $admin->password = Hash::make($this->password);
            $admin->save();
            session()->flash('success', 'Password reset successfully. You can now login with your new password.');
            return redirect()->route('login');
        }
    }
    public function render()
    {
        return view('livewire.forget-password')->layout('layouts.app');
    }
}

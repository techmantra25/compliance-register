<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePassword extends Component
{
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    protected $rules = [
        'current_password' => 'required',
        'new_password' => 'required|min:6|confirmed',
    ];

    public function changePassword()
    {
        $this->validate();

        $user = Auth::user();

        if (!Hash::check($this->current_password, $user->password)) {

            $this->addError('current_password', 'Current password is incorrect.');
            return;
        }

        $user->update([
            'password' => Hash::make($this->new_password)
        ]);

        session()->flash('success', 'Password updated successfully.');

        $this->reset([
            'current_password',
            'new_password',
            'new_password_confirmation'
        ]);
    }

    public function render()
    {
        return view('livewire.change-password')->layout('layouts.admin');
    }
}

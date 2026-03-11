<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetOtpMail;

class ForgetPassword extends Component
{
    public $email;
    public $otp;
    public $generatedOtp;
    public $password;
    public $password_confirmation;

    public $step = 1;

    public function sendOtp()
    {
        $this->validate([
            'email' => 'required|email|exists:admins,email'
        ]);

        $this->generatedOtp = rand(100000,999999);

        session()->put('reset_otp', $this->generatedOtp);
        session()->put('reset_email', $this->email);

        Mail::to($this->email)->send(
            new ResetOtpMail($this->generatedOtp,$this->email)
        );

        $this->step = 2;

        $this->dispatch('toastr:success', message: 'OTP sent to your email.');
    }

    public function verifyOtp()
    {
        if ($this->otp == session('reset_otp')) {
            $this->step = 3;
        } else {
            $this->addError('otp', 'Invalid OTP');
        }
    }

    public function resetPassword()
    {
        $this->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        $admin = Admin::where('email', session('reset_email'))->first();

        $admin->password = Hash::make($this->password);
        $admin->save();

        session()->forget(['reset_otp','reset_email']);

        session()->flash('success','Password reset successfully.');

        return redirect()->route('login');
    }

    // public function forgetPassword(){
    //     $this->validate([
    //         'email' => 'required|email|exists:admins,email',
    //         'password' => 'required|min:6|confirmed',
    //     ]);

    //     $admin = Admin::where('email', $this->email)->first();
    //     if($admin){
    //         $admin->password = Hash::make($this->password);
    //         $admin->save();
    //         session()->flash('success', 'Password reset successfully. You can now login with your new password.');
    //         return redirect()->route('login');
    //     }
    // }
    public function render()
    {
        return view('livewire.forget-password')->layout('layouts.app');
    }
}

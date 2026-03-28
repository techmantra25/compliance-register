<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\LoginLog;
use Illuminate\Support\Facades\Request;

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

        $admin = Admin::where('email', $this->email)->first();

        if ($admin && $admin->suspended_status == 0 && $admin->id !== 1) {

            LoginLog::create([
                'admin_id'   => $admin->id ?? null,
                'email'      => $this->email,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'login_at'   => now(),
                'is_success' => false,
            ]);

            $this->addError('email', 'Your account has been suspended. Please contact admin.');
            return;
        }

        $credentials = ['email' => $this->email, 'password' => $this->password];
        if (Auth::guard('admin')->attempt($credentials, $this->remember)) {
            session()->regenerate();

             LoginLog::create([
                'admin_id'   => Auth::guard('admin')->id(),
                'email'      => $this->email,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'login_at'   => now(),
                'is_success' => true,
            ]);

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

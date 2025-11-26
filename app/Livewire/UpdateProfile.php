<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Zone;
use App\Models\District;

class UpdateProfile extends Component
{
    public $name, $mobile, $email, $role, $zone_id;
    public $zoneList;

    public function mount(){
        $admin = Auth::user();
        
        $this->name  = $admin->name;
        $this->email = $admin->email;
        $this->mobile = $admin->mobile;
        $this->zone_id = $admin->zone_id;
        $this->role = $admin->role;
    }

    
    public function updateProfile()
    {
        $this->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:users,email,' . Auth::id(),
            'mobile' => 'nullable|string|max:20',
            'zone_id'  => 'nullable',
            'role'   => 'required|string',
        ]);

        $admin = Auth::user();

        $admin->update([
            'name'   => $this->name,
            'email'  => $this->email,
            'mobile' => $this->mobile,
            'zone_id'  => $this->zone_id,
            'role'   => $this->role,
        ]);

        session()->flash('success', 'Profile updated successfully!');
    }


    public function render()
    {
        $this->zoneList = Zone::select('id', 'name')->orderBy('name')->get();
        return view('livewire.update-profile')->layout('layouts.admin');
    }
}

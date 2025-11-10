<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Admin;
use App\Models\Zone;
use App\Models\District;
use Illuminate\Support\Facades\Hash;

class EmployeeCrud extends Component
{
    public $name, $email, $mobile, $role, $password, $admin_id,$zone_id;
    public $isEdit = false;
    public $search = '';
    public $zones;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:admins,email',
        'mobile' => 'nullable|string|max:20',
        'role' => 'required|string',
        'zone_id'   => 'required|exists:zones,id',
        'password' => 'required|min:6',
    ];
    public function resetInputFields()
    {
        $this->reset(['name', 'email', 'mobile', 'role', 'password','zone_id']);
        $this->admin_id = null;
        $this->isEdit = false;
         $this->dispatch('ResetForm');
    }

    public function save()
    {
        if ($this->isEdit) {
            $this->updateEmployee();
        } else {
            $this->storeEmployee();
        }
    }

    protected function storeEmployee()
    {
        $this->validate();

        Admin::create([
            'name' => $this->name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'role' => $this->role,
            'password' => Hash::make($this->password),
        ]);

        $this->dispatch('toastr:success', message: 'Employee added successfully!');
        $this->resetInputFields();
    }

    public function filterEmployees($searchTerm)
    {
        $this->search = $searchTerm;
    }
    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        $this->admin_id = $id;
        $this->name = $admin->name;
        $this->email = $admin->email;
        $this->mobile = $admin->mobile;
        $this->role = $admin->role;
        $this->zone_id = $admin->zone_id;
        $this->password = '';
        $this->isEdit = true;
    }

    protected function updateEmployee()
    {
        $rules = $this->rules;
        $rules['email'] = 'required|email|unique:admins,email,' . $this->admin_id;
        if (!$this->password) unset($rules['password']);

        $this->validate($rules);

        $admin = Admin::findOrFail($this->admin_id);
        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'zone_id' => $this->zone_id,
            'role' => $this->role,
        ];
        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        $admin->update($data);

        $this->dispatch('toastr:success', message: 'Employee updated successfully!');
        $this->resetInputFields();
    }
    public function confirmDelete($id)
    {
        $this->dispatch('showConfirm', ['itemId' => $id]);
    }
    public function delete($id)
    {
        Admin::findOrFail($id)->delete();
        $this->dispatch('toastr:success', message: 'Employee deleted successfully!');
    }

    public function render()
    {
         $this->zones = Zone::all()->map(function ($zone) {
            $districtIds = explode(',', $zone->districts);
            $zone->district_list = District::whereIn('id', $districtIds)->pluck('name_en')->toArray();
            return $zone;
        });
        $admins = Admin::query()
            ->when($this->search, function($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('email', 'like', '%'.$this->search.'%')
                    ->orWhere('role', 'like', '%'.$this->search.'%');
            })
            ->orderBy('name', 'ASC')
            ->get();

        return view('livewire.employee-crud', [
            'admins' => $admins,
        ])->layout('layouts.admin');
    }
}

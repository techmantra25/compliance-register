<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Admin;
use App\Models\Zone;
use App\Models\District;
use App\Models\ChangeLog;
use Illuminate\Support\Facades\Request;
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
        $this->reset(['name', 'email', 'mobile', 'role', 'password','zone_id','search']);
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
        // dd($this->all());
        $this->validate();

       $employee = Admin::create([
            'name' => $this->name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'role' => $this->role,
            'zone_id' => $this->zone_id,
            'password' => Hash::make($this->password),
            'suspended_status' => 1,
        ]);

        ChangeLog::create([
            'module_name'  => 'create_employee',
            'action'       => 'create',
            'old_data'     => $employee->toArray(),
            'new_data'     => $employee->toArray(),
            'changed_by'   => auth('admin')->id(), 
            'ip_address'   => Request::ip(),
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
        $oldData = $admin->toArray();
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

        ChangeLog::create([
            'module_name'  => 'update_employee',
            'action'       => 'update',
            'old_data'     => $oldData,
            'new_data'     => $admin->toArray(),
            'changed_by'   => auth('admin')->id(),
            'ip_address'   => Request::ip(),
        ]);

        $this->dispatch('toastr:success', message: 'Employee updated successfully!');
        $this->resetInputFields();
    }
    public function confirmDelete($id)
    {
        $this->dispatch('showConfirm', ['itemId' => $id]);
    }

    public function toggleStatus($id)
    {
        $admin = Admin::find($id);

        if ($admin) {
            $admin->suspended_status = $admin->suspended_status == 1 ? 0 : 1;
            $admin->save();

            $message = $admin->suspended_status 
                ? "{$admin->name} is now Active." 
                : "{$admin->name} has been Suspended.";

            $this->dispatch('toastr:success', message: $message);
        }
    }

    public function delete($id)
    {
        $admin = Admin::findOrFail($id);
        $oldData = $admin->toArray();
        $admin->delete();

        ChangeLog::create([
            'module_name' => 'delete_employee',
            'action' => 'delete',
            'old_data' => $oldData,
            'new_data' => $oldData,
            'changed_by' => auth('admin')->id(),
            'ip_address' => Request::ip(),
            
        ]);
        
        $this->dispatch('toastr:success', message: 'Employee deleted successfully!');
    }


    public function render()
    {
        $this->zones = Zone::all()->map(function ($zone) {
            $districtIds = explode(',', $zone->districts);
            $zone->district_list = District::whereIn('id', $districtIds)->pluck('name_en')->toArray();
            return $zone;
        })
        ->sortBy('name')            
        ->values();

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

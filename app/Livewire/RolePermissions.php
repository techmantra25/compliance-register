<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;

class RolePermissions extends Component
{
    public $admin;
    public $modules;
    public $selectedPermissions = [];
    public $assignedPermissions = [];

    public function mount($id){
        $this->admin = Admin::findOrFail($id);

        $this->modules = DB::table('parent_modules')
            ->get();
        $this->assignedPermissions = DB::table('admin_permissions')
            ->where('admin_id', $id)
            ->pluck('permission_id')
            ->toArray();
    }

    public function togglePermission($admin_id, $permission_id)
    {
        $exists = DB::table('admin_permissions')
                    ->where('admin_id', $admin_id)
                    ->where('permission_id', $permission_id)
                    ->exists();

        if ($exists) {
            DB::table('admin_permissions')
                ->where('admin_id', $admin_id)
                ->where('permission_id', $permission_id)
                ->delete();
            $this->dispatch('toastr:success', message: 'Permission Removed successfully!');
        } else {
            DB::table('admin_permissions')->insert([
                'admin_id' => $admin_id,
                'permission_id' => $permission_id,
            ]);
            $this->dispatch('toastr:success', message: 'Permission Assigned successfully!');
        }

        // Refresh list so checkbox stays checked after update
        $this->assignedPermissions = DB::table('admin_permissions')
                                    ->where('admin_id', $admin_id)
                                    ->pluck('permission_id')
                                    ->toArray();
    }


    public function render()
    {
        return view('livewire.role-permissions')->layout('layouts.admin');
    }
}

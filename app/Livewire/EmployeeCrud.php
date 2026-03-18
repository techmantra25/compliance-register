<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Admin;
use App\Models\Assembly;
use App\Models\District;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmployeeLoginMail;

class EmployeeCrud extends Component
{
    public $name,$email,$mobile,$role,$admin_id;

    public $assemblies = [];
    public $districts = [];

    public $allAssemblies;
    public $allDistricts;

    public $search='';
    public $isEdit=false;
    public $uncheckedAssembly =[];

    protected $rules = [
        'name' => 'required',
        'email' => 'required|email|unique:admins,email',
        'role' => 'required',
    ];

    public function mount()
    {
        $this->allAssemblies = Assembly::with('district')
        ->orderBy('district_id')
        ->get();

        $this->allDistricts = District::orderBy('name_en')->get();
    }

    protected function validateAssemblies($ignoreId = null)
    {
        // assemblies required only for employee
        if ($this->role === 'employee') {

            if (empty($this->assemblies)) {
                $this->addError('assemblies', 'At least one assembly is required.');
                return false;
            }

            // foreach ($this->assemblies as $assemblyId) {

            //     $employee = Admin::where('role', 'employee')
            //         ->where(function ($q) use ($assemblyId) {

            //             $q->where('assemblies', $assemblyId)
            //             ->orWhere('assemblies', 'like', "$assemblyId,%")
            //             ->orWhere('assemblies', 'like', "%,$assemblyId")
            //             ->orWhere('assemblies', 'like', "%,$assemblyId,%");

            //         })
            //         ->when($ignoreId, function ($q) use ($ignoreId) {
            //             $q->where('id', '!=', $ignoreId);
            //         })
            //         ->first();   // <-- get employee instead of exists()

            //     if ($employee) {

            //         // get assembly name
            //         $assemblyName = \App\Models\Assembly::where('id', $assemblyId)
            //             ->value('assembly_name_en');

            //         $this->addError(
            //             'assemblies',
            //             "Assembly '{$assemblyName}' is already assigned to employee '{$employee->name}'."
            //         );

            //         return false;
            //     }
            // }
        }

        return true;
    }

    public function DistrictUpdate($value)
    {
        $districtIds = is_array($value) ? $value : [$value];

        if (count($districtIds)) {

            $this->allAssemblies = Assembly::whereIn('district_id', $districtIds)
                ->orderBy('district_id')
                ->get();

            // Get all IDs
            $allIds = $this->allAssemblies->pluck('id')->toArray();

            // Remove unchecked IDs
            $this->assemblies = array_values(array_diff($allIds, $this->uncheckedAssembly));

        } else {

            $this->allAssemblies = Assembly::orderBy('district_id')->get();

            $this->assemblies = [];
            $this->uncheckedAssembly = [];
        }

        $this->dispatch('AssignAssembly', ['itemId' => $this->assemblies]);
    }
    public function handleAssemblyChange($assemblyId, $isChecked)
    {
        if (!$isChecked) {
            //  Add to unchecked array (if not already exists)
            if (!in_array($assemblyId, $this->uncheckedAssembly)) {
                $this->uncheckedAssembly[] = $assemblyId;
            }
        } else {
            //  Remove from unchecked array if checked again
            $this->uncheckedAssembly = array_values(
                array_diff($this->uncheckedAssembly, [$assemblyId])
            );
        }
    }

    public function resetInputFields()
    {
        $this->reset([
            'name','email','mobile','role','assemblies','districts','search'
        ]);

        $this->admin_id=null;
        $this->isEdit=false;

        $this->allAssemblies = Assembly::orderBy('district_id')->get();

        $this->dispatch('ResetForm');
    }

    public function save()
    {
        if($this->isEdit){
            $this->updateEmployee();
        }else{
            $this->storeEmployee();
        }
    }

    protected function storeEmployee()
    {
        $this->validate();

        if (!$this->validateAssemblies()) {
            return;
        }

        $password = random_int(111111, 999999);

        $admin = Admin::create([
            'name' => $this->name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'role' => $this->role,
            'assemblies' => implode(',', $this->assemblies),
            'password' => Hash::make($password),
            'suspended_status' => 1
        ]);

        if ($this->role == "legal_associate") {

            $permission_ids = DB::table('permissions')
                ->whereIn('slug', [
                    'view_dashboard',
                    'nomination_view_candidate',
                    'nomination_document_repository',
                    'nomination_document_preview'
                ])
                ->pluck('id')
                ->toArray();

            $data = [];

            foreach ($permission_ids as $permission_id) {
                $data[] = [
                    'admin_id' => $admin->id,
                    'permission_id' => $permission_id,
                ];
            }

            DB::table('admin_permissions')->insert($data);

        } elseif ($this->role == "employee") {

            $permission_ids = DB::table('permissions')
                ->whereIn('slug', [
                    'view_dashboard',
                    'nomination_view_candidate',
                    'nomination_add_candidate',
                    'nomination_import_candidate',
                    'nomination_export_candidate',
                    'nomination_update_candidate',
                    'nomination_assign_agents',
                    'nomination_candidate_journey_timeline',
                    'nomination_document_repository',
                    'nomination_document_preview'
                ])
                ->pluck('id')
                ->toArray();

            $data = [];

            foreach ($permission_ids as $permission_id) {
                $data[] = [
                    'admin_id' => $admin->id,
                    'permission_id' => $permission_id,
                ];
            }

            DB::table('admin_permissions')->insert($data);
        }
       

        // Send login credentials email
        Mail::to($admin->email)->send(new EmployeeLoginMail($admin, $password));

        $this->dispatch('toastr:success', message: 'Employee added successfully!');

        $this->resetInputFields();
    }

    public function edit($id)
    {
        $admin = Admin::findOrFail($id);

        $this->admin_id = $admin->id;
        $this->name = $admin->name;
        $this->email = $admin->email;
        $this->mobile = $admin->mobile;
        $this->role = $admin->role;

        $this->assemblies = $admin->assemblies
            ? array_map('intval', explode(',', $admin->assemblies))
            : [];

        $this->districts = Assembly::whereIn('id', $this->assemblies)
            ->pluck('district_id')
            ->unique()
            ->values()
            ->toArray();

        $this->allAssemblies = Assembly::whereIn('district_id', $this->districts)
            ->orderBy('district_id')
            ->get();

        $this->isEdit = true;

        $this->dispatch('refreshChosen');
    }

    protected function updateEmployee()
    {
        $rules = $this->rules;

        $rules['email'] = 'required|email|unique:admins,email,' . $this->admin_id;

        $this->validate($rules);

        if (!$this->validateAssemblies($this->admin_id)) {
            return;
        }

        $admin = Admin::findOrFail($this->admin_id);

        $admin->update([
            'name' => $this->name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'role' => $this->role,
            'assemblies' => implode(',', $this->assemblies)
        ]);

        $this->dispatch('toastr:success', message: 'Employee updated successfully!');

        $this->resetInputFields();
    }

    public function toggleStatus($id)
    {
        $admin = Admin::find($id);

        if($admin){

            $admin->suspended_status =
                $admin->suspended_status==1 ? 0 : 1;

            $admin->save();

            if($admin->suspended_status==0){
                DB::table('sessions')->where('user_id',$admin->id)->delete();
            }

            $msg = $admin->suspended_status
                ? "{$admin->name} Activated"
                : "{$admin->name} Suspended";

            $this->dispatch('toastr:success',message:$msg);
        }
    }

    public function render()
    {
        $admins = Admin::query()
            ->when($this->search,function($q){
                $q->where('name','like','%'.$this->search.'%')
                  ->orWhere('email','like','%'.$this->search.'%');
            })
            ->orderBy('name')
            ->get();

        return view('livewire.employee-crud',[
            'admins'=>$admins
        ])->layout('layouts.admin');
    }
}
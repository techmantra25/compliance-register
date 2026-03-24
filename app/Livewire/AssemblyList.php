<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Assembly;
use App\Models\Phase;
use App\Models\PhaseWiseAssembly;
use App\Models\District;
use App\Models\Admin;
use App\Models\Candidate;
use App\Mail\AssignmentNotification;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class AssemblyList extends Component
{
    use WithPagination;

    public $district_id, $selected_id;
    public $assembly_name_en;
    public $assembly_name_bn;
    public $assignedEmployee;
    public $assembly_id;
    public $employeeStats = [];

    protected $rules = [
        'assembly_name_en' => 'required|string|max:255',
        'assembly_name_bn' => 'required|string|max:255',
    ];
    public $search, $selectedAssembly;

    protected $paginationTheme = 'bootstrap';

    public function DistrictUpdate($value)
    {
        $this->district_id = $value;
        $this->resetPage();
    }

    public function filterData($value)
    {
        $this->search = $value;
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['district_id', 'search']);
        $this->dispatch('ResetForm');
    }
     public function editItem($assembly_id)
    {
        $assembly = Assembly::findOrFail($assembly_id);

        $this->selected_id = $assembly->id;
        $this->assembly_name_en = $assembly->assembly_name_en;
        $this->assembly_name_bn = $assembly->assembly_name_bn;

        $this->dispatch('openUpdateModel', [
            'assembly_name_en' => $this->assembly_name_en,
            'assembly_name_bn' => $this->assembly_name_bn
        ]);
    }
    public function loadEmployeeStats()
    {
        foreach (Admin::where('role','employee')->get() as $emp) {
            $this->employeeStats[$emp->id] = $this->getEmployeeStats($emp->id);
        }
    }

    public function assignEmployees($assemblyId)
    {
        $this->assembly_id = $assemblyId;
        $this->loadEmployeeStats();

        $assigned = Admin::whereNotNull('assemblies')
            ->get()
            ->first(function ($admin) use ($assemblyId) {
                return in_array($assemblyId, explode(',', $admin->assemblies));
            });

        $this->assignedEmployee = $assigned ? $assigned->id : null;

        $this->dispatch('openAssignModal');
        $this->dispatch('ResetForm');
        $this->dispatch('refreshChosen');
    }

    public function getAssignedEmployee($assemblyId)
    {
        return Admin::where('role', 'employee')
            ->whereNotNull('assemblies')
            ->get()
            ->first(function ($emp) use ($assemblyId) {
                return in_array($assemblyId, explode(',', $emp->assemblies));
            });
    }

    public function getEmployeeStats($employeeId)
    {
        $emp = Admin::find($employeeId);

        if (!$emp || !$emp->assemblies) {
            return ['completed' => 0, 'pending' => 0];
        }

        $assemblyIds = explode(',', $emp->assemblies);

        $assemblies = Assembly::with('candidates')
            ->whereIn('id', $assemblyIds)
            ->get();

        $candidates = $assemblies->flatMap(fn($a) => $a->candidates);

        $completed = $candidates
            ->where('document_collection_status', 'verified_pending_submission')
            ->count();

        $pending = $candidates
            ->whereIn('document_collection_status', [
                'not_received_form',
                'rejected',
                'incomplete_additional_required',
                'ready_for_vetting'
            ])
            ->count();

        return [
            'completed' => $completed,
            'pending' => $pending,
        ];
    }

   public function saveAssignments()
    {
        //  Step 0: Validation
        if (empty($this->assembly_id)) {
            $this->dispatch('assignment-error', message: 'Please select an assembly first');
            return;
        }

        if (empty($this->assignedEmployee)) {
            $this->dispatch('assignment-error', message: 'Please select an employee');
            return;
        }

        //  Step 1: Remove this assembly from all employees
        $allEmployees = Admin::where('role', 'employee')->get();

        foreach ($allEmployees as $emp) {
            $assemblies = array_filter(explode(',', $emp->assemblies ?? ''));

            // Remove current assembly_id
            $assemblies = array_diff($assemblies, [$this->assembly_id]);

            $emp->assemblies = !empty($assemblies) ? implode(',', $assemblies) : null;
            $emp->save();
        }

        //  Step 2: Assign selected employee
        $emp = Admin::find($this->assignedEmployee);

        if (!$emp) {
            $this->dispatch('assignment-error', message: 'Employee not found');
            return;
        }

        $assemblies = array_filter(explode(',', $emp->assemblies ?? ''));

        if (!in_array($this->assembly_id, $assemblies)) {
            $assemblies[] = $this->assembly_id;
        }

        $emp->assemblies = implode(',', $assemblies);
        $emp->save();

        //  Step 3: Get Candidate using Assembly
        $candidate = Candidate::where('assembly_id', $this->assembly_id)->first();

        //  Step 4: Send Mail to Employee
        $mailSent = false;

        if ($candidate && !empty($emp->email)) {

            $data = [
                'candidate' => $candidate,

                'ac' => optional($candidate->assembly)->assembly_code . ' | ' .
                    optional($candidate->assembly)->assembly_name_en .
                    ' (' . optional($candidate->assembly)->assembly_name_bn . ')',

                'nominationDate' => optional(optional(optional($candidate->assembly)->assemblyPhase)->phase)->last_date_of_nomination
                    ? Carbon::parse(optional(optional(optional($candidate->assembly)->assemblyPhase)->phase)->last_date_of_nomination)->format('d M Y')
                    : 'N/A',

                'electionDate' => optional(optional(optional($candidate->assembly)->assemblyPhase)->phase)->date_of_election
                    ? Carbon::parse(optional(optional(optional($candidate->assembly)->assemblyPhase)->phase)->date_of_election)->format('d M Y')
                    : 'N/A',

                'link' => route('admin.candidates.contacts'),
            ];

            try {
                //  IMPORTANT: Sending to EMPLOYEE
                Mail::to($emp->email)->send(new AssignmentNotification($data));

                $mailSent = true;

            } catch (\Exception $e) {
                $mailSent = false;
            }
        }

        //  Step 5: Close Modal
        $this->dispatch('closeAssignModal');
        
        //  Step 6: Final Alert
        if ($mailSent) {
            $this->dispatch('assignment-success', message: 'Assignment saved & email sent to employee');
        } else {
            $this->dispatch('assignment-warning', message: 'Assignment saved but email not sent');
        }
    }

    public function updateStatus()
    {
        $this->validate();

        $assembly = Assembly::findOrFail($this->selected_id);

        $assembly->update([
            'assembly_name_en' => $this->assembly_name_en,
            'assembly_name_bn' => $this->assembly_name_bn,
        ]);

        $this->dispatch('closeUpdateModel');
        $this->dispatch('toastr:success', message: 'Assembly Updated Successfully');

        $this->resetFormData();
    }

    public function resetFormData()
    {
        $this->selected_id = null;
        $this->assembly_name_en = '';
        $this->assembly_name_bn = '';
    }

    public function exportCsv()
    {
        $phases = Phase::with(['assemblies.district'])
            ->orderBy('id', 'ASC')
            ->get();

        $filename = "assemblies_phase_wise.csv";

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate",
            "Expires" => "0"
        ];

        $columns = ['Phase', 'District', 'AC Code', 'AC Name'];

        $callback = function () use ($phases, $columns) {

            $file = fopen('php://output', 'w');

            // CSV Header
            fputcsv($file, $columns);

            foreach ($phases as $phase) {

                foreach ($phase->assemblies->sortBy('assembly_number') as $assembly) {

                    $district = optional($assembly->district)->name_en ?? '';

                    fputcsv($file, [
                        $phase->name,
                        $district,
                        $assembly->assembly_number,
                        $assembly->assembly_name_en
                    ]);
                }

            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
    public function render()
    {
        $assemblies = Assembly::with(['district', 'candidates'])
            ->when($this->search, fn($q) =>
                $q->where('assembly_name_en', 'like', "%{$this->search}%")
                  ->orWhere('assembly_name_bn', 'like', "%{$this->search}%")
                  ->orWhere('assembly_number', 'like', "%{$this->search}%"))
            ->when($this->district_id, fn($q) =>
                $q->where('district_id', $this->district_id))
            ->orderBy('assembly_number')
            ->paginate(20);

        $districts = District::orderBy('name_en')->get();
        $employees = Admin::where('role', 'employee')
        ->where('suspended_status', 1)
        ->get();

        return view('livewire.assembly-list', [
            'assemblies' => $assemblies,
            'districts'  => $districts,
            'employees'  => $employees,
        ])->layout('layouts.admin');
    }
}

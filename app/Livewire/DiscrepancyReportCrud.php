<?php

namespace App\Livewire;

use App\Models\DiscrepancyReport;
use App\Models\Assembly;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;

class DiscrepancyReportCrud extends Component
{
    use WithPagination,WithFileUploads;

    public $unique_id, $assembly_id, $social_media, $source_url, $report, $report_type = 'Approved', $user_id,$screenshot,$existing_screenshot,$selected_assembly_id;
    public $assemblies = [];
    public $editMode = false;
    public $editId;
    public $search = '';

    protected $paginationTheme = 'bootstrap';

    // 🧭 Mount method loads Assemblies
    public function mount()
    {
        $this->assemblies = Assembly::orderBy('assembly_name_en')->get();
    }

    public function changeStatus($value){
        $this->report_type = $value;
    }
    public function changeSocialMedia($value){
        $this->social_media = $value;
    }
    // 🧹 Reset pagination on search
    public function filterReport($value)
    {
        $this->search =$value; 
        $this->resetPage();
    }
    public function resetFormfield(){
        $this->resetPage();
        $this->resetForm();
        $this->dispatch('ResetFormData');
        
    }
    // 🆕 Prepare modal for new report
    public function newReport()
    {
        $this->resetForm();
        $this->editMode = false;
    }

    // 💾 Create new record
    public function save()
    {
        $this->validate([
            'assembly_id'   => 'required|exists:assemblies,id',
            'social_media'  => 'required|string|max:255',
            'report'        => 'required|string',
            'report_type'   => 'required|in:Mismatched,Approved',
            'screenshot' => 'nullable|image|max:2048', // 2MB limit
        ]);

        $screenshot = null;
        if ($this->screenshot) {
            $screenshot = 'storage/'.$this->screenshot->store('screenshots', 'public');
        }
        DiscrepancyReport::create([
            'unique_id'     => 'DR-' . strtoupper(Str::random(8)),
            'assembly_id'   => $this->assembly_id,
            'social_media'  => $this->social_media,
            'report'        => $this->report,
            'report_type'   => $this->report_type,
            'source_url'   => $this->source_url,
            'screenshot'   => $screenshot,
            'user_id'       => Auth::guard('admin')->user()->id,
        ]);

        session()->flash('success', 'Social media report added successfully!');
        return redirect()->route('admin.candidates.discrepancies.report');

    }

    // ✏️ Edit existing record
    public function edit($id)
    {
        $report = DiscrepancyReport::findOrFail($id);

        $this->editId = $report->id;
        $this->editMode = true;
        $this->unique_id = $report->unique_id;
        $this->assembly_id = $report->assembly_id;
        $this->social_media = $report->social_media;
        $this->report = $report->report;
        $this->report_type = $report->report_type;
        $this->existing_screenshot = $report->screenshot; // ✅ keep current path for preview
        $this->source_url = $report->source_url;
    }

    // 🔄 Update record
    public function update()
    {
        $this->validate([
            'assembly_id'   => 'required|exists:assemblies,id',
            'social_media'  => 'required|string|max:255',
            'report'        => 'required|string',
            'report_type'   => 'required|in:Mismatched,Approved',
        ]);

        $report = DiscrepancyReport::findOrFail($this->editId);
        if ($this->screenshot) {
            // Store new image
            $screenshotPath = 'storage/'.$this->screenshot->store('screenshots', 'public');
        } else {
            $screenshotPath = $report->screenshot; // keep old
        }
        $report->update([
            'assembly_id'   => $this->assembly_id,
            'social_media'  => $this->social_media,
            'report'        => $this->report,
            'report_type'   => $this->report_type,
            'source_url'   => $this->source_url,
            'screenshot'    => $screenshotPath,
        ]);

        session()->flash('success', 'Social media report updated successfully!');
        return redirect()->route('admin.candidates.discrepancies.report');
    }

    // ❌ Delete record
    public function delete($id)
    {
        $report = DiscrepancyReport::findOrFail($id);
        $report->delete();

        session()->flash('message', 'Discrepancy report deleted successfully!');
    }

    // 🔁 Reset all form fields
    public function resetForm()
    {
        $this->reset(['unique_id', 'assembly_id', 'social_media', 'report', 'report_type', 'editMode', 'editId','source_url','screenshot', 'search','selected_assembly_id','existing_screenshot']);
    }

    // 🔍 Render with search and pagination
    public function render()
    {
        $reports = DiscrepancyReport::with(['assembly.district'])
            ->when($this->search, function ($query) {
                $query->where('unique_id', 'like', "%{$this->search}%")
                    ->orWhere('social_media', 'like', "%{$this->search}%")
                    ->orWhere('report', 'like', "%{$this->search}%")
                    ->orWhere('report_type', 'like', "%{$this->search}%")
                    ->orWhereHas('assembly', function ($q) {
                        $q->where('assembly_name_en', 'like', "%{$this->search}%")
                          ->orWhere('assembly_code', 'like', "%{$this->search}%")
                          ->orWhereHas('district', function ($d) {
                              $d->where('name_en', 'like', "%{$this->search}%");
                          });
                    });
            })->when($this->selected_assembly_id, function ($query){
                $query->where('assembly_id', 'like', "%{$this->selected_assembly_id}%");
            })
            ->latest()
            ->paginate(10);

        return view('livewire.discrepancy-report-crud', [
            'reports' => $reports,
            'assemblies' => $this->assemblies,
        ])->layout('layouts.admin');
    }
}

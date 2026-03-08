<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Mcc;
use App\Models\MccRemarks;
use Illuminate\Support\Facades\Auth;

class MccViolationCrudRemarks extends Component
{
    use WithFileUploads;

    public $mcc;
    public $userRole;
    public $remark;
    public $attachment;

    protected $rules = [
        'remark' => 'required|min:3',
        'attachment' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,bmp,svg,pdf|max:4096'
    ];

    public function mount($id)
    {
        $this->mcc = Mcc::findOrFail($id);
    }

    public function saveRemark()
    {
        $this->validate();

        $filePath = null;

        if ($this->attachment) {

            $file = $this->attachment;

            $timestamp = now()->format('Ymd_His');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();

            $filename = "{$originalName}_{$timestamp}.{$extension}";

            $filePath = $file->storeAs(
                "mcc_docs/{$this->mcc->id}",
                $filename,
                'public'
            );
        }
        MccRemarks::create([
            'mcc_id' => $this->mcc->id,
            'remarks' => $this->remark,
            'attachment' => 'storage/'.$filePath,
            'legal_associate_id' => auth()->guard('admin')->id(),
            'is_read' => 0
        ]);

        $this->reset(['remark','attachment']);
        $this->dispatch('ResetForm');
        $this->dispatch('toastr:success', message: 'Remark added successfully!');
    }
    public function addCancel($id){
        $this->dispatch('showConfirm', ['itemId' => $id]);
    }

    public function CancelRemarks($id){
        $mccRemarks = MccRemarks::find($id);
        $mccRemarks->is_cancelled = 1;
        $mccRemarks->save();
        $this->dispatch('toastr:success', message: 'The remark has been cancelled successfully');
    }

    public function render()
    {
        $this->userRole = trim(strtolower(Auth::guard('admin')->user()->role));
        if ($this->userRole == 'legal_associate' && Auth::guard('admin')->user()    ->id != $this->mcc->action_taken) {
            abort(403, 'You are not authorized to access this MCC case.');
        }
        if ($this->userRole == 'admin') {
            MccRemarks::where('mcc_id', $this->mcc->id)
                ->update([
                    'is_read' => 1,
                ]);
        }
        $remarks = MccRemarks::where('mcc_id', $this->mcc->id)
            ->latest()
            ->get();

        return view('livewire.mcc-violation-crud-remarks', compact('remarks'))
            ->layout('layouts.admin');
    }
}
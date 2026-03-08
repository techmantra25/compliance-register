<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\WarRoom;
use App\Models\WarRoomRemarks;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class WarRoomCrudRemarks extends Component
{
    use WithFileUploads;

    public $war;
    public $userRole;
    public $remark;
    public $attachment;

    protected $rules = [
        'remark' => 'required|min:3',
        'attachment' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,bmp,svg,pdf|max:4096'
    ];

    public function mount($id)
    {
        $this->war = WarRoom::findOrFail($id);
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
            $filePath = $file->storeAs("warroom_docs/{$this->war->id}", $filename, 'public');
        }

        WarRoomRemarks::create([
            'war_id' => $this->war->id,
            'remarks' => $this->remark,
            'attachment' => $filePath ? 'storage/'.$filePath : null,
            'legal_associate_id' => auth()->guard('admin')->id(),
            'is_read' => 0,
        ]);

        $this->reset(['remark','attachment']);
        $this->dispatch('ResetForm');
        $this->dispatch('toastr:success', message: 'Remark added successfully!');
    }

    public function addCancel($id)
    {
        $this->dispatch('showConfirm', ['itemId' => $id]);
    }

    public function CancelRemarks($id)
    {
        $remark = WarRoomRemarks::findOrFail($id);
        $remark->update(['is_cancelled' => 1]);
        $this->dispatch('toastr:success', message: 'Remark cancelled successfully!');
    }

    public function render()
    {
        $this->userRole = trim(strtolower(Auth::guard('admin')->user()->role));

        // Mark all as read for admins
        if ($this->userRole == 'admin') {
            WarRoomRemarks::where('war_id', $this->war->id)->update(['is_read' => 1]);
        }

        $remarks = WarRoomRemarks::where('war_id', $this->war->id)->latest()->get();

        return view('livewire.war-room-crud-remarks', compact('remarks'))->layout('layouts.admin');
    }
}
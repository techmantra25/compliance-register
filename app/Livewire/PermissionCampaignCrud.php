<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\{Campaign, EventRequiredPermission,CampaignWisePermission};
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class PermissionCampaignCrud extends Component
{
    use WithFileUploads;
    public $camp;
    public $requiredPermissions = [];
    public $event_required_permission_id, $campaign_id, $file, $remarks;

    public function mount($campaign_id)
    {
        $this->camp = Campaign::with(['campaigner','assembly.assemblyPhase.phase','category'])
                        ->findOrFail($campaign_id);

        $this->requiredPermissions = EventRequiredPermission::where('category_id', $this->camp->event_category_id)
                        ->orderBy('id')
                        ->get();
    }

    public function openModal($permissionId, $campaignId){
        $this->event_required_permission_id = $permissionId;
        $this->campaign_id = $campaignId;
        $this->reset(['file', 'remarks']);
        $this->dispatch('open-document-modal');
    }

    public function resetForm()
    {
        $this->reset(['file', 'remarks', 'campaign_id', 'event_required_permission_id']);
    }

    public function save()
    {
        $this->validate([
            'file' => 'required|mimes:pdf,doc,docx,jpg,jpeg,png,gif,bmp,webp|max:5120',
            'remarks' => 'nullable|string|max:255',
        ]);

  
        $timestamp = now()->format('Ymd_His');
        $originalName = pathinfo($this->file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $this->file->getClientOriginalExtension();
        $filename = "{$originalName}_{$timestamp}.{$extension}";

        $path = $this->file->storeAs("campaign_permission_docs/{$this->campaign_id}", $filename, 'public');

        CampaignWisePermission::updateOrCreate(
            [
                'campaign_id' => $this->campaign_id,
                'event_required_permission_id' => $this->event_required_permission_id,
            ],
            [
                'status' => 'pending',
                'remarks' => $this->remarks,
                'applied_copy' => $path,
                'uploaded_by' => auth('admin')->id(),
                'uploaded_at' => now(),
            ]
        );

        $this->reset(['file', 'remarks']);

        $this->dispatch('close-document-modal');

        $this->dispatch('toastr:success', message: "Document uploaded successfully");
    }

    public function render()
    {
        return view('livewire.permission-campaign-crud', [
            'camp' => $this->camp,
            'requiredPermissions' => $this->requiredPermissions,
        ])->layout('layouts.admin');
    }

}

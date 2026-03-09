<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\{Campaign, EventRequiredPermission,CampaignWisePermission};
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class PermissionCampaignCrud extends Component
{
    use WithFileUploads;
    public $camp, $AuthUser;
    public $rejectId, $rejectRemarks;
    public $requiredPermissions = [];
    public $event_required_permission_id, $campaign_id, $file, $remarks, $doc_type;

    public function mount($campaign_id)
    {
        $this->camp = Campaign::with(['campaigners','assembly.assemblyPhase.phase','category'])
                        ->findOrFail($campaign_id);

        $this->requiredPermissions = EventRequiredPermission::where('category_id', $this->camp->event_category_id)
                        ->orderBy('id')
                        ->get();
        $this->AuthUser = Auth::guard('admin')->user();
    }

    public function uploadApplied($permissionId, $campaignId){
        $this->event_required_permission_id = $permissionId;
        $this->campaign_id = $campaignId;
        $this->doc_type = 'applied_copy';
        $this->reset(['file', 'remarks']);
        $this->dispatch('open-document-modal');
    }
    public function uploadApproved($permissionId, $campaignId){
        $this->event_required_permission_id = $permissionId;
        $this->campaign_id = $campaignId;
        $this->doc_type = 'approved_copy';
        $this->reset(['file', 'remarks']);
        $this->dispatch('open-document-modal');
    }
  
    public function resetForm()
    {
        $this->reset(['file', 'remarks', 'campaign_id', 'event_required_permission_id', 'doc_type']);
    }

    public function markAsSkipped($permissionId){

        $create = new CampaignWisePermission();
        $create->campaign_id = $this->campaign_id;
        $create->event_required_permission_id = $permissionId;
        $create->status = 'skip'; // always approved since no legal associate flow
        $create->doc_type = "applied_copy";
        $create->uploaded_by = auth('admin')->id();
        $create->uploaded_at = now();
        $create->save();

        $insert = new CampaignWisePermission();
        $insert->campaign_id = $this->campaign_id;
        $insert->event_required_permission_id = $permissionId;
        $insert->status = 'skip'; // always approved since no legal associate flow
        $insert->doc_type = "approved_copy";
        $insert->uploaded_by = auth('admin')->id();
        $insert->uploaded_at = now();
        $insert->save();

        $this->dispatch('toastr:success', message: "Document updated successfully");
    }

    public function revokeSkip($permissionId){
       CampaignWisePermission::where('campaign_id', $this->campaign_id)
        ->where('status', 'skip')
        ->where('event_required_permission_id', $permissionId)
        ->delete();
    }
    public function save()
    {
        $this->validate([
            'file' => 'required|mimes:pdf,doc,docx,jpg,jpeg,png,gif,bmp,webp|max:5120',
            'remarks' => 'nullable|string|max:255',
        ]);

        // Auto Reject previous version of SAME doc_type for SAME permission + campaign
        $previous = CampaignWisePermission::where('campaign_id', $this->campaign_id)
            ->where('event_required_permission_id', $this->event_required_permission_id)
            ->where('doc_type', $this->doc_type)
            ->orderBy('id', 'desc')
            ->first();

        if ($previous && in_array($previous->status, ['pending', 'approved'])) {
            $previous->status = 'rejected';
            $previous->rejected_reason = 'Auto-Rejected due to new upload';
            $previous->approved_by = auth('admin')->id();
            $previous->approved_at = now();
            $previous->save();
        }

        // File Upload
        $timestamp = now()->format('Ymd_His');
        $originalName = pathinfo($this->file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $this->file->getClientOriginalExtension();
        $filename = "{$originalName}_{$timestamp}.{$extension}";

        $path = $this->file->storeAs(
            "campaign_permission_docs/{$this->campaign_id}",
            $filename,
            'public'
        );

        // Create new upload record
        $create = new CampaignWisePermission();
        $create->campaign_id = $this->campaign_id;
        $create->event_required_permission_id = $this->event_required_permission_id;
        $create->status = 'approved'; // always approved since no legal associate flow
        $create->remarks = $this->remarks;
        $create->file = "storage/{$path}";
        $create->doc_type = $this->doc_type;
        $create->uploaded_by = auth('admin')->id();
        $create->uploaded_at = now();
        $create->save();

        $this->reset(['file', 'remarks', 'doc_type']);

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

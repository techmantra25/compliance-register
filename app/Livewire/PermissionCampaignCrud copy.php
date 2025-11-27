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
        $this->camp = Campaign::with(['campaigner','assembly.assemblyPhase.phase','category'])
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
    public function openRejectModal($id)
    {
        $this->rejectId = $id;
        $this->rejectRemarks = '';
        $this->dispatch('open_reject_modal'); // JS/modal trigger
    }

    public function resetForm()
    {
        $this->reset(['file', 'remarks', 'campaign_id', 'event_required_permission_id', 'doc_type']);
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

        $create = new CampaignWisePermission();
        $create->campaign_id = $this->campaign_id;
        $create->event_required_permission_id = $this->event_required_permission_id;
        $create->status = 'pending';
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
    public function approveDocument($id)
    {
        $doc = CampaignWisePermission::find($id);
        $doc->status = 'approved';
        $doc->approved_by = auth('admin')->id();
        $doc->approved_at = now();
        $doc->save();

        $this->dispatch('toastr:success', message: "Document approved successfully");
    }
    public function submitRejection()
    {
        $doc = CampaignWisePermission::find($this->rejectId);
        $doc->status = 'rejected';
        $doc->rejected_reason = $this->rejectRemarks;
        $doc->approved_by = auth('admin')->id();
        $doc->approved_at = now();
        $doc->save();

        $this->dispatch('close_reject_modal');
        $this->dispatch('toastr:success', message: "Document rejected successfully");
    }


    public function render()
    {
        return view('livewire.permission-campaign-crud', [
            'camp' => $this->camp,
            'requiredPermissions' => $this->requiredPermissions,
        ])->layout('layouts.admin');
    }

}

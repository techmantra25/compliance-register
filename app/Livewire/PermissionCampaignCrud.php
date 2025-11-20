<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\{Campaign, EventRequiredPermission};
use Livewire\WithPagination;

class PermissionCampaignCrud extends Component
{
    public $camp;
    public $requiredPermissions = [];

    public function mount($campaign_id)
    {
        $this->camp = Campaign::with(['campaigner','assembly.assemblyPhase.phase','category'])
                        ->findOrFail($campaign_id);

        $this->requiredPermissions = EventRequiredPermission::where('category_id', $this->camp->event_category_id)
                        ->orderBy('id')
                        ->get();
    }

    public function render()
    {
        return view('livewire.permission-campaign-crud', [
            'camp' => $this->camp,
            'requiredPermissions' => $this->requiredPermissions,
        ])->layout('layouts.admin');
    }
}

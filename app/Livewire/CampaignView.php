<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Campaign;

class CampaignView extends Component
{
    public $camp;

    public function mount($id)
    {
        $this->camp = Campaign::with([
            'campaigners',
            'assembly',
            'assembly.assemblyPhase.phase',
            'category',
            'documents'
        ])->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.campaign-view')
            ->layout('layouts.admin');
    }
}
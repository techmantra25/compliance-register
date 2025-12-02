<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\District;
use App\Models\Assembly;
use App\Models\Phase;
use App\Models\Zone;
use App\Models\EventCategory;
use App\Models\Candidate;
use App\Models\Campaign;
use App\Models\CampaignWisePermission;


class AdminDashboard extends Component
{
    public $phases;
    public $chartData = [];
    public $totalScheduled;
    public $pending;
    public $appliedAwaitingApproval;
    public $approvedCopyReceived;

    
    // public function mount()
    // {
    //     $this->phases = Phase::with([
    //         'assemblies',
    //         'assemblies.candidates'
    //     ])->get()->toArray();

       
    //     // foreach($this->phases as $key =>$item){
    //     //      dd($item);
    //     // }
    // }

    public function mount()
    {
        $this->phases = Phase::with([
            'assemblies',
            'assemblies.candidates'
        ])->get();

        $this->totalScheduled = Campaign::count();
        $this->pending = Campaign::where('status', 'pending')->count();
        $this->appliedAwaitingApproval = CampaignWisePermission::where('doc_type','applied_copy')->whereNull('approved_by')->count();
        $this->approvedCopyReceived = CampaignWisePermission::where('doc_type','approved_copy')->whereNotNull('approved_by')->count();

        $this->chartData = [];

        foreach ($this->phases as $key => $phase) {
            $allCandidates = $phase->assemblies
                ->flatMap(fn($assembly) => $assembly->candidates);

                
            $getSpecialCaseCan = $allCandidates
                ->filter(fn($c) => (int) $c->is_special_case === 1)
                ->pluck('id')
                ->toArray();

            //dd($getSpecialCaseCan);

            $pending_at_fox = $allCandidates
                ->where('document_collection_status', 'ready_for_vetting')
                ->count();

            $pending_submission = $allCandidates
                ->where('document_collection_status', 'verified_pending_submission')
                ->count();

            $approved_complete = $allCandidates
                ->where('document_collection_status', 'verified_submitted_with_copy')
                ->count();
            
           
            $rejected = $allCandidates
                ->where('document_collection_status', 'rejected')
                ->reject(fn($c) => in_array($c->id, $getSpecialCaseCan))
                ->count();

            $this->chartData[$key] = [
                'phase_name' => $phase->name,
                'data' => [
                    $pending_at_fox,
                    $pending_submission,
                    $approved_complete,
                    $rejected
                ]
            ];

            
            

        }
    }


    public function render()
    {
        return view('livewire.admin-dashboard')
            ->layout('layouts.admin'); 
    }
}

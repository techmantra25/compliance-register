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
    public $cancelledOrRescheduled;

    public function mount()
    {
       
        $this->totalScheduled = Campaign::count();
        $campaigns = Campaign::with(['category.permissions', 'permissions'])->get();

        $pending = 0;
        $appliedAwaitingApproval = 0;
        $approvedCopyReceived = 0;
        $cancelledOrRescheduled = 0;

        foreach ($campaigns as $camp) {
            $required = $camp->category->permissions->count(); 
            $applied = $camp->permissions->where('doc_type', 'applied_copy')->count();
            $approved = $camp->permissions->where('doc_type', 'approved_copy')->count();

            if (in_array($camp->status, ['cancelled', 'rescheduled'])) {
                $cancelledOrRescheduled++;
                continue;
            }

            if ($approved == $required && $required > 0) {
                $approvedCopyReceived++;
            }
            else if ($applied == $required && $required > 0) {
                $appliedAwaitingApproval++;
            }
            else {
                $pending++;
            }
        }

        $this->pending = $pending;
        $this->appliedAwaitingApproval = $appliedAwaitingApproval;
        $this->approvedCopyReceived = $approvedCopyReceived;
        $this->cancelledOrRescheduled = $cancelledOrRescheduled;

        $this->phases = Phase::with([
            'assemblies',
            'assemblies.candidates'
        ])->get();

        $this->chartData = [];

        foreach ($this->phases as $key => $phase) {
            $allCandidates = $phase->assemblies
                ->flatMap(fn($assembly) => $assembly->candidates);

                
            $getSpecialCaseCan = $allCandidates
                ->filter(fn($c) => (int) $c->is_special_case === 1)
                ->pluck('id')
                ->toArray();

            //dd($getSpecialCaseCan);

            $vetting_in_progress_at_fox = $allCandidates
                ->whereIn('document_collection_status',['ready_for_vetting','vetting_in_progress'])
                ->count();

            $pending_acknowledgement_copy = $allCandidates
                ->where('document_collection_status', 'verified_pending_submission')
                ->count();

            $document_yettobe_received_by_fox_for_vetting = $allCandidates
                ->whereIn('document_collection_status',['incomplete_additional_required','not_received_form'])
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
                    $approved_complete,
                    $document_yettobe_received_by_fox_for_vetting,
                    $vetting_in_progress_at_fox,
                    $pending_acknowledgement_copy,
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

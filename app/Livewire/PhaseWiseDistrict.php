<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\District;
use App\Models\Assembly;
use App\Models\Phase;
use App\Models\Zone;
use App\Models\Campaign;

class PhaseWiseDistrict extends Component
{
    
    public $districtChart = [];
    public $uniqueDistricts = [];
    public $uniqueEventDistricts = [];
    public $campaignChart = [];
    public $phaseName;

    public function mount($phaseId)
    {
        $this->selectedPhase = $phaseId;

        $phase = Phase::with([
            'assemblies',
            'assemblies.candidates'
        ])->findOrFail($phaseId);

        $this->phaseName = $phase->name;

        $districtGroups = $phase->assemblies
            ->groupBy(fn($asm) => $asm->district->name_en ?? 'Unknown');

        $districtStats = [];
        $campaignStats = [];

        foreach ($districtGroups as $districtName => $assemblies) {

            $candidates = $assemblies->flatMap(fn($asm) => $asm->candidates);

            $specialCases = $candidates->where('is_special_case', 1)->pluck('id')->toArray();

            $vetting_in_progress_at_fox = $candidates->whereIn('document_collection_status',['ready_for_vetting','vetting_in_progress'])->count();
            $pending_acknowledgement_copy = $candidates->where('document_collection_status', 'verified_pending_submission')->count();
            $document_yet_to_be_received_by_fox_for_vetting = $candidates
                ->whereIn('document_collection_status',['incomplete_additional_required','not_received_form'])
                ->count();
            $approved_complete = $candidates->where('document_collection_status', 'verified_submitted_with_copy')->count();

            $rejected = $candidates
                ->where('document_collection_status', 'rejected')
                ->reject(fn($c) => in_array($c->id, $specialCases))
                ->count();

            $total = max($vetting_in_progress_at_fox + $pending_acknowledgement_copy + $approved_complete +  $document_yet_to_be_received_by_fox_for_vetting + $rejected, 1);

            $districtStats[] = [
                'district' => $districtName,
                'approved' => $approved_complete,
                'vetting_in_progress_at_fox' => $vetting_in_progress_at_fox,
                'document_yet_to_be_received_for_vetting' => $document_yet_to_be_received_by_fox_for_vetting,
                'pending_acknowledgement_copy' => $pending_acknowledgement_copy,
                'rejected' => $rejected,
                'percent' => [
                    'approved' => round(($approved_complete / $total) * 100),
                    'vetting_in_progress_at_fox' => round(($vetting_in_progress_at_fox / $total) * 100),
                    'document_yet_to_be_received_by_fox_for_vetting' => round(($document_yet_to_be_received_by_fox_for_vetting / $total) * 100),
                    'pending_acknowledgement_copy' => round(($pending_acknowledgement_copy / $total) * 100),
                    'rejected' => round(($rejected / $total) * 100)
                ]
            ];

            $assemblyIds = $assemblies->pluck('id');

            $campaigns = Campaign::whereIn('assembly_id', $assemblyIds)
                ->with(['category.permissions', 'permissions', 'assembly.district'])
                ->get();

            $totalCampaigns = $campaigns->count();

            if ($totalCampaigns > 0) {
                $pending = 0;
                $appliedAwaiting = 0;
                $approved = 0;

                foreach ($campaigns as $campaign) {

                    $required = $campaign->category->permissions->count();
                    $submitted = $campaign->permissions;

                    $appliedCount = $submitted->whereNotNull('file')->count();
                    $approvedCopyCount = $submitted->where('status', 'approved')->whereNotNull('approved_copy')->count();

                    if ($appliedCount < $required) {
                        $pending++;
                    } elseif ($appliedCount == $required && $approvedCopyCount < $required) {
                        $appliedAwaiting++;
                    } else {
                        $approved++;
                    }
                }

                $campaignStats[] = [
                    'district' => $districtName,
                    'total_campaigns' => $totalCampaigns,
                    'pending_applications' => $pending,
                    'applied_awaiting' => $appliedAwaiting,
                    'approved_received' => $approved,
                ];
            }
        }
        $this->districtChart = $districtStats;
        $this->campaignChart = $campaignStats;
    }

    public function render()
    {
        return view('livewire.phase-wise-district')->layout('layouts.admin');
    }
}

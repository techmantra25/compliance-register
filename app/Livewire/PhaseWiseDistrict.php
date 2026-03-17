<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Phase;

class PhaseWiseDistrict extends Component
{
    public $districtChart = [];
    public $phaseName;

    public function mount($phaseId)
    {
        $phase = Phase::with([
            'assemblies.district',
            'assemblies.candidates'
        ])->findOrFail($phaseId);

        $this->phaseName = $phase->name;

        $districtGroups = $phase->assemblies
            ->groupBy(fn($asm) => $asm->district->name_en ?? 'Unknown');

        $districtStats = [];

        foreach ($districtGroups as $districtName => $assemblies) {

            $candidates = $assemblies->flatMap(fn($asm) => $asm->candidates);

            // ===== TABLE COUNTS =====
            $submittedChecked = $candidates
                ->where('document_collection_status', 'verified_pending_submission')
                ->count();

            $notSubmitted = $candidates
                ->whereIn('document_collection_status', ['not_received_form', 'rejected'])
                ->count();

            $incomplete = $candidates
                ->whereIn('document_collection_status', ['incomplete_additional_required', 'ready_for_vetting'])
                ->count();

            // ===== BAR CHART COUNTS =====
            $approved = $submittedChecked;

            $document_yet = $candidates
                ->where('document_collection_status', 'not_received_form')
                ->count();

            $vetting = $candidates
                ->where('document_collection_status', 'ready_for_vetting')
                ->count();

            $pending = $candidates
                ->where('document_collection_status', 'incomplete_additional_required')
                ->count();

            $rejected = $candidates
                ->where('document_collection_status', 'rejected')
                ->count();

            $total = max($approved + $document_yet + $vetting + $pending + $rejected, 1);

            $districtStats[] = [
                'district' => $districtName,
                'total_assembly' => $assemblies->count(),

                // table
                'submitted_checked' => $submittedChecked,
                'not_submitted' => $notSubmitted,
                'incomplete' => $incomplete,

                // bar chart
                'approved' => $approved,
                'document_yet_to_be_received_for_vetting' => $document_yet,
                'vetting_in_progress_at_fox' => $vetting,
                'pending_acknowledgement_copy' => $pending,
                'rejected' => $rejected,

                'percent' => [
                    'approved' => round(($approved / $total) * 100),
                    'document_yet_to_be_received_by_fox_for_vetting' => round(($document_yet / $total) * 100),
                    'vetting_in_progress_at_fox' => round(($vetting / $total) * 100),
                    'pending_acknowledgement_copy' => round(($pending / $total) * 100),
                    'rejected' => round(($rejected / $total) * 100),
                ]
            ];
        }

        $this->districtChart = collect($districtStats)
            ->sortBy('district')
            ->values()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.phase-wise-district')->layout('layouts.admin');
    }
}
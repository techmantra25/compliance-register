<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\District;
use App\Models\Assembly;
use App\Models\Phase;
use App\Models\Zone;

class PhaseWiseDistrict extends Component
{
    
    public $districtChart = [];
    public $uniqueDistricts = [];

    public function mount(){
        $this->phases = Phase::with([
            'assemblies',
            'assemblies.candidates'
        ])->get();

        $this->chartData = [];

        foreach ($this->phases as $key => $phase) {
            
            $districtGroups = $phase->assemblies
                ->groupBy(fn($asm) => $asm->district->name_en ?? 'Unknown');
            
            $districtStats = [];
            foreach ($districtGroups as $districtName => $assemblies) {
                $candidates = $assemblies->flatMap(fn($asm) => $asm->candidates);
                $specialCases = $candidates
                                    ->where('is_special_case', 1)
                                    ->pluck('id')
                                    ->toArray();
                 $pending_at_fox = $candidates->where('document_collection_status', 'ready_for_vetting')->count();

                $pending_submission = $candidates->where('document_collection_status', 'verified_pending_submission')->count();

                $approved_complete = $candidates->where('document_collection_status',     'verified_submitted_with_copy')->count();
                $rejected = $candidates->where('document_collection_status', 'rejected')
                                        ->reject(fn($c) => in_array($c->id, $specialCases))
                                        ->count();

                $total = $pending_at_fox + $pending_submission + $approved_complete + $rejected;
                $total = max($total, 1);

                $districtStats[] = [
                    'district' => $districtName,
                    'approved' => $approved_complete,
                    'pending_at_fox' => $pending_at_fox,
                    'pending_submission' => $pending_submission,
                    'rejected' => $rejected,
                    'percent' => [
                        'approved' => round(($approved_complete / $total) * 100),
                        'pending_at_fox' => round(($pending_at_fox / $total) * 100),
                        'pending_submission' => round(($pending_submission / $total) * 100),
                        'rejected' => round(($rejected / $total) * 100)
                    ]
                ];
            }
            $this->districtChart[$key] = $districtStats;

        }
        $this->uniqueDistricts = collect($this->districtChart)
                ->flatten(1)
                ->unique('district')
                ->values()
                ->toArray();
    }
    public function render()
    {
        return view('livewire.phase-wise-district')->layout('layouts.admin');
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Phase;
use App\Models\Assembly;
use App\Models\Mcc;

class PhaseWiseMcc extends Component
{
    public $phaseId;
    public $phase;
    public $districtChart = [];  
    public $phaseName = '';

    public function mount($phaseId)
    {
        $this->phaseId = $phaseId;

        $this->phase = Phase::with([
            'assemblies.district',
            'assemblies.mcc'
        ])->findOrFail($phaseId);

        $this->phaseName = $this->phase->name;

        $this->districtChart = $this->prepareDistrictSummary();
    }

    private function prepareDistrictSummary()
    {
        $summary = [];

        foreach ($this->phase->assemblies as $asm) {

            if (!$asm->district) {
                continue;
            }

            $districtName = $asm->district->name_en;

            if (!isset($summary[$districtName])) {
                $summary[$districtName] = [
                    'district'  => $districtName,
                    'pending'   => 0,
                    'processed' => 0,
                    'resolved'  => 0,
                    'total'     => 0,
                ];
            }

            foreach ($asm->mcc as $mcc) {

                $summary[$districtName]['total']++;

                if ($mcc->status == 'pending_to_process') {
                    $summary[$districtName]['pending']++;
                }
                elseif ($mcc->status == 'processed') {
                    $summary[$districtName]['processed']++;
                }
                elseif ($mcc->status == 'confirm_resolved') {
                    $summary[$districtName]['resolved']++;
                }
            }
        }
        foreach ($summary as $district => &$row) {
            $total = max($row['total'], 1); 

            $row['percent'] = [
                'pending'   => round(($row['pending'] / $total) * 100),
                'processed' => round(($row['processed'] / $total) * 100),
                'resolved'  => round(($row['resolved'] / $total) * 100),
            ];
        }

        return array_values($summary);
    }

    public function render()
    {
        return view('livewire.phase-wise-mcc')
            ->layout('layouts.admin');
    }
}

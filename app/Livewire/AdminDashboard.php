<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Phase;
use Illuminate\Support\Facades\Auth;

class AdminDashboard extends Component
{
    public $phases;
    public $chartData = [];
    public $authUser;

    public $phaseArray = [];
    public $overall = [];
    public $tableData = [];

    public function mount()
    {
        $this->authUser = Auth::guard('admin')->user();

        // =========================
        // CHART DATA
        // =========================
        $this->phases = Phase::with([
            'assemblies.candidates'
        ])->get();

        foreach ($this->phases as $key => $phase) {

            $allCandidates = $phase->assemblies
                ->flatMap(fn($assembly) => $assembly->candidates);

            $getSpecialCaseCan = $allCandidates
                ->filter(fn($c) => (int) $c->is_special_case === 1)
                ->pluck('id')
                ->toArray();

            $this->chartData[$key] = [
                'phase_name' => $phase->name,
                'data' => [
                    $allCandidates->whereIn('document_collection_status', ['not_received_form', 'rejected'])->count(),
                    $allCandidates->whereIn('document_collection_status',['incomplete_additional_required', 'ready_for_vetting'])->count(),
                    $allCandidates->whereIn('document_collection_status', ['verified_pending_submission'])->count(),
                ]
            ];
        }

        // =========================
        // PHASE SUMMARY
        // =========================
        $this->phaseArray = Phase::with(['phaseAssemblies.assembly.candidates'])
            ->orderBy('name', 'ASC')
            ->get()
            ->map(function ($phase) {

                $assemblies = $phase->phaseAssemblies;

                $candidates = $assemblies
                    ->flatMap(fn($item) => $item->assembly?->candidates ?? collect());

                return [
                    'name' => $phase->name,
                    'assembly' => $assemblies->count(),
                    'total_records' => $assemblies->count(),

                    'pending_records' => $candidates
                        ->whereIn('document_collection_status', ['not_received_form', 'rejected'])
                        ->count(),

                    'inappropriate_records' => $candidates
                        ->whereIn('document_collection_status', ['incomplete_additional_required', 'ready_for_vetting'])
                        ->count(),

                    'completed_records' => $candidates
                        ->whereIn('document_collection_status', ['verified_pending_submission'])
                        ->count(),
                ];
            })
            ->toArray();

        // =========================
        // OVERALL SUMMARY
        // =========================
        $this->overall = [
            'total' => collect($this->phaseArray)->sum('total_records'),
            'pending' => collect($this->phaseArray)->sum('pending_records'),
            'inappropriate' => collect($this->phaseArray)->sum('inappropriate_records'),
            'completed' => collect($this->phaseArray)->sum('completed_records'),
        ];

        // =========================
        // TABLE DATA
        // =========================
        $phases = Phase::with([
            'phaseAssemblies.assembly.district',
            'phaseAssemblies.assembly.candidates'
        ])->get();

        foreach ($phases as $phase) {

            $sortedAssemblies = $phase->phaseAssemblies
                ->sortBy(fn($item) => (int) ($item->assembly->assembly_number ?? 0));

            foreach ($sortedAssemblies as $phaseAssembly) {

                $assembly = $phaseAssembly->assembly;

                if (!$assembly) continue;

                foreach ($assembly->candidates as $candidate) {

                    if (in_array($candidate->document_collection_status, ['not_received_form', 'rejected'])) {
                        $status = 'Not Submitted';
                    } elseif (in_array($candidate->document_collection_status, ['incomplete_additional_required', 'ready_for_vetting'])) {
                        $status = 'Incomplete';
                    } elseif ($candidate->document_collection_status == 'verified_pending_submission') {
                        $status = 'Submitted & Checked';
                    } else {
                        $status = 'Unknown';
                    }

                    $this->tableData[] = [
                        'phase' => $phase->name,
                        'district' => $assembly->district->name_en ?? '',
                        'assembly_no' => $assembly->assembly_number,
                        'assembly_name' => $assembly->assembly_name_en,
                        'candidate' => $candidate->name,
                        'status' => $status
                    ];
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.admin-dashboard')
            ->layout('layouts.admin');
    }
}
<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Phase;
use App\Models\Campaign;

class EventWiseDistrict extends Component
{
    public $districtChart = [];
    public $uniqueDistricts = [];
    public $uniqueEventDistricts = [];
    public $campaignChart = [];


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
            $campaignStats = [];
            
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

                //  Campaign Permission Analytics
                $assemblyIds = $assemblies->pluck('id');

                // Get all campaigns in this district's assemblies
                $campaigns = Campaign::whereIn('assembly_id', $assemblyIds)
                    ->with(['category.permissions', 'permissions','assembly.district'])
                    ->get();
                
                // Process ALL campaigns for this district (regardless of event)
                $totalCampaigns = $campaigns->count();
                
                if ($totalCampaigns > 0) {
                    $pendingCount = 0;
                    $appliedAwaitingCount = 0;
                    $approvedCount = 0;
                    $cancelledOrRescheduled = 0;
                    $districtNameActual = $districtName;
                    $eventCategoryIds = [];
                    
                    foreach ($campaigns as $campaign) {
                        $districtNameActual = $campaign->assembly->district->name_en ?? $districtName;
                        $eventCategoryIds[] = $campaign->event_category_id;
                        
                        // Get required permissions for this campaign's category
                        $requiredPermissions = $campaign->category->permissions ?? collect([]);
                        $totalRequired = $requiredPermissions->count();
                        
                        if ($totalRequired == 0) {
                            continue;
                        }
                         if (in_array($campaign->status, ['cancelled', 'rescheduled'])) {
                            $cancelledOrRescheduled++;
                            continue;
                        }
                        
                        $submittedPermissions = $campaign->permissions;
                        
                        // Count how many have applied_copy submitted
                        $appliedCount = $submittedPermissions
                            ->where('doc_type', 'applied_copy')
                            ->whereNotNull('file')
                            ->count();
                        
                        // Count how many have approved_copy submitted (fully approved with file)
                        $approvedCopyCount = $submittedPermissions
                            ->where('doc_type', 'approved_copy')
                            ->whereNotNull('file')
                            ->count();
                        
                       // CASE 1: All approved → 100% Green
                        if ($approvedCopyCount == $totalRequired) {
                            $approvedCount++;
                        }
                        // CASE 2: All applied but NOT all approved → 100% Grey
                        elseif ($appliedCount == $totalRequired) {
                            $appliedAwaitingCount++;
                        }
                        // CASE 3: Anything missing → 100% Yellow
                        else {
                            $pendingCount++;
                        }

                    }
                    
                    // Get unique event IDs for display
                    $uniqueEvents = array_unique($eventCategoryIds);
                    
                    // Calculate percentages for this district (all events combined)
                    $campaignStats[] = [
                        'district' => $districtNameActual,
                        'total_campaigns' => $totalCampaigns,
                        'pending_applications' => $pendingCount,
                        'applied_awaiting' => $appliedAwaitingCount,
                        'approved_received' => $approvedCount,
                       'percent' => [
                                'cancelled' => round(($cancelledOrRescheduled / $totalCampaigns) * 100, 1),
                                'pending' => round(($pendingCount / $totalCampaigns) * 100, 1),
                                'applied_awaiting' => round(($appliedAwaitingCount / $totalCampaigns) * 100, 1),
                                'approved' => round(($approvedCount / $totalCampaigns) * 100, 1)
                            ]

                    ];
                }
            }
            
            $this->districtChart[$key] = $districtStats;
            $this->campaignChart[$key] = $campaignStats;
        }

        $this->uniqueDistricts = collect($this->districtChart)
                ->flatten(1)
                ->unique('district')
                ->values()
                ->toArray();

        $this->uniqueEventDistricts = collect($this->campaignChart)
                ->flatten(1)
                ->values()
                ->toArray();
    }

    public function render()
    {
        return view('livewire.event-wise-district')->layout('layouts.admin');
    }
}
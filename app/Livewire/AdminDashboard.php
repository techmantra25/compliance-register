<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\District;
use App\Models\Assembly;
use App\Models\Phase;
use App\Models\Zone;
use App\Models\EventCategory;
use App\Models\Candidate;

class AdminDashboard extends Component
{
    public $district = '';
    public $phase = '';
    public $assembly = '';
    public $campaignDistrict = '';
    public $campaignAssembly = '';
    public $campaignEventCategory = '';
    public $allDistricts = [];
    public $allPhases = [];
    public $allAssemblies = [];
    public $allEventCategories = [];
    public $nominationDocumentsReceived = 0;
    public $documentsPending = 0;
    public $underVetting = 10;
    public $vettedButNotSubmitted = 50;
    public $totalCampaigns = 150;
    public $pendingCampaigns = 140;
    public $approvedCampaigns = 10;
    public $phaseWiseAssemblies = [];

    public $zoneWiseAssemblies = [];
    public function mount(){
        $this->allDistricts = District::where('is_active', 1)->orderBy('name_en')->get();
        $this->allAssemblies = Assembly::where('status', 'active')->orderBy('assembly_name_en', 'asc')->get();
        $this->allPhases = Phase::orderBy('name', 'asc')->get();
        $this->allZones = Zone::orderBy('name', 'asc')->whereNot('name', 'All Zones')->get();
        $this->allEventCategories = EventCategory::orderBy('name', 'asc')->get();

        foreach($this->allPhases as $phase){
            $assemblyCount = $phase->assemblies()->where('status', 'active')->count();
            $this->phaseWiseAssemblies [] = [
                'phase_name' =>$phase->name,
                'assemblies' => $assemblyCount,
                'election_date' => $phase->date_of_election
            ];
        }
        foreach($this->allZones as $zone){
            $districtsInZone = explode(',', $zone->districts);
            $assemblyCount = Assembly::whereIn('district_id', $districtsInZone)
                ->where('status', 'active')
                ->count();
            $this->zoneWiseAssemblies [] = [
                'zone_name' => $zone->name,
                'assemblies' => $assemblyCount
            ];
        }

    }

    public function ChangeNominationField($key, $value){
        $this->$key = $value;
        if($key === 'district'){
            $this->assembly = '';
            $this->phase = '';
    
        } elseif($key === 'phase'){
            $this->district = '';
            $this->assembly = '';
        } elseif($key === 'assembly'){
            $this->district = '';
            $this->phase = '';
        }
    }
    public function NominationStatusField()
    {
        // Base query
        $baseQuery = Candidate::query();

        // Apply only ONE filter at a time
        if ($this->assembly) {

            $baseQuery->where('assembly_id', $this->assembly);

        } elseif ($this->phase) {

            $baseQuery->whereHas('assembly.assemblyPhase', function ($q) {
                $q->where('phase_id', $this->phase);
            });

        } elseif ($this->district) {

            $baseQuery->whereHas('assembly', function ($q) {
                $q->where('district_id', $this->district);
            });

        }

        // ------------------------------
        //   CLONE query for each status
        // ------------------------------

        // Documents received
        $this->nominationDocumentsReceived = (clone $baseQuery)
            ->where('document_collection_status', 'verified_submitted_with_copy')
            ->count();

        // Pending documents
        $this->documentsPending = (clone $baseQuery)
            ->where('document_collection_status', 'not_received_form')
            ->count();

        // Under Vetting
        $this->underVetting = (clone $baseQuery)
            ->where('document_collection_status', 'vetting_in_progress')
            ->count();

        // Vetted but not submitted
        $this->vettedButNotSubmitted = (clone $baseQuery)
            ->where('document_collection_status', 'verified_pending_submission')
            ->count();
    }

    public function render()
    {
        $this->NominationStatusField();
        return view('livewire.admin-dashboard')
            ->layout('layouts.admin'); // your admin layout
    }
}

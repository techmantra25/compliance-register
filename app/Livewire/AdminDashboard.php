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

class AdminDashboard extends Component
{
    public $phases;

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

    
        foreach ($this->phases as $phase) {

            
            $allCandidates = $phase->assemblies
                ->flatMap(fn($assembly) => $assembly->candidates);

            $phase->verified_correct = $allCandidates->where('document_collection_status', 'Verified Correct but yet to be submitted')->count();

            $phase->incomplete_docs = $allCandidates->where('document_collection_status', 'Incomplete / Additional Documents Required')->count();

            $phase->verified_submitted = $allCandidates->where('document_collection_status', 'Verified and Submitted with Received Copy')->count();

            $phase->not_received = $allCandidates->where('document_collection_status', 'Have Not Received Form')->count();

            $phase->chartData = [
                $phase->verified_correct,
                $phase->incomplete_docs,
                $phase->verified_submitted,
                $phase->not_received
            ];
        }
    }

    

    public function render()
    {
        return view('livewire.admin-dashboard')
            ->layout('layouts.admin'); 
    }
}

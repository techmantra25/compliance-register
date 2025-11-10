<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Candidate;
use Illuminate\Http\Request;

class CandidateJourney extends Component
{
      public function mount(Request $request)
    {
        // Get the candidate ID from the route
        $candidateId = $request->query('candidate');
        
        // Fetch the candidate or abort if not found
        $candidate = Candidate::find($candidateId);
        if (!$candidate) {
            abort(404, 'Candidate not found.');
        }
    }
    public function render()
    {
        return view('livewire.candidate-journey')->layout('layouts.admin');
    }
}

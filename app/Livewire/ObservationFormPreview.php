<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Candidate;

class ObservationFormPreview extends Component
{
    public $candidate;
    public $candidateId;
    public $observation_description;

    public function mount($id)
    {
        $this->candidateId = $id;

        $this->candidate = Candidate::with('assembly')->findOrFail($id);

        $this->observation_description = $this->candidate->observation_description;
    }

    public function render()
    {
        return view('livewire.observation-form-preview')->layout('layouts.admin');
    }
}
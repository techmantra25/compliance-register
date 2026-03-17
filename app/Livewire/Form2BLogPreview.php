<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\NominationLog;
use App\Models\CandidateDocument;

class Form2BLogPreview extends Component
{
    public $nomination;
    public $profile_image;

    public function mount($logId)
    {
        $log = NominationLog::findOrFail($logId);
        // $this->nomination = (object) $data;
        $this->nomination = json_decode($log->form_data); // object

        $this->profile_image = CandidateDocument::where('candidate_id', $this->nomination->candidate_id)
            ->where('type', 'photo')
            ->whereNotNull('path')
            ->latest()
            ->first();
    }

    public function render()
    {
        return view('livewire.form2-b-log-preview')->layout('layouts.admin'); 
    }
}

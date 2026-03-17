<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CandidateDocument;
use App\Models\NominationLog;
use App\Models\NominationForm;

class NominationForm2BPreview extends Component
{
    public $nomination;
    public $profile_image;
    public $convicted_details = [];

    public function mount($id)
    {
        $this->nomination = NominationForm::findOrFail($id);
        $this->profile_image = CandidateDocument::where('candidate_id', $this->nomination->candidate_id)
        ->where('type', 'photo')
        ->whereNotNull('path')
        ->latest()
        ->first();

        $this->convicted_details = $this->nomination->convicted_details ?? [];
    }

    public function saveNominationData()
    {
        $data = $this->nomination->toArray();

        $data['candidate'] = $this->nomination->candidate;
        $data['assembly'] = $this->nomination->assembly;

        NominationLog::create([
            'nomination_id' => $this->nomination->id,
            'form_data' => json_encode($data),
            'generated_by' => auth()->id(),
            'ip_address' => request()->ip(),
        ]);

        $this->dispatch('printFromServer', logId: $this->nomination->id);
    }
    public function render()
    {
        return view('livewire.nomination-form2-b-preview')->layout('layouts.admin');
    }
}

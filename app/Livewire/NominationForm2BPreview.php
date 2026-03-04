<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\NominationForm;

class NominationForm2BPreview extends Component
{
    public $nomination;
    public $convicted_details = [];

    public function mount($id)
    {
        $this->nomination = NominationForm::findOrFail($id);

        $this->convicted_details = $this->nomination->convicted_details ?? [];
    }

    public function render()
    {
        return view('livewire.nomination-form2-b-preview')->layout('layouts.admin');
    }
}

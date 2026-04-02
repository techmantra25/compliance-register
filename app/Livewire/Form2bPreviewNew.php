<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Form2bDetail;
use App\Models\CandidateDocument;

class Form2bPreviewNew extends Component
{
    public $nomination;

    public function mount($id)
    {
        $this->nomination = Form2bDetail::findOrFail($id);
    }
    public function render()
    {
        return view('livewire.form2b-preview-new')->layout('layouts.admin'); 
    }
}

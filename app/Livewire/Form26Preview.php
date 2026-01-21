<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Candidate;
use App\Models\NominationForm;

class Form26Preview extends Component
{
    public $candidate;
    public $form;

    public $phones = [];
    public $social = [];
    public $panDetails = [];
    public $incomes = [];
    public $movableAssets = [];
    public $immovableAssets = [];
    public $loans = [];
    public $governmentDues = [];
    public $education = [];

    public function mount($id)
    {
        $this->form = NominationForm::where('id', $id)
            ->where('form_type', 'form_26')
            ->firstOrFail();

        $this->candidate = Candidate::findOrFail(
            $this->form->candidate_id
        );

        $this->phones = json_decode($this->form->contact_phone_nos, true) ?? [];
        $this->social = json_decode($this->form->social_media_accounts, true) ?? [];

        $this->panDetails = json_decode($this->form->pan_details, true) ?? [];
        $this->incomes = json_decode($this->form->last_five_year_incomes, true) ?? [];

        $this->movableAssets = json_decode($this->form->movable_assets, true) ?? [];
        $this->immovableAssets = json_decode($this->form->immovable_assets, true) ?? [];

        $loansAndDues = json_decode($this->form->loans_and_govt_dues, true) ?? [];
        $this->loans = $loansAndDues['loans'] ?? [];
        $this->governmentDues = $loansAndDues['government_dues'] ?? [];

        $this->education = json_decode(
            $this->form->highest_educational_qualification,
            true
        ) ?? [];
    }

    public function render()
    {
        return view('livewire.form_26_preview')
            ->layout('layouts.admin');
    }
}

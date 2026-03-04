<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Candidate;
use App\Models\NominationForm;
use App\Models\NominationLog;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

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
    public $source_of_incomes = [];
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

        $this->source_of_incomes = json_decode(
            $this->form->source_of_incomes,
            true
        ) ?? [];

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

    public function downloadPdf()
    {
        $form = $this->form->load('candidate', 'assembly');
        $candidate = $form->candidate;

        $panDetails       = json_decode($form->pan_details, true) ?? [];
        $incomes          = json_decode($form->last_five_year_incomes, true) ?? [];
        $movableAssets    = json_decode($form->movable_assets, true) ?? [];
        $immovableAssets  = json_decode($form->immovable_assets, true) ?? [];

        $loansAndDues     = json_decode($form->loans_and_govt_dues, true) ?? [];
        $loans            = $loansAndDues['loans'] ?? [];
        $governmentDues   = $loansAndDues['government_dues'] ?? [];

        $sourceOfIncomes  = json_decode($form->source_of_incomes, true) ?? [];
        $education        = json_decode($form->highest_educational_qualification, true) ?? [];

        $persons = [
            'self'       => 'Self',
            'spouse'     => 'Spouse',
            'dependents' => 'Dependents',
        ];

        $pdf = Pdf::loadView(
            'livewire.nomination.form-26-pdf',
            compact(
                'form',
                'candidate',
                'panDetails',
                'incomes',
                'movableAssets',
                'immovableAssets',
                'loans',
                'governmentDues',
                'sourceOfIncomes',
                'education',
                'persons'
            )
        );

        NominationLog::create([
            'nomination_id' => $form->id,
            'form_data'     => $form->toArray(),
            'pdf_file'      => $pdf->output(),
            'generated_by'  => Auth::id(),
            'ip_address'    => request()->ip(),
        ]);

        return response()->streamDownload(
            fn () => print($pdf->output()),
            'Nomination_Form_26_' . now()->format('Ymd_His') . '.pdf',
            ['Content-Type' => 'application/pdf']
        );
    }


}

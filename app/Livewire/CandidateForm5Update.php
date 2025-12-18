<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Candidate;
use App\Models\CandidateForm5;

class CandidateForm5Update extends Component
{
    public Candidate $candidate;

    // 19 fields
    public $election_to;
    public $candidate_name;
    public $place;
    public $candidate_date;

    public $office_hour;
    public $office_date;
    public $delivered_by_name;
    public $delivered_by_role;
    public $ro_date;

    public $candidate_signature = 'Signature of 1[validly nominated candidate]';
    public $ro_signature = 'Returning Officer';

    public $receipt_candidate_name;
    public $receipt_election_to;
    public $receipt_delivered_by;
    public $receipt_office_hour;
    public $receipt_office_date;
    public $receipt_ro_signature = 'Returning Officer';
    public $receipt_place;
    public $receipt_date;

    // FOOTNOTE fields
    public $footnote_hp_constituency;
    public $footnote_la_constituency;
    public $footnote_cs_state;
    public $footnote_cs_ut;
    public $footnote_lc_constituency;

    public function mount($id)
    {
        $this->candidate = Candidate::findOrFail($id);

        // Candidate name auto set
        $this->candidate_name = $this->candidate->name;
        $this->receipt_candidate_name = $this->candidate->name;

        // Load latest saved record
        $latest = CandidateForm5::where('candidate_id', $id)
            ->latest()
            ->first();

        if ($latest) {
            $this->fill($latest->toArray());
        }
    }

    public function save()
    {
        CandidateForm5::create([
            'candidate_id' => $this->candidate->id,

            'election_to' => $this->election_to,
            'candidate_name' => $this->candidate_name,
            'place' => $this->place,
            'candidate_date' => $this->candidate_date,

            'office_hour' => $this->office_hour,
            'office_date' => $this->office_date,
            'delivered_by_name' => $this->delivered_by_name,
            'delivered_by_role' => $this->delivered_by_role,
            'ro_date' => $this->ro_date,

            'candidate_signature' => $this->candidate_signature,
            'ro_signature' => $this->ro_signature,

            'receipt_candidate_name' => $this->receipt_candidate_name,
            'receipt_election_to' => $this->receipt_election_to,
            'receipt_delivered_by' => $this->receipt_delivered_by,
            'receipt_office_hour' => $this->receipt_office_hour,
            'receipt_office_date' => $this->receipt_office_date,
            'receipt_ro_signature' => $this->receipt_ro_signature,
            'receipt_place' => $this->receipt_place,
            'receipt_date' => $this->receipt_date,

            // ✅ FOOTNOTES
            'footnote_hp_constituency' => $this->footnote_hp_constituency,
            'footnote_la_constituency' => $this->footnote_la_constituency,
            'footnote_cs_state' => $this->footnote_cs_state,
            'footnote_cs_ut' => $this->footnote_cs_ut,
            'footnote_lc_constituency' => $this->footnote_lc_constituency,
        ]);
         // ✅ SESSION SUCCESS MESSAGE
        session()->flash('success', 'Form 5 details saved successfully.');
    }


    public function saveAndPrint()
    {
        $this->save();
        $this->dispatch('print-form5');
    }

    public function render()
    {
        return view('livewire.candidate-form5-update')
            ->layout('layouts.admin');
    }
}

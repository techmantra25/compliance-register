<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Candidate;
use App\Models\CandidateDocumentType;
use App\Models\CandidateDocument;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class CandidateDocumentPreview extends Component
{
    public $candidateData;
    public $candidateId;
    public $candidateName;
    public $nomination_date;
    public $phase;
    public $availableDocuments = [];
    public $active_tab;
    public $assemblyName;
    public $date_of_election;
    public $active_file;
    public $observation_description;
    public function mount($document)
    {
        $candidate = Candidate::with('assembly.assemblyPhase.phase')->find($document);

        if (!$candidate) {
            abort(404, 'Candidate not found.');
        }
        $allowedStatuses = ['verified_pending_submission', 'approved'];

        // if (!in_array($candidate->document_collection_status, $allowedStatuses)) {
        //     abort(403, 'Documents are not uploaded');
        // }

        $admin = Auth::guard('admin')->user();
        $userRole = strtolower(trim($admin->role));

        /*
        |--------------------------------------------------------------------------
        | Employee Access Check
        |--------------------------------------------------------------------------
        */
        if ($userRole === 'employee') {

            $employeeAssemblies = $admin->assemblies
                ? array_map('intval', explode(',', $admin->assemblies))
                : [];

            if (!in_array($candidate->assembly_id, $employeeAssemblies)) {
                abort(403, 'You are not authorized to access this candidate.');
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Legal Associate Access Check
        |--------------------------------------------------------------------------
        */
        if ($userRole === 'legal_associate') {

            if ($candidate->legal_associate_id != $admin->id) {
                abort(403, 'You are not authorized to access this candidate.');
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Candidate Data
        |--------------------------------------------------------------------------
        */

        $this->assemblyName = optional($candidate->assembly)->assembly_number 
        ? optional($candidate->assembly)->assembly_number . '-' . optional($candidate->assembly)->assembly_name_en
        : '';
        $this->nomination_date = $candidate?->assembly?->assemblyPhase?->phase?->last_date_of_nomination;
        $this->date_of_election = $candidate?->assembly?->assemblyPhase?->phase?->date_of_election;
        $this->phase = $candidate?->assembly?->assemblyPhase?->phase?->name;

        $this->candidateData = $candidate;
        $this->candidateId = $candidate->id;
        $this->candidateName = $candidate->name;
        $this->observation_description = $candidate->observation_description;

        $this->availableDocuments = $this->getDocumentTypes();

        $firstKey = array_key_first($this->availableDocuments);

        $this->ChangeDocument($firstKey);
    }
    public function updatedObservationDescription($value)
    {
        Candidate::where('id', $this->candidateId)
            ->update([
                'observation_description' => $value
            ]);
    }

    public function ChangeDocument($key)
    {
        $this->active_tab = $key;

        $this->active_file = CandidateDocument::where('candidate_id', $this->candidateId)
            ->where('type', $key)
            ->orderByDesc('id')
            ->value('path');
    }
    protected function getDocumentTypes()
    {
        return CandidateDocumentType::orderBy('position','ASC')->pluck('name', 'key')->toArray();
    }

    public function GenerateAcknowledgementForm()
    {
        $admin = Auth::guard('admin')->user();

        $candidate = Candidate::findOrFail($this->candidateId);

        // Check if legal associate assigned
        if ($candidate->legal_associate_id && $candidate->legal_associate_id != $admin->id) {

            $this->dispatch(
                'toastr:error',
                message: 'You are not authorized to generate this acknowledgement. Only the assigned Legal Associate can proceed.'
            );

            return;
        }

        // Update status
        $candidate->status = "without_criminal_full_generation";
        $candidate->document_collection_status = "approved";
        $candidate->save();

        $this->candidateData = $candidate;

        $this->dispatch(
            'toastr:success',
            message: 'Acknowledgement generated successfully!'
        );
    }
    public function downloadAcknowledgement()
    {
        $data = [
            'candidateName'   => $this->candidateName,
            'assemblyName'    => $this->assemblyName,
            'Examination'     => now(),
            'nomination_date' => $this->nomination_date,
        ];

        $pdf = Pdf::loadView('pdf.acknowledgement', $data)
            ->setPaper('A4', 'portrait');

        return response()->streamDownload(
            fn () => print($pdf->output()),
            "acknowledgement_form.pdf"
        );
    }

    public function GenerateObservationMemo(){
        $latestDocs = CandidateDocument::where('candidate_id', $this->candidateId)
        ->selectRaw('MAX(id) as id')
        ->groupBy('type')
        ->pluck('id');

        $docs = CandidateDocument::whereIn('id', $latestDocs)->get();
        foreach ($docs as $item) {

            if ($item->status == "Uploaded") {

                $item->status = "Rejected";
                $item->save();

            } elseif ($item->status == "Skipped") {

                $item->delete();

            } else {

                // If already Rejected or other status
                $item->status = "Rejected";
                $item->save();
            }

        }

        $update = Candidate::findOrFail($this->candidateId);
        $update->status = "without_criminal_rejected_observation_only";
        $update->document_collection_status = "incomplete_additional_required";
        $update->save();
        $this->candidateData = $update;

    }

   public function downloadObservationMemo()
    {
        $update = Candidate::findOrFail($this->candidateId);
        $data = [
            'candidateName'   => $this->candidateName,
            'assemblyName'    => $this->assemblyName,
            'examinationDate' => now(),
            'nomination_date' => $this->nomination_date,
            'observations'    => $update->observation_description ?? '',
        ];

        $pdf = Pdf::loadView('pdf.observation_memo', $data)
            ->setPaper('A4', 'portrait');

        return response()->streamDownload(
            fn () => print($pdf->output()),
            "observation_memo.pdf"
        );
    }

    public function render()
    {
        return view('livewire.candidate-document-preview')
            ->layout('layouts.admin');
    }
}
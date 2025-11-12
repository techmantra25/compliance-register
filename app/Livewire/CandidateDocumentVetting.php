<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use Livewire\WithFileUploads;
use App\Models\Candidate;
use App\Models\ChangeLog;
use App\Models\CandidateDocumentType;
use App\Models\CandidateDocument;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class CandidateDocumentVetting extends Component
{
    use WithFileUploads;

    public $candidateId;
    public $candidateName,$assemblyName,$agentName,$agentNumber,$agentId,$phase =1, $nomination_date;
    public $documents = [];
    public $candidateData;
    public $remarks;
    public $availableDocuments = [];

    public function mount($document)
    {
        // Fetch the candidate or abort if not found
        $candidate = Candidate::with('assembly')->find($document);
        if (!$candidate) {
            abort(404, 'Candidate not found.');
        }
        $this->nomination_date = $candidate?->assembly?->assemblyPhase?->phase?->last_date_of_nomination;
        $this->phase = $candidate?->assembly?->assemblyPhase?->phase?->name;

        // Store only serializable data
        $this->candidateData = $candidate;
        $this->candidateId = $candidate->id;
        $this->candidateName = $candidate->name;
        $this->assemblyName =optional( $candidate->assembly)->assembly_name_en.'('.optional($candidate->assembly)->assembly_number.')';
        $this->agentName =optional($candidate->agent)->name;
        $this->agentId =optional($candidate->agent)->id;
        $this->agentNumber =optional( $candidate->agent)->contact_number;
        
        // Fetch available document types
        $this->availableDocuments = $this->getDocumentTypes();
        
        // Load existing uploaded documents as arrays
        $this->loadDocuments();
    }
    
    /**
     * Helper function — all document names
     */
    protected function getDocumentTypes()
    {
        return CandidateDocumentType::pluck('name', 'key')->toArray();
    }

    /**
     * Load documents as simple arrays for Livewire serialization
     */
    protected function loadDocuments()
    {
        $documentsData = CandidateDocument::with('uploadedBy')
        ->where('candidate_id', $this->candidateId)
        ->orderBy('id', 'desc')
        ->get()
        ->groupBy('type')
        ->map(function ($group) {
            return $group->sortByDesc('id')->map(function ($document) {
                return [
                    'id' => $document->id,
                    'path' => $document->path,
                    'remarks' => $document->remarks,
                    'created_at' => $document->created_at->format('d/m/Y h:i A'),
                    'uploaded_by_name' => $document->uploadedBy->name ?? 'System',
                    'uploaded_by_id' => $document->uploaded_by,
                    'status' => $document->status,
                ];
            })->values()->toArray();
        })
        ->toArray();

        $this->documents = $documentsData;
    }

    public function resetForm(){
        $this->reset(['remarks']);
    }

    public function updateStatus($value, $document){
        $this->dispatch('showConfirm', ['value' => $value, 'document'=>$document, 'selectElement'=>null]);
    }

    public function UpdateDocStatus($status, $document){
        $CandidateDocument = CandidateDocument::where('type', $document)->orderByDesc('id')->first();
        $CandidateDocument->status = $status;
        $CandidateDocument->save();
        $this->loadDocuments();
        $this->dispatch('toastr:success', message: 'Status updated successfully.');
    }

    public function reloadData(){}
    public function render()
    {
        return view('livewire.candidate-document-vetting')->layout('layouts.admin');
    }
}

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
    
    public function FinalStatusUpdate(){
        $required_documents = $this->getDocumentTypes();
        $documentsData = CandidateDocument::with('uploadedBy')
            ->where('candidate_id', $this->candidateId)
            ->orderBy('id', 'desc')
            ->get()
            ->groupBy('type')
            ->map(function ($group) {
                $latest = $group->sortByDesc('id')->first(); // get latest document
                return $latest->status; // only return the status
            })
            ->toArray();
        
        if(count($required_documents) == count($documentsData)){
            if($this->candidateData->document_collection_status=="verified_submitted_with_copy"){
                return true;
            }
            $approvedCount = count(array_filter($documentsData, fn($status)=> $status === "Approved"));
            $pendingCount = count(array_filter($documentsData, fn($status)=> $status === "Pending"));

            if(count($required_documents) == $approvedCount){
                $this->candidateData->document_collection_status = "verified_pending_submission";
                $this->candidateData->save();
            }elseif(count($required_documents) == $pendingCount){
                $this->candidateData->document_collection_status = "ready_for_vetting";
                $this->candidateData->save();
            }elseif(count($required_documents) !== $pendingCount){
                $this->candidateData->document_collection_status = "vetting_in_progress";
                $this->candidateData->save();
            }

        }else{
            if(count($documentsData)>0){
                $this->candidateData->document_collection_status = "incomplete_additional_required";
                $this->candidateData->save();
            }
        }
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
                    'type' => $document->type,
                    'path' => $document->path,
                    'remarks' => $document->remarks,
                    'created_at' => $document->created_at->format('d/m/Y h:i A'),
                    'vetted_on' => $document->vetted_on?$document->vetted_on->format('d/m/Y h:i A'):"N/A",
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
    
    public function reloadData(){}
    public function render()
    {
        $this->FinalStatusUpdate();
        return view('livewire.candidate-document-vetting')->layout('layouts.admin');
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use Livewire\WithFileUploads;
use App\Models\Candidate;
use App\Models\ChangeLog;
use App\Models\CandidateAcknowledgmentCopy;
use App\Models\CandidateDocumentType;
use App\Models\CandidateDocument;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CandidateDocumentVetting extends Component
{
    use WithFileUploads;

    public $candidateId;
    public $candidateName,$assemblyName,$agentName,$agentNumber,$agentId,$phase =1, $nomination_date;
    public $documents = [];
    public $acknowledgmentCopies;
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
        $skipOption = CandidateDocument::with('uploadedBy')
            ->where('candidate_id', $this->candidateId)
            ->where('status', 'Skipped')
            ->orderBy('id', 'desc')
            ->get()
            ->groupBy('type')->toArray();

        if(count($required_documents) == count($documentsData)){
            if($this->candidateData->document_collection_status=="verified_submitted_with_copy" || $this->candidateData->document_collection_status=="rejected"){
                return true;
            }
            $approvedCount = count(array_filter($documentsData, fn($status)=> $status === "Approved")) + count($skipOption);
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
                    'attached_with' => $document->attached_with,
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
    
    public function getAcknowledgmentCopies(){
        $this->acknowledgmentCopies = CandidateAcknowledgmentCopy::where('candidate_id', $this->candidateId)
            ->orderBy('id', 'desc')
            ->first();
    }

    public function approveAcknowledgment($id)
    {
        $copy = CandidateAcknowledgmentCopy::find($id);
        $copy->status = 'approved';
        $copy->acknowledgment_at = now();
        $copy->acknowledgment_by = auth()->id();
        $copy->save();
        $this->candidateData->document_collection_status = "verified_submitted_with_copy";
        $this->candidateData->save();

        $this->getAcknowledgmentCopies();
        $this->dispatch('toastr:success', message: 'Acknowledgment Approved Successfully');
    }

    public function rejectAcknowledgment($id, $reason)
    {
        $copy = CandidateAcknowledgmentCopy::find($id);
        $copy->status = 'rejected';
        $copy->rejected_reason = $reason;
        $copy->acknowledgment_at = now();
        $copy->acknowledgment_by = auth()->id();
        $copy->save();
        $this->candidateData->document_collection_status = "verified_pending_submission";
        $this->candidateData->save();

        $this->getAcknowledgmentCopies();
        $this->dispatch('toastr:error', message: 'Acknowledgment Rejected Successfully');
    }

    public function reloadData(){}

    public function createSpecialCaseClone($candidateId, $remarks)
    {
        $candidate = Candidate::with('agents')->find($candidateId);

        if (!$candidate) {
            return;
        }

        DB::beginTransaction();
        try {

            // STEP 1: CREATE CLONE
            $clone = $candidate->replicate(); // copies all columns

            // Reset / Modify fields for clone
            $clone->is_special_case = 1;
            $clone->special_case_label = "Special Case";
            $clone->parent_candidate_id = $candidate->id;
            $clone->document_collection_status = "not_received_form"; // reset flow
            $clone->cloned_by = auth()->id();
            $clone->cloned_at = now();
            $clone->clone_remarks = $remarks;

            // Important: avoid copying timestamps from old record
            $clone->created_at = now();
            $clone->updated_at = now();

            $clone->save();

            // STEP 2: CLONE AGENTS (Pivot Table)
            if ($candidate->agents && $candidate->agents->count() > 0) {
                $clone->agents()->sync($candidate->agents->pluck('id')->toArray());
            }

            // STEP 3: MARK ORIGINAL AS REJECTED & CLOSED
            $candidate->document_collection_status = 'rejected';
            $candidate->cloned_by = auth()->id();
            $candidate->cloned_at = now();
            $candidate->clone_remarks = $remarks;
            $candidate->save();

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        // STEP 3: Fire success alert
        return redirect()->route('admin.candidates.contacts')->with('success', 'Special Case Clone Created Successfully.');
    }

    public function render()
    {
        $this->getAcknowledgmentCopies();
        $this->FinalStatusUpdate();
        return view('livewire.candidate-document-vetting')->layout('layouts.admin');
    }
}

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

class CandidateDocumentCollection extends Component
{
    use WithFileUploads;

    public $candidateId;
    public $candidateName,$assemblyName,$agentName,$agentNumber,$agentId,$phase =1,$nomination_date;
    public $documents = [];
    // public $newFiles = [];
    public $candidateData;
    public $newFile;
    public $type;
    public $remarks;
    // public $remarks = [];
    public $availableDocuments = [];

    public function mount(Request $request)
    {
        // Get the candidate ID from the route
        $candidateId = $request->query('candidate');
        
        // Fetch the candidate or abort if not found
        $candidate = Candidate::find($candidateId);
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
        // $this->FinalStatusUpdate();
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
                    'vetted_by_name' => $document->vettedBy->name ?? 'N/A',
                    'vetted_on' => $document->vetted_on?$document->vetted_on->format('d/m/Y h:i A'):"N/A",
                    'uploaded_by_id' => $document->uploaded_by,
                    'comments_count' => $document->comments->count(),
                    'status' => $document->status,
                ];
            })->values()->toArray();
        })
        ->toArray();

        $this->documents = $documentsData;
    }

    public function resetForm(){
        $this->reset(['type','newFile','remarks']);
    }
    public function SetDocType($value){
        $this->type = $value;
    }
    public function save()
    {
        $this->validate([
            "type" => 'required|string',
            'newFile' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,csv,jpg,jpeg,png,gif,bmp,webp|max:5120',
            "remarks" => 'nullable|string|max:500',
        ]);

        try {
            $file = $this->newFile;
            
            // Generate a unique filename with timestamp
            $timestamp = now()->format('Ymd_His');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $filename = "{$originalName}_{$timestamp}.{$extension}";

            // Store file in public/candidate_docs/{id}/
            $path = $file->storeAs("candidate_docs/{$this->candidateId}", $filename, 'public');

            // Save record in DB
            CandidateDocument::create([
                'candidate_id' => $this->candidateId,
                'type' => $this->type,
                'path' => 'storage/'.$path,
                'remarks' => $this->remarks ?? null,
                'uploaded_by' => Auth::guard('admin')->id(),
            ]);
            
            ChangeLog::create([
                'module_name'   => 'Document',
                'module_id'     => $this->candidateId,
                'action'        => 'Upload',
                'link'   => asset("candidate_docs/{$this->candidateId}/{$filename}"),
                'document_name' => $this->availableDocuments[$this->type],
                'changed_by'    => Auth::guard('admin')->id(),
                'user_agent'    => $this->agentId,
            ]);

            // Reset file and remarks for this type
            unset($this->newFile);
            unset($this->remarks);


            // Reload documents
            $this->loadDocuments();
            $this->dispatch(['ResetFormData']);

            $this->dispatch('toastr:success', message: 'Document uploaded successfully!');
            return redirect()->route('admin.candidates.documents', ['candidate'=>$this->candidateId]);

        } catch (\Exception $e) {
            // dd($e->getMessage());
            $this->dispatch('toastr:error', message: 'Error uploading document: ' . $e->getMessage());
        }
    }
    

    /**
     * Delete a document
     */
    public function deleteDocument($documentId)
    {
        $this->dispatch('showConfirm', ['itemId' => $documentId]);
    }
    public function delete($documentId)
    {
        try {
            $document = CandidateDocument::where('candidate_id', $this->candidateId)
                ->where('id', $documentId)
                ->first();

            if ($document) {
                // Delete file from storage
                if (file_exists(public_path('storage/' . $document->path))) {
                    unlink(public_path('storage/' . $document->path));
                }
                
                // Delete record from database
                $document->delete();
                
                // Reload documents
                $this->loadDocuments();
                
                $this->dispatch('toastr:success', message: 'Document deleted successfully!');
            }
        } catch (\Exception $e) {
            $this->dispatch('toastr:error', message: 'Error deleting document: ' . $e->getMessage());
        }
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
    public function render()
    {
        $this->FinalStatusUpdate();
        return view('livewire.candidate-document-collection')->layout('layouts.admin');
    }
}
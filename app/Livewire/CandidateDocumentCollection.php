<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use Livewire\WithFileUploads;
use App\Models\Candidate;
use App\Models\CandidateAcknowledgmentCopy;
use Illuminate\Support\Facades\DB;
use App\Models\ChangeLog;
use App\Models\CandidateAcknoledgmentCopy;
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
    public $acknowledgmentCopies = [];
    public $candidateData;
    public $newFile;
    public $type;
    public $remarks, $acknowledgment_file, $final_submission_confirmation;
    // public $remarks = [];
    public $availableDocuments = [];
    public $skipOption = [];
    public $attachedTo = [];
    public $remainRequiredDocuments = [];
    public $documents_approved_by;

    public function mount(Request $request)
    {
        // Get the candidate ID from the route
        $candidateId = $request->query('candidate');
        
        // Fetch the candidate or abort if not found
        $candidate = Candidate::find($candidateId);

        if (!$candidate) {
            abort(404, 'Candidate not found.');
        }
       $userRole = trim(strtolower(Auth::guard('admin')->user()->role));

        if ($userRole == 'legal_associate') {
            abort(403, 'You are not authorized to access this candidate.');
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
        $this->documents_approved_by = $this->candidateData
        ->documents
        ->where('status', 'Approved')
        ->load('vettedBy')
        ->pluck('vettedBy.name')      
        ->filter()                    
        ->unique()                    
        ->values()                   
        ->implode(', ');             

    }


    public function toggleSkip($key, $checked)
    {
        // If unchecked, Livewire clears the value
        $item_value = $checked??null;
        $this->skipOption[$key] = $item_value;
        if ($item_value !== 'yes') {
            // User unchecked — treat as NO
            $this->skipOption[$key] = null;
            $this->attachedTo[$key] = null; // clear parent attachment
        }
    }

    public function updateAttachment($key, $attachedWith)
    {
        $create = CandidateDocument::updateOrCreate(
            [
                'candidate_id' => $this->candidateId,
                'type' => $key,
            ],
            [
                'attached_with' => $attachedWith,
                'uploaded_by' => Auth::guard('admin')->id(),
                'status' => 'Skipped',
            ]
        );
        $this->dispatch('toastr:success', message: 'Attachment updated successfully!');
        $this->loadDocuments();
    }
    
    /**
     * Helper function — all document names
     */
    protected function getDocumentTypes()
    {
        return CandidateDocumentType::pluck('name', 'key')->toArray();
    }
    protected function remainDocuments(){
        $skippedDocs = CandidateDocument::where('candidate_id', $this->candidateId)->where('status', 'Skipped')->pluck('type')->toArray();
        $allDocs = CandidateDocumentType::whereNotIn('key', $skippedDocs)->pluck('name','key')->toArray();
        return $allDocs;
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
                    'updated_at' => $document->updated_at->format('d/m/Y h:i A'), 
                    'uploaded_by_name' => $document->uploadedBy->name ?? 'System',
                    'attached_with' => $document->attached_with,
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
            'newFile' => 'required|file|mimes:pdf,jpg,jpeg,png,gif,bmp,webp|max:5120',
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

            // First check same type
            $existingDoc = CandidateDocument::where('candidate_id', $this->candidateId)
            ->where('type', $this->type)
            ->first();
            // Save record in DB
            CandidateDocument::create([
                'candidate_id' => $this->candidateId,
                'type' => $this->type,
                'path' => 'storage/'.$path,
                'remarks' => $this->remarks ?? null,
                'uploaded_by' => Auth::guard('admin')->id(),
            ]);

            // Detect Upload or Re-Upload
            $actionText = $existingDoc ? 'Re-Uploaded' : 'Uploaded';
        
            $logData = [
                'module_name'   => 'Document',
                'module_id'     => $this->candidateId,
                'action'        => $actionText,
                'description'   => "{$this->availableDocuments[$this->type]} {$actionText} successfully.",
                'old_data'      => null,
                'new_data'      => json_encode([
                    'type' => $this->type,
                    'path' => 'storage/'.$path,
                    'remarks' => $this->remarks,
                ]),
                'document_name' => $this->availableDocuments[$this->type],
                'link'          => asset("candidate_docs/{$this->candidateId}/{$filename}"),
            ];
            logChange($logData);


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

    public function saveAcknowledgment()
    {
        $this->validate([
            'acknowledgment_file' => 'required|mimes:pdf,doc,docx,jpg,jpeg,png,webp|max:5120',
            'final_submission_confirmation' => 'required|date',
        ]);

        $timestamp = now()->format('Ymd_His');
        $ext = $this->acknowledgment_file->getClientOriginalExtension();
        $filename = "ack_{$this->candidateId}_{$timestamp}.{$ext}";

        $path = $this->acknowledgment_file->storeAs(
            "candidate_acknowledgment/{$this->candidateId}",
            $filename,
            'public'
        );

        CandidateAcknowledgmentCopy::create([
            'candidate_id' => $this->candidateId,
            'path' => "storage/{$path}",
            'uploaded_by' => auth('admin')->id(),
            'uploaded_at' => now(),
            'final_submission_confirmation' => $this->final_submission_confirmation. ' 00:00:00',
        ]);

        $this->reset(['acknowledgment_file','final_submission_confirmation']);

        $this->dispatch('toastr:success', message: 'Acknowledgment uploaded successfully');
    }

    // public function uploadAcknowledgmentCopy(){
    //     $this->validate([
    //         'acknowledgment_file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png,gif,bmp,webp|max:5120',
    //         'final_submission_confirmation' => 'required|date',
    //     ]);
    //     DB::beginTransaction();

    //     try {
    //     // Get file instance
    //     $file = $this->acknowledgment_file;

    //     // Create unique filename
    //     $timestamp = now()->format('Ymd_His');
    //     $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
    //     $extension = $file->getClientOriginalExtension();
    //     $filename = "{$originalName}_{$timestamp}.{$extension}";

    //     // Store file in public/candidate_docs/{id}/
    //     $path = $file->storeAs("candidate_docs/{$this->candidateId}", $filename, 'public');

    //     // Save record in DB
    //     CandidateAcknoledgmentCopy::create([
    //         'candidate_id' => $this->candidateId,
    //         'path' => 'storage/'.$path,
    //     ]);

    //    $candidateUpdate = Candidate::findOrFail($this->candidateId);
    //    $candidateUpdate->acknowledgment_file = 'storage/'.$path;
    //    $candidateUpdate->acknowledgment_by = Auth::guard('admin')->id();
    //    $candidateUpdate->final_submission_confirmation = $this->final_submission_confirmation;
    //    $candidateUpdate->document_collection_status = "verified_submitted_with_copy";
    //    $candidateUpdate->acknowledgment_at = now();
    //    $candidateUpdate->save();

    //     DB::commit();
    //     session()->flash('success', 'Document uploaded successfully!');
    //     return redirect()->route('admin.candidates.documents', ['candidate'=>$this->candidateId]);

    //    } catch (\Exception $e) {
    //         // dd($e->getMessage());
    //         $this->dispatch('toastr:error', message: 'Error uploading document: ' . $e->getMessage());
    //     }
    // }
    public function FinalStatusUpdate(){
        $required_documents = $this->getDocumentTypes();
        $documentsData = CandidateDocument::with('uploadedBy')
            ->where('candidate_id', $this->candidateId)
            ->orderBy('id', 'desc')
            ->get()
            ->groupBy('type')
            ->map(function ($group) {
                $latest = $group->sortByDesc('id')->first(); 
                return $latest->status; 
            })
            ->toArray();
        $skipOption = CandidateDocument::with('uploadedBy')
            ->where('candidate_id', $this->candidateId)
            ->where('status', 'Skipped')
            ->orderBy('id', 'desc')
            ->get()
            ->groupBy('type')->toArray();
        if(count($required_documents) == count($documentsData)){
            if($this->candidateData->document_collection_status=="verified_submitted_with_copy" ||$this->candidateData->document_collection_status=="rejected"){
                return true;
            }
            // $approvedCount = count(array_filter($documentsData, fn($status)=> $status === "Approved")) + count($skipOption);
            // $pendingCount = count(array_filter($documentsData, fn($status)=> $status === "Pending"));
            $approvedOnlyCount = count(array_filter(
                $documentsData,
                fn($status) => $status === "Approved"
            ));

            $pendingOnlyCount = count(array_filter(
                $documentsData,
                fn($status) => $status === "Pending"
            ));

            $skippedCount = count(array_filter(
                $documentsData,
                fn($status) => $status === "Skipped"
            ));

            $totalRequired = count($required_documents);
            // if (($approvedOnlyCount + $skippedCount) === $totalRequired) {

            //     $this->candidateData->document_collection_status = "verified_pending_submission";

            // }
            // elseif (($pendingOnlyCount + $skippedCount) === $totalRequired && $approvedOnlyCount === 0) {

            //     $this->candidateData->document_collection_status = "ready_for_vetting";

            // }
            // else {

            //     $this->candidateData->document_collection_status = "vetting_in_progress";

            // }

            // $this->candidateData->save();
            $newStatus = null;

            if (($approvedOnlyCount + $skippedCount) === $totalRequired) {
                $newStatus = "verified_pending_submission";
            }
            elseif (($pendingOnlyCount + $skippedCount) === $totalRequired && $approvedOnlyCount === 0) {
                $newStatus = "ready_for_vetting";
            }
            else {
                $newStatus = "vetting_in_progress";
            }
            
            if ($this->candidateData->document_collection_status !== $newStatus) {
                $this->candidateData->document_collection_status = $newStatus;
                $this->candidateData->save();
            }

        }else{
            if(count($documentsData)>0){
                $this->candidateData->document_collection_status = "incomplete_additional_required";
                $this->candidateData->save();
            }
        }
    }
    public function getAcknowledgmentCopies(){
        $this->acknowledgmentCopies = CandidateAcknowledgmentCopy::where('candidate_id', $this->candidateId)->orderBy('uploaded_at', 'desc')->get();
    }
    public function render()
    {
        $this->remainRequiredDocuments = $this->remainDocuments();
        $this->getAcknowledgmentCopies();
        $this->FinalStatusUpdate();
        return view('livewire.candidate-document-collection')->layout('layouts.admin');
    }
}
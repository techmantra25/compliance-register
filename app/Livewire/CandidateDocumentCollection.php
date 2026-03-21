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
use App\Models\CandidateObservationStep;
use App\Models\CandidateDocumentType;
use App\Models\CandidateDocument;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use App\Mail\NominationVettingMail;
use Carbon\Carbon;
use App\Models\Admin;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class CandidateDocumentCollection extends Component
{
    use WithFileUploads;

    public $candidateId;
    public $versions;
    public $legalAssociate;
    public $candidateName,$assemblyName,$agentName,$agentNumber,$agentId,$phase =1,$nomination_date;
    public $documents = [];
    // public $newFiles = [];
    public $acknowledgementCopies = [];
    public $candidateData;
    public $newFile;
    public $type;
    public $remarks, $acknowledgement_file, $final_submission_confirmation;
    // public $remarks = [];
    public $availableDocuments = [];
    public $skipOption = [];
    public $attachedTo = [];
    public $remainRequiredDocuments = [];
    public $documents_approved_by;
    public $showPreviewButton = false;
    public $candidate_status;
    public $authUser;
    public $sameAsBefore = false;
    public $withCriminal = false;
    public $assignedLegalAssociate;

    public function mount(Request $request)
    {
        $candidateId = $request->query('candidate');

        $candidate = Candidate::find($candidateId);

        if (!$candidate) {
            abort(404, 'Candidate not found.');
        }

        $admin = Auth::guard('admin')->user();
        $userRole = trim(strtolower($admin->role));

        // If employee, check assembly permission
        if ($userRole === 'employee') {

            $employeeAssemblies = $admin->assemblies
                ? array_map('intval', explode(',', $admin->assemblies))
                : [];

            if (!in_array($candidate->assembly_id, $employeeAssemblies)) {
                abort(403, 'You are not authorized to access this candidate.');
            }
        }

        $this->nomination_date = $candidate?->assembly?->assemblyPhase?->phase?->last_date_of_nomination;
        $this->phase = $candidate?->assembly?->assemblyPhase?->phase?->name;
        // Store only serializable data
        $this->candidateData = $candidate;
        $this->candidateId = $candidate->id;
        $this->candidateName = $candidate->name;
        $this->candidate_status = $candidate->status;
        $this->assemblyName = optional($candidate->assembly)->assembly_number 
        ? optional($candidate->assembly)->assembly_number . '-' . optional($candidate->assembly)->assembly_name_en
        : '';
        $this->agentName =optional($candidate->agent)->name;
        $this->agentId =optional($candidate->agent)->id;
        $this->agentNumber =optional( $candidate->agent)->contact_number;
        
        // Fetch available document types
        $this->availableDocuments = $this->getDocumentTypes();
        // Load existing uploaded documents as arrays
        $this->loadDocuments();
        $this->documents_approved_by = $this->candidateData
        ->documents
        ->where('status', 'Uploaded')
        ->load('vettedBy')
        ->pluck('vettedBy.name')      
        ->filter()                    
        ->unique()                    
        ->values()                   
        ->implode(', ');    
        $this->withCriminal = $this->candidateData->is_criminal_offence=="1"?true:false;
        $this->assignedLegalAssociate = $this->candidateData->legal_associate_id;
        $this->legalAssociate = Admin::where('role', 'legal_associate')->where('suspended_status', 1)->orderBy('name')->get();

    }

    public function toggleCriminalStatus()
    {
        if ($this->withCriminal) {
            $this->candidateData->is_criminal_offence = 1;
            $this->candidateData->save();
        } else {
            $this->candidateData->is_criminal_offence = 0;
            $this->candidateData->legal_associate_id = null;
            $this->assignedLegalAssociate = null;
            $this->candidateData->save();
        }
    }

    public function assignLegalAssociate()
    {
        if ($this->assignedLegalAssociate) {
            $this->candidateData->legal_associate_id = $this->assignedLegalAssociate;
            $this->candidateData->save();

            $this->dispatch('toastr:success', message: 'Legal Associate assigned successfully!');

        } else {

            $this->candidateData->legal_associate_id = null;
            $this->candidateData->save();

            $this->dispatch('toastr:error', message: 'Legal Associate removed.');
        }

        $this->loadDocuments();
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

    public function updateAttachment($key, $attachedWith, $parentKey)
    {
        $existKey= CandidateDocument::where('candidate_id',$this->candidateId)->where('attached_with_slug',$key)->first();
        if($existKey){
            $this->dispatch('toastr:error', message: 'This document already has another document attached, so it cannot be skipped.');
            return true;
        }
        $latestVersion = CandidateDocument::where('type', $this->type)->where('candidate_id', $this->candidateId)
                ->max('version');
        $newVersion = 1;
        if($latestVersion){
            $newVersion = $latestVersion + 1;
        }else{
            $otherLatestVersion = CandidateDocument::where('candidate_id', $this->candidateId)->max('version');
            if($otherLatestVersion){
                $newVersion = $otherLatestVersion;
            }
        }
        $create = CandidateDocument::updateOrCreate(
            [
                'candidate_id' => $this->candidateId,
                'type' => $key,
            ],
            [
                'attached_with' => $attachedWith,
                'attached_with_slug' => $parentKey,
                'uploaded_by' => Auth::guard('admin')->id(),
                'status' => 'Skipped',
                'version' => $newVersion,
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
        return CandidateDocumentType::orderBy('position','ASC')->pluck('name', 'key')->toArray();
    }
    protected function remainDocuments(){
        $skippedDocs = CandidateDocument::where('candidate_id', $this->candidateId)->where('status', 'Skipped')->pluck('type')->toArray();
        $allDocs = CandidateDocumentType::whereNotIn('key', $skippedDocs)->pluck('name','key')->toArray();
        $allDocs = ['documents_not_required' => 'Documents Not Required'] + $allDocs;
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
                    'attached_with_slug' => $document->attached_with_slug,
                    'vetted_by_name' => $document->uploadedBy->name ?? 'System',
                    'vetted_on' => $document->updated_at->format('d/m/Y h:i A'),
                    'uploaded_by_id' => $document->uploaded_by,
                    'comments_count' => $document->comments->where('is_viewed',0)->count(),
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
        $rules = [
            "type" => 'required|string',
            "remarks" => 'nullable|string|max:500',
        ];

        if (!$this->sameAsBefore) {
            $rules['newFile'] = 'required';
            $rules['newFile.*'] = 'file|mimes:pdf,jpg,jpeg,png,gif,bmp,webp|max:5120';
        }

        $this->validate($rules);

        try {

           
            // Check existing document of same type
            $existingDoc = CandidateDocument::where('candidate_id', $this->candidateId)
                ->where('type', $this->type)
                ->latest()
                ->first();

            if ($this->sameAsBefore) {

                if (!$existingDoc || empty($existingDoc->path)) {
                    $this->addError('remarks', 'Sorry, previous file not found. Please upload the document again.');
                    return;
                }

                $path = str_replace('storage/', '', $existingDoc->path);
                $filename = basename($path);

            } else {

                $files = is_array($this->newFile) ? $this->newFile : [$this->newFile];

                $timestamp = now()->format('Ymd_His');

                // Check if single image & type = photo
                if (
                    count($files) == 1 &&
                    in_array($files[0]->getClientOriginalExtension(), ['jpg','jpeg','png','webp']) &&
                    $this->type === 'photo'
                ) {
                    $originalName = pathinfo($files[0]->getClientOriginalName(), PATHINFO_FILENAME);
                    $filename = "{$originalName}_{$timestamp}.".$files[0]->getClientOriginalExtension();

                    $path = $files[0]->storeAs("candidate_docs/{$this->candidateId}", $filename, 'public');

                    // Save into Candidate table (image column)
                    Candidate::where('id', $this->candidateId)
                        ->update(['image' => 'storage/'.$path]);
                }

                // If single PDF uploaded
                if (count($files) == 1 && $files[0]->getClientOriginalExtension() == 'pdf') {

                    $originalName = pathinfo($files[0]->getClientOriginalName(), PATHINFO_FILENAME);
                    $filename = "{$originalName}_{$timestamp}.pdf";

                    $path = $files[0]->storeAs("candidate_docs/{$this->candidateId}", $filename, 'public');

                } else {

                    // Convert images to PDF
                    $html = '
                            <style>
                                @page {
                                    size: A4;
                                    margin: 10mm;
                                }

                                body {
                                    margin: 0;
                                    padding: 0;
                                }

                                .page {
                                    width: 100%;
                                    height: 100%;
                                    text-align: center;
                                    page-break-after: always;

                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                }

                               .page img {
                                    width: 100%;
                                    height: 100%;
                                    object-fit: contain;
                                }
                            </style>
                            ';

                    foreach ($files as $file) {

                        $imgPath = $file->store("candidate_docs/temp", 'public');

                        $fullPath = storage_path("app/public/".$imgPath);

                        $base64 = base64_encode(file_get_contents($fullPath));

                        $mime = mime_content_type($fullPath);

                        $html .= '
                            <div class="page">
                                <img src="data:'.$mime.';base64,'.$base64.'">
                            </div>';
                    }

                    $pdf = Pdf::loadHTML($html)->setPaper('a4', 'portrait');

                    $filename = "document_{$timestamp}.pdf";

                    $path = "candidate_docs/{$this->candidateId}/".$filename;

                    Storage::disk('public')->put($path, $pdf->output());
                }
            }

            $latestVersion = CandidateDocument::where('type', $this->type)->where('candidate_id', $this->candidateId)
                ->max('version');
            
            $newVersion = 1;
            if($latestVersion){
                $newVersion = $latestVersion + 1;
            }else{
                $otherLatestVersion = CandidateDocument::where('candidate_id', $this->candidateId)->max('version');
                if($otherLatestVersion){
                    $newVersion = $otherLatestVersion;
                }
            }
            
            CandidateDocument::where('candidate_id', $this->candidateId)
                ->where('status', 'Skipped')
                ->update(['version' => $newVersion]);
            // Save record
            CandidateDocument::create([
                'candidate_id' => $this->candidateId,
                'type' => $this->type,
                'path' => 'storage/'.$path,
                'remarks' => $this->remarks ?? null,
                'version' => $newVersion,
                'uploaded_by' => Auth::guard('admin')->id(),
            ]);

            // Detect Upload / Reupload
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
                    'same_as_before' => $this->sameAsBefore
                ]),
                'document_name' => $this->availableDocuments[$this->type],
                'link'          => asset("storage/{$path}"),
            ];

            logChange($logData);

            $this->reset(['newFile', 'remarks', 'sameAsBefore']);

            $this->loadDocuments();

            $this->dispatch(['ResetFormData']);

            $this->dispatch('toastr:success', message: 'Document uploaded successfully!');

            return redirect()->route('admin.candidates.documents', ['candidate'=>$this->candidateId]);

        } catch (\Exception $e) {
            // dd($e->getMessage());
            $this->dispatch('toastr:error', message: 'Error uploading document: '.$e->getMessage());
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

    public function saveAcknowledgement()
    {
        $this->validate([
            'acknowledgement_file' => 'required|mimes:pdf,doc,docx,jpg,jpeg,png,webp|max:5120',
              'final_submission_confirmation' => 'required|date|before_or_equal:today',
            ],[
                'final_submission_confirmation.before_or_equal' => 'Final submission confirmation date cannot be a future date.',
            ]);
        $timestamp = now()->format('Ymd_His');
        $ext = $this->acknowledgement_file->getClientOriginalExtension();
        $filename = "ack_{$this->candidateId}_{$timestamp}.{$ext}";

        $path = $this->acknowledgement_file->storeAs(
            "candidate_acknowledgement/{$this->candidateId}",
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

        $this->reset(['acknowledgement_file','final_submission_confirmation']);

        $this->dispatch('toastr:success', message: 'Acknowledgement uploaded successfully');
    }

    public function FinalStatusUpdate(){
        $required_documents = $this->getDocumentTypes();
        $latestVersion = CandidateDocument::where('candidate_id', $this->candidateId)
            ->max('version');

        $documentsData = CandidateDocument::with('uploadedBy')
            ->where('candidate_id', $this->candidateId)
            ->where('version', $latestVersion)
            ->get()
            ->keyBy('type')
            ->map(function ($doc) {
                return $doc->status;
            })
            ->toArray();


        // if(count($required_documents) == count($documentsData)){
            if($this->candidateData->document_collection_status=="verified_pending_submission" ||$this->candidateData->document_collection_status=="rejected" ||$this->candidateData->document_collection_status=="approved"){
                return true;
            }

            $uploadedOnlyCount = count(array_filter(
                $documentsData,
                fn($status) => $status === "Uploaded"
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
            $newStatus = null;

            $totalCompleted = $uploadedOnlyCount + $skippedCount;
            // dd($totalCompleted);
            if ($totalCompleted === $totalRequired) {
                $newStatus = "ready_for_vetting";
            } 
            elseif ($totalCompleted > 0) {
                $newStatus = "incomplete_additional_required";
            } 
            else {
                $newStatus = "not_received_form";
            }
            
            if ($this->candidateData->document_collection_status !== $newStatus) {
                if($newStatus=="ready_for_vetting"){
                    $this->candidateData->status = NULL;
                }
                // if($newStatus=="verified_pending_submission"){
                //     $this->candidateData->status = NULL;
                // }
                $this->candidateData->document_collection_status = $newStatus;
                $this->candidateData->save();
            }
        // }else{
        //     if(empty($documentsData)){
        //         $this->candidateData->document_collection_status = "incomplete_additional_required";
        //         $this->candidateData->status = NULL;
        //         $this->candidateData->save();
        //     }
        // }
    }
    

    public function updateDocumentStatus($status, $documentId)
    {
        $document = CandidateDocument::find($documentId);

        if (!$document) {
            $this->dispatch('toastr:error', message: 'Document not found.');
            return;
        }

        if ($document->status !== 'Pending') {
            $this->dispatch('toastr:error', message: 'Status already locked.');
            return;
        }

        $document->status = $status;
        $document->vetted_by = Auth::guard('admin')->id();
        $document->vetted_on = $status == "Uploaded" ? now() : null;
        $document->save();

        $this->loadDocuments();

        $this->dispatch('toastr:success', message: 'Document status updated successfully.');
    }

    protected function SendMail($id){
        
        $legal_associate = Admin::where('role','legal_associate')->pluck('email')->toArray();

        DB::beginTransaction();

        try {

            $candidate = Candidate::findOrFail($id);

            $data = [
                'candidate' => $candidate,

                'ac' => optional($candidate->assembly)->assembly_code . ' | ' .
                    optional($candidate->assembly)->assembly_name_en .
                    ' (' . optional($candidate->assembly)->assembly_name_bn . ')',

                'nominationDate' => optional(optional(optional($candidate->assembly)->assemblyPhase)->phase)->last_date_of_nomination
                    ? Carbon::parse(optional(optional(optional($candidate->assembly)->assemblyPhase)->phase)->last_date_of_nomination)->format('d M Y')
                    : 'N/A',

                'electionDate' => optional(optional(optional($candidate->assembly)->assemblyPhase)->phase)->date_of_election
                    ? Carbon::parse(optional(optional(optional($candidate->assembly)->assemblyPhase)->phase)->date_of_election)->format('d M Y')
                    : 'N/A',

                'link' => route('admin.candidates.documents.vetting', $candidate->id),
            ];

            foreach ($legal_associate as $email) {

                Mail::to($email)->send(
                    new NominationVettingMail($data)
                );
            }

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();
            // dd($e->getMessage());
            $this->dispatch('mail-sent-failed', message: $e->getMessage());
        }
    }
    public function getAcknowledgementCopies(){
        $this->acknowledgementCopies = CandidateAcknowledgmentCopy::where('candidate_id', $this->candidateId)->orderBy('uploaded_at', 'desc')->get();
    }


    public function toggleSameAsBefore()
    {
        if ($this->sameAsBefore) {
            $this->newFile = null;
        }
    }
    public function render()
    {
        $this->versions = CandidateObservationStep::where('candidate_id', $this->candidateId)->orderBy('version', 'ASC')->get();
        $this->authUser = Auth::guard('admin')->user();
        $this->remainRequiredDocuments = $this->remainDocuments();
        $this->getAcknowledgementCopies();
        $this->FinalStatusUpdate();

        $allowedStatuses = [
            'ready_for_vetting',
            'verified_pending_submission'
        ];

        $this->showPreviewButton = in_array(
            $this->candidateData->document_collection_status,
            $allowedStatuses
        );
        return view('livewire.candidate-document-collection')->layout('layouts.admin');
    }
}
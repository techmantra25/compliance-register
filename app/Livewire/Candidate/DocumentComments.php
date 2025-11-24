<?php

namespace App\Livewire\Candidate;

use Livewire\Component;
use App\Models\CandidateDocument;
use App\Models\CandidateDocumentComment;
use Illuminate\Support\Facades\Auth;

class DocumentComments extends Component
{
    public $documentId;
    public $document;
    public $comments = [];
    public $newComment = '';
    public $authUser;

    public function mount($document)
    {
        $this->documentId = $document;
        $this->document = CandidateDocument::findOrFail($document);
        $this->document->file_name = getCandidateDocument($this->document->type);
        $this->loadComments();
        $this->authUser = Auth::guard('admin')->user();
    }

    public function updateStatus($value, $document){
        $this->dispatch('showConfirm', ['value' => $value, 'document'=>$document, 'selectElement'=>null]);
    }

    public function UpdateDocStatus($status, $document){
        $CandidateDocument = CandidateDocument::where('candidate_id', $this->document->candidate_id)->where('type', $document)->orderByDesc('id')->first();
        $CandidateDocument->status = $status;
        $CandidateDocument->vetted_by = Auth::guard('admin')->id();
        $CandidateDocument->vetted_on = $status=="Approved"?now():null;
        $CandidateDocument->save();

        $this->document = CandidateDocument::findOrFail($CandidateDocument->id);
        $this->loadComments();

        $oldData = [
            'status'     => $CandidateDocument->getOriginal('status'),
            'vetted_by'  => optional($CandidateDocument->vettedBy)->name.'(Legal Associate)',
            'vetted_on'  => $CandidateDocument->getOriginal('vetted_on'),
        ];
        $newData = [
            'status'     => $CandidateDocument->status,
            'vetted_by'  => optional($CandidateDocument->vettedBy)->name.'(Legal Associate)',
            'vetted_on'  => $CandidateDocument->vetted_on,
        ];

        $docName = getCandidateDocument($CandidateDocument->type);
        $logData = [
            'module_name'   => 'Document',
            'module_id'     => $CandidateDocument->candidate_id,
            'action'        => 'Verification Update',
            'description'   => "Document '{$docName}' status updated to {$status}",

            'old_data'      => json_encode($oldData),
            'new_data'      => json_encode($newData),

            'document_name' => $docName,
            'changed_by'    => Auth::guard('admin')->id(),
            'link'          => asset($CandidateDocument->path),
        ];

        logChange($logData);
        
        $this->dispatch('toastr:success', message: 'Status updated successfully.');
    }

    public function loadComments()
    {
        $this->comments = CandidateDocumentComment::with('admin')
            ->where('candidate_document_id', $this->documentId)
            ->orderBy('created_at', 'ASC')
            ->get();
    }

    public function addComment()
    {
        $this->validate([
            'newComment' => 'required|string|max:1000',
        ]);

        CandidateDocumentComment::create([
            'candidate_document_id' => $this->documentId,
            'comment' => $this->newComment,
            'created_by' => Auth::guard('admin')->id(),
        ]);

        $this->newComment = '';
        $this->loadComments();

        $this->dispatch(['ResetForm']);
        $this->dispatch('toastr:success', message: '💬 Comment added successfully!');
    }

    public function render()
    {
        return view('livewire.candidate.document-comments')
            ->layout('layouts.admin');
    }
}

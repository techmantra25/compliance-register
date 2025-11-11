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

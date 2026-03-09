<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CandidateDocumentType;
use App\Models\CandidateDocument;
use Illuminate\Support\Str;

class NominationDocumentCrud extends Component
{

    protected $paginationTheme = 'bootstrap';

    public $name, $editId;
    public $isEdit = false;
    public $search = '';
    public $searchResetKey = 0;

    protected function rules()
    {
        return [
            'name' => 'required|unique:candidate_document_types,name,' . $this->editId,
        ];
    }

    public function save()
    {
        $this->validate();

        $slug = Str::slug($this->name, '_');

        if ($this->editId) {
            $fetchData = CandidateDocumentType::findOrFail($this->editId);

                $oldKey = $fetchData->key;

                // Update CandidateDocument type
                CandidateDocument::where('type', $oldKey)
                    ->update([
                        'type' => $slug
                    ]);

                // Update attached document references
                CandidateDocument::where('attached_with_slug', $oldKey)
                    ->update([
                        'attached_with_slug' => $slug,
                        'attached_with' => $this->name
                    ]);

                // Update document type table
                $fetchData->update([
                    'name' => $this->name,
                    'key'  => $slug
                ]);
            $this->dispatch('toastr:success', message: 'Document updated successfully');
        } else {

            $position = (CandidateDocumentType::max('position') ?? 0) + 1;

            CandidateDocumentType::create([
                'name' => $this->name,
                'key' => $slug,
                'status' => 1,
                'position' => $position
            ]);

            $this->dispatch('toastr:success', message: 'Document created successfully');
        }

        $this->resetInputFields();
    }

    public function resetInputFields()
    {
        $this->reset(['name','editId','isEdit','search']);

        $this->searchResetKey++;

        $this->resetErrorBag();
        $this->resetValidation();

        $this->search = '';
    }

    public function filterDocuments($searchTerm)
    {
        $this->search = $searchTerm;
    }

    public function editData($id)
    {
        $doc = CandidateDocumentType::findOrFail($id);
        $this->editId = $doc->id;
        $this->name = $doc->name;

        $this->isEdit = true;
    }

    public function toggleStatus($id)
    {
        $doc = CandidateDocumentType::find($id);

        $doc->update([
            'status' => !$doc->status
        ]);

        $this->dispatch('toastr:success', message: 'Status updated successfully');
    }

    public function updatePosition($items)
    {
        foreach ($items as $item) {

            CandidateDocumentType::where('id', $item['value'])
                ->update(['position' => $item['order']]);

        }

        $this->dispatch('toastr:success', message: 'Position updated');
    }

    public function render()
    {
        $documents = CandidateDocumentType::query()
            ->when($this->search, function ($query) {

                $search = "%{$this->search}%";

                $query->where(function ($q) use ($search) {

                    $q->where('name', 'like', $search)
                      ->orWhere('key', 'like', $search);

                });

            })
            ->orderBy('position')
            ->get();

        return view('livewire.nomination-document-crud', compact('documents'))
            ->layout('layouts.admin');
    }
}
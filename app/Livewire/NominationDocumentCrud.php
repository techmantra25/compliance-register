<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CandidateDocumentType;

class NominationDocumentCrud extends Component
{

    protected $paginationTheme = 'bootstrap';
    public $name, $key, $editId;
    public $isEdit = false;
    public $search = '';
    public $searchResetKey = 0;

    protected function rules()
    {
        return [
            'name' => 'required|unique:candidate_document_types,name,' . $this->editId,
            'key' => 'required|unique:candidate_document_types,key,' . $this->editId,
        ];
    }

    public function save()
    {
        $this->validate();

        if ($this->editId) {

            CandidateDocumentType::find($this->editId)->update([
                'name' => $this->name,
                'key' => $this->key
            ]);
            $this->dispatch('toastr:success', message: 'Document updated successfully');

        } else {

            $position = (CandidateDocumentType::max('position') ?? 0) + 1;

            CandidateDocumentType::create([
                'name' => $this->name,
                'key' => $this->key,
                'status' => 1,
                'position' => $position
            ]);
            $this->dispatch('toastr:success', message: 'Document created successfully');
        }

        $this->resetInputFields();
    }

    public function resetInputFields()
    {
        $this->reset(['name','key','editId','isEdit','search']);
        $this->searchResetKey++; 
        
        $this->resetErrorBag();      
        $this->resetValidation();    
        
        $this->search = '';
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function filterDocuments($searchTerm)
    {
        $this->search = $searchTerm;
    }

    public function edit($id)
    {
        $doc = CandidateDocumentType::findOrFail($id);

        $this->editId = $doc->id;
        $this->name = $doc->name;
        $this->key = $doc->key;

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

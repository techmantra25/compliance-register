<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\EventCategory;
use App\Models\EventRequiredPermission;
use Illuminate\Support\Facades\DB;

class EventCategoryCrud extends Component
{
    public $category_id, $name, $status = 1;
    public $isEdit = false;
    public $search = '';
    public $showPermissionModal = false;
    public $current_category;
    public $permissionRows = [];
    public $rowErrors = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'status' => 'required|boolean',
    ];
    public function mount(){
        $this->status = (bool) 1;
    }

    public function resetInputFields()
    {
        $this->reset(['category_id', 'name', 'status', 'search']);
        $this->isEdit = false;
    }

    public function save()
    {
        $this->isEdit ? $this->updateCategory() : $this->storeCategory();
    }

    protected function storeCategory()
    {
        $this->validate();

        EventCategory::create([
            'name' => $this->name,
            'status' => $this->status,
        ]);

        $this->dispatch('toastr:success', message: 'Event Category added successfully!');
        $this->resetInputFields();
    }

    protected function updateCategory()
    {
        $this->validate();

        $category = EventCategory::findOrFail($this->category_id);
        $category->update([
            'name' => $this->name,
            'status' => $this->status,
        ]);

        $this->dispatch('toastr:success', message: 'Event Category updated successfully!');
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $category = EventCategory::findOrFail($id);
        $this->category_id = $id;
        $this->name = $category->name;
        $this->status = (bool) $category->status;
        $this->isEdit = true;
    }

    public function filter($term)
    {
        $this->search = $term;
    }

    public function toggleStatus($id)
    {
        $category = EventCategory::findOrFail($id);
        $category->status = !$category->status;
        $category->save();
    }

    public function addPermissionRow()
    {
        $this->permissionRows[] = [
            'id' => null,
            'permission_required' => '',
            'issuing_authority' => '',
            'status' => (bool) 1,
        ];
    }
    public function savePermissions()
    {
         $this->rowErrors = []; // reset errors

    DB::beginTransaction();

        try {
            foreach ($this->permissionRows as $index => $row) {

                // 1️⃣ Required field validation
                if (empty($row['permission_required'])) {
                    $this->rowErrors[$index]['permission_required'] = 'Permission field is required.';
                    continue;
                }

                // 2️⃣ Duplicate check
                $duplicate = EventRequiredPermission::where('category_id', $this->current_category->id)
                    ->where('permission_required', $row['permission_required'])
                    ->when(!empty($row['id']), function ($q) use ($row) {
                        $q->where('id', '!=', $row['id']);
                    })
                    ->exists();

                if ($duplicate) {
                    $this->rowErrors[$index]['permission_required'] = 'This permission already exists.';
                    continue;
                }

                // 3️⃣ Save
                EventRequiredPermission::updateOrCreate(
                    ['id' => $row['id'] ?? null],
                    [
                        'category_id' => $this->current_category->id,
                        'permission_required' => $row['permission_required'],
                        'issuing_authority' => $row['issuing_authority'] ?? '',
                        'status' => $row['status'] ?? 1,
                    ]
                );
            }


            // if ANY errors exist → do NOT close modal
            if (!empty($this->rowErrors)) {
                DB::rollBack();
                $this->dispatch(
                    'toastr:error',
                    message: "Fix errors before saving."
                );
                return;
            }
            DB::commit();
            $this->dispatch('toastr:success', message: 'Permissions updated successfully!');
            $this->showPermissionModal = false;
        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatch(
                'toastr:error',
                message: "Something went wrong while saving."
            );
            throw $e; // optional: keeps debugging ability
        }
    }

    public function removeRow($index)
    {
        if(isset($this->permissionRows[$index]['id'])){
            $id = $this->permissionRows[$index]['id'];
            EventRequiredPermission::where('id', $id)->delete();
            $this->dispatch('toastr:success', message: 'Permission removed successfully!');
        }
        unset($this->permissionRows[$index]);
        $this->permissionRows = array_values($this->permissionRows);
    }

    public function openPermissionModal($category_id)
    {
        $this->current_category = EventCategory::findOrFail($category_id);

        $this->permissionRows = EventRequiredPermission::where('category_id', $category_id)
            ->get()
            ->map(fn($r) => [
                'id' => $r->id,
                'permission_required' => $r->permission_required,
                'issuing_authority' => $r->issuing_authority,
                'status' => (bool) $r->status,
            ])
            ->toArray();

        $this->showPermissionModal = true;
    }
    public function render()
    {
        $categories = EventCategory::when($this->search, function ($query) {
                $query->where('name', 'like', "%{$this->search}%");
            })
            ->orderBy('name', 'asc')
            ->get();

        return view('livewire.event-category-crud', [
            'categories' => $categories
        ])->layout('layouts.admin');
    }
}

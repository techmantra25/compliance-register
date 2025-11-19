<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Zone;
use App\Models\District;
use Illuminate\Support\Facades\DB;

class ZoneCrud extends Component
{
    public $zone_id, $name, $districts = [], $reasons;
    public $isEdit = false;
    public $search = '';
    public $allDistricts;

    protected $rules = [
        'name' => 'required|string|max:255',
        'districts' => 'required|array|min:1',
        'reasons' => 'nullable|string|max:1000',
    ];

    public function mount()
    {
        $this->allDistricts = District::orderBy('name_en')->get();
    }
    public function DistrictUpdate($value){
       $selectedDistricts = is_array($value) ? $value : [$value];

        // Base query (exclude self when editing)
        $zones = Zone::query();
        if ($this->isEdit && $this->zone_id) {
            $zones->where('id', '!=', $this->zone_id);
        }

        // Get all existing districts from other zones
        $existingDistricts = $zones->pluck('districts')
            ->filter()
            ->flatMap(function ($item) {
                return explode(',', $item);
            })
            ->unique()
            ->toArray();

        // Find conflicts
        $conflicts = array_intersect($selectedDistricts, $existingDistricts);

        // if (!empty($conflicts)) {
        //     // Get district names for nicer message
        //     $conflictNames = District::whereIn('id', $conflicts)->pluck('name_en')->implode(', ');
        //         $this->dispatch('toastr:error', message: "⚠️ These districts are already assigned to another zone: {$conflictNames}");

        //     // Optional: remove them from selected
        //     $this->districts = array_diff($selectedDistricts, $conflicts);
        // } else {
            // Everything OK
            $this->districts = $selectedDistricts;
        // }
    }

    public function resetInputFields()
    {
        $this->reset(['zone_id', 'name', 'districts', 'reasons','search']);
        $this->isEdit = false;
        $this->dispatch('ResetForm');
    }

    public function save()
    {
        $this->isEdit ? $this->updateZone() : $this->storeZone();
    }

    protected function storeZone()
    {
        $this->validate();

        Zone::create([
            'name' => $this->name,
            'districts' => implode(',', $this->districts),
            'reasons' => $this->reasons,
        ]);

        $this->dispatch('toastr:success', message: 'Zone added successfully!');
        $this->resetInputFields();
    }

    protected function updateZone()
    {
        $this->validate();

        $zone = Zone::findOrFail($this->zone_id);
        $zone->update([
            'name' => $this->name,
            'districts' => implode(',', $this->districts),
            'reasons' => $this->reasons,
        ]);

        $this->dispatch('toastr:success', message: 'Zone updated successfully!');
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $zone = Zone::findOrFail($id);
        $this->zone_id = $id;
        $this->name = $zone->name;
        $this->districts = explode(',', $zone->districts);
        $this->reasons = $zone->reasons;
        $this->isEdit = true;
    }

    public function confirmDelete($id)
    {
        $this->dispatch('showConfirm', ['itemId' => $id]);
    }

    public function delete($id)
    {
        Zone::findOrFail($id)->delete();
        $this->dispatch('toastr:success', message: 'Zone deleted successfully!');
    }

    public function filterZones($term)
    {
        $this->search = $term;
    }

    public function render()
    {
        $zones = Zone::when($this->search, function ($query) {
            $search = $this->search;

            $query->where('zones.name', 'like', "%{$search}%")
                ->orWhere('zones.reasons', 'like', "%{$search}%")
                ->orWhereExists(function ($sub) use ($search) {
                    $sub->select(DB::raw(1))
                        ->from('districts')
                        ->whereRaw("FIND_IN_SET(districts.id, zones.districts)")
                        ->where('districts.name_en', 'like', "%{$search}%");
                });
        })
        ->orderBy('zones.name')
        ->get()
        ->map(function ($zone) {
            $zone->district_list = District::whereIn('id', explode(',', $zone->districts))
                ->pluck('name_en')
                ->toArray();
            return $zone;
        });

        return view('livewire.zone-crud', [
            'zones' => $zones,
        ])->layout('layouts.admin');
    }
}

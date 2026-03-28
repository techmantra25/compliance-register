<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Zone;
use App\Models\Admin;
use App\Models\District;

class UpdateProfile extends Component
{
    public $name, $mobile, $email, $role, $zone_id;
    public $zoneList;

    public function mount(){
        $admin = Auth::user();
        
        $this->name  = $admin->name;
        $this->email = $admin->email;
        $this->mobile = $admin->mobile;
        $this->zone_id = $admin->zone_id;
        $this->role = $admin->role;
    }

    protected function generateEmployeeCode($name, $ignoreId = null)
    {
        $words = preg_split('/\s+/', trim($name));
        $cleanName = strtoupper(preg_replace('/[^A-Za-z]/', '', $name));

        // Step 1: Base generation
        if (count($words) === 1) {
            // Single word → first 3 letters
            $base = strtoupper(substr($words[0], 0, 3));
        } else {
            // Multi word → initials
            $initials = '';
            foreach ($words as $word) {
                $initials .= strtoupper(substr($word, 0, 1));
            }

            if (strlen($initials) < 3) {
                // Take extra letters from FIRST word (correct fix)
                $firstWord = strtoupper($words[0]);
                $extra = substr($firstWord, 1, 3 - strlen($initials));

                $base = $initials . $extra;
            } else {
                $base = substr($initials, 0, 3);
            }
        }

        // Step 2: Check uniqueness
        $query = Admin::where('code', $base);
        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        if (!$query->exists()) {
            return $base;
        }

        // Step 3: Expand from full name
        $cleanName = strtoupper(preg_replace('/[^A-Za-z]/', '', $name));

        for ($i = strlen($base); $i < strlen($cleanName); $i++) {
            $newCode = substr($cleanName, 0, $i + 1);

            $query = Admin::where('code', $newCode);
            if ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            }

            if (!$query->exists()) {
                return $newCode;
            }
        }

        // Step 4: fallback
        foreach (range('A', 'Z') as $char) {
            $newCode = $base . $char;

            $query = Admin::where('code', $newCode);
            if ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            }

            if (!$query->exists()) {
                return $newCode;
            }
        }

        return $base . rand(100, 999);
    }
    
    public function updateProfile()
    {
        $this->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:users,email,' . Auth::id(),
            'zone_id'  => 'nullable',
            'role'   => 'required|string',

             'mobile' => in_array($this->role, ['admin', 'legal_associate'])
                        ? ['required', 'digits:10']
                        : ['nullable'],
                ], [
                    'mobile.required' => 'WhatsApp number is required for this role.',
                    'mobile.digits'   => 'WhatsApp number must be exactly 10 digits.',
                        ]);

        $admin = Auth::user();


        $code = $admin->code;

        // Regenerate only if name changed OR code missing
        if ($admin->name !== $this->name || is_null($admin->code)) {
            $code = $this->generateEmployeeCode($this->name, $admin->id);
        }

        $admin->update([
            'name'   => $this->name,
            'email'  => $this->email,
            'mobile' => $this->mobile,
            'zone_id'  => $this->zone_id,
            'role'   => $this->role,
            'code'  => $code,
        ]);

        session()->flash('success', 'Profile updated successfully!');
    }


    public function render()
    {
        $this->zoneList = Zone::select('id', 'name')->orderBy('name')->get();
        return view('livewire.update-profile')->layout('layouts.admin');
    }
}

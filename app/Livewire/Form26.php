<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Candidate;
use App\Models\NominationForm;
use Livewire\WithFileUploads;

class Form26 extends Component
{
    use WithFileUploads;

    public $state = 'WEST BENGAL';
    public $assembly_id;
    public $candidate;
    public $relation_type;
    public $relation_name;
    public $age;
    public $enrolled_constituency_name;
    public $constituency_serial_no;
    public $constituency_part_no;
    public $address;
    public $phone_no;
    public $alternative_phone_no;
    public $email_id;
    public $whatsapp_no;
    public $facebook_account;
    public $twitter_account;
    public $linked_in;
    public $pan_details = [];
    public $candidate_occupation;
    public $spouse_occupation;
    public $movable_assets = [];
    public $immovable_assets = [];
    public $political_party_name = 'AITC';
    public $source_of_incomes = []; 
    public $financial_years = [];

    public $loan_types = [
        [
            'type' => '',
            'holders' => [
                [
                    'holder' => '',
                    'description' => '',
                    'amount' => '',
                ],
            ],
        ],
    ];

    public $educational_qualifications = [
        [
            'degree' => '',
            'university' => '',
            'year' => '',
        ],
    ];

    public $government_dues = [
        [
            'type' => '',
            'holders' => [
                [
                    'holder' => '',
                    'description' => '',
                    'amount' => '',
                ]
            ]
        ]
    ];

    public function mount($id)
    {
        $currentYear = now()->year;

        if (now()->month < 1) {
            $currentYear--;
        }

        for ($i = 1; $i <= 5; $i++) {
            $startYear = $currentYear - $i;
            $endYear = substr($startYear + 1, -2);
            $this->financial_years[] = $startYear . '-' . $endYear;
        }
        $this->candidate = Candidate::findOrFail($id);
        $this->assembly_id = $this->candidate->assembly->id;

        $this->existingForm = NominationForm::where('candidate_id', $id)
            ->where('form_type', 'form_26')
            ->first()
            ?? NominationForm::where('candidate_id', $id)->first();

        if ($this->existingForm) {
            $this->hydrateFromForm($this->existingForm);
        }

        // PAN
        if (empty($this->pan_details)) {
            $this->addPanRow();
        }
        // movable Assets
        if (empty($this->movable_assets)) {
            $this->addMovableAssetType();
        }

        // immovable Assets
        if (empty($this->immovable_assets)) {
            $this->addImmovableAssetType();
        }

        // loan
        if (empty($this->loan_types)) {
            $this->addLoanType();
        }
        // Government dues
        if (empty($this->government_dues)) {
            $this->addGovernmentDueType();
        }
        
    }

    public function addMovableAssetType()
    {
        $this->movable_assets[] = [
            'type' => '',
            'holders' => [
                [
                    'holder' => '',
                    'description' => '',
                    'amount' => '',
                ]
            ],
        ];
    }
    
    public function addMovableHolder($index)
    {
        $this->movable_assets[$index]['holders'][] = [
            'holder' => '',
            'description' => '',
            'amount' => '',
        ];
    }

    public function removeMovableHolder($aIndex, $hIndex)
    {
        unset($this->movable_assets[$aIndex]['holders'][$hIndex]);
        $this->movable_assets[$aIndex]['holders'] =
            array_values($this->movable_assets[$aIndex]['holders']);
    }

    public function removeMovableAssetType($index)
    {
        unset($this->movable_assets[$index]);
        $this->movable_assets = array_values($this->movable_assets);
    }

    public function addImmovableAssetType()
    {
        $this->immovable_assets[] = [
            'type' => '',
            'description' => '',
            'holders' => [
                [
                    'holder' => '',
                    'details' => '',
                    'amount' => '',
                ]
            ],
        ];
    }

    public function addImmovableHolder($index)
    {
        $this->immovable_assets[$index]['holders'][] = [
            'holder' => '',
            'details' => '',
            'amount' => '',
        ];
    }

    public function removeImmovableHolder($aIndex, $hIndex)
    {
        unset($this->immovable_assets[$aIndex]['holders'][$hIndex]);
        $this->immovable_assets[$aIndex]['holders'] =
            array_values($this->immovable_assets[$aIndex]['holders']);
    }

    public function removeImmovableAssetType($index)
    {
        unset($this->immovable_assets[$index]);
        $this->immovable_assets = array_values($this->immovable_assets);
    }

    public function getImmovableDescriptionOptions($type)
    {
        return match ($type) {

            'agricultural' => [
                'location_survey_number' => 'Location(s) Survey number(s)',
                'area_sqft' => 'Area (total measurement in acres)',
                'inherited' => 'Whether inherited property (Yes or No)',
                'purchase_date' => 'Date of purchase in case of self - acquired property',
                'purchase_cost' => 'Cost of Land (in case of purchase) at the time of purchase',
                'investment' => 'Any Invest ment on the land by way of develop ment, construction etc.',
                'market_value' => 'Approximate Current market value',
            ],

            'non_agricultural' => [
                'location_survey_number' => 'Location(s) Survey number(s)',
                'area_sqft' => 'Area (total measurement in sq. ft.)',
                'inherited' => 'Whether inherited property (Yes or No)',
                'purchase_date' => 'Date of purchase in case of self-acquired property',
                'purchase_cost' => 'Cost of Land (in case of purchase) at the time of purchase',
                'investment' => 'Any Investment on the land by way of develop ment, construction etc.',
                'market_value' => 'Approximate current market value',
            ],

            'commercial' => [
                'location_survey_number' => 'Location(s) Survey number(s)',
                'area_sqft' => 'Area (total measurement in sq. ft.)',
                'builtup_area' => 'Built-up Area (total measurement in sq.ft.)',
                'inherited' => 'Whether inherited property (Yes or No)',
                'purchase_date' => 'Date of purchase in case of self-acquired property',
                'purchase_cost' => 'Cost of property (in case of purchase) at the time of purchase',
                'investment' => 'Any Investment on the property by way of development, construction etc.',
                'market_value' => 'Approximate current market value',
            ],

            'residential' => [
                'location_survey_number' => 'Location(s) Survey number(s)',
                'area_sqft' => 'Area (Total measurement in sq. ft)',
                'builtup_area' => 'Built up Area (Total measurement in sq. ft.)',
                'inherited' => 'Whether inherited property (Yes or No)',
                'purchase_date' => 'Date of purchase in case of self–acquired property',
                'purchase_cost' => 'Cost of property (in case of purchase) at the time of purchase',
                'investment' => 'Any Investment on the land by way of develop ment, construction etc.',
                'market_value' => 'Approximate current market value',
            ],

            default => [],
        };
    }

    public function typeChanged($index)
    {
        // Reset description when type changes
        $this->immovable_assets[$index]['description'] = '';
    }

    public function getAssetTypeTotal($index)
    {
        return collect($this->movable_assets[$index]['holders'])
            ->sum(function ($holder) {
                return (float) ($holder['amount'] ?? 0);
            });
    }

    private function hydrateFromForm(NominationForm $form)
    {
        $this->relation_type = $form->relation_type;
        $this->relation_name = $form->relation_name;
        $this->age = $form->age;
        $this->address = $form->postal_address;

        $this->enrolled_constituency_name = $form->constituency_where_enrolled;
        $this->constituency_serial_no = $form->candidate_serial_no;
        $this->constituency_part_no = $form->candidate_part_no;

        $phones = $this->decode($form->contact_phone_nos);
        $this->phone_no = $phones['primary'] ?? null;
        $this->alternative_phone_no = $phones['alternate'] ?? null;
        $this->email_id = $form->email_id;

        $social = $this->decode($form->social_media_accounts);
        $this->whatsapp_no = $social['whatsapp_no'] ?? null;
        $this->facebook_account = $social['facebook_account'] ?? null;
        $this->twitter_account = $social['twitter_account'] ?? null;
        $this->linked_in = $social['linked_in'] ?? null;

        $this->pan_details = $this->mergePanAndIncome(
            $this->decode($form->pan_details),
            $this->decode($form->last_five_year_incomes)
        );

        $this->movable_assets = $this->decode($form->movable_assets);
        $this->immovable_assets = $this->decode($form->immovable_assets);

        $loans = $this->decode($form->loans_and_govt_dues);
        $this->loan_types = $loans['loans'] ?? $this->loan_types;
        $this->government_dues = $loans['government_dues'] ?? [];

        $this->candidate_occupation = $form->candidate_occupation;
        $this->spouse_occupation = $form->spouse_occupation;
        $this->educational_qualifications =
            $this->decode($form->highest_educational_qualification)
            ?: $this->educational_qualifications;

        $this->source_of_incomes =
            $this->decode($form->source_of_incomes)
            ?: $this->source_of_incomes;
    }

    private function mergePanAndIncome($panOnly, $incomeOnly)
    {
        $panOnly = $panOnly ?? [];
        $incomeOnly = $incomeOnly ?? [];

        foreach ($panOnly as $i => &$pan) {
            $defaultIncome = array_fill_keys($this->financial_years, '');
            $pan['income'] = $incomeOnly[$i]['income'] ?? $defaultIncome;
        }

        return $panOnly;
    }

    protected $rules = [

        'relation_type' => 'required|in:son,daughter,wife',
        'relation_name' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'age' => 'required|integer|min:18|max:120',

        'enrolled_constituency_name' => 'required|string|max:255',
        'constituency_serial_no' => 'required|string|max:255',
        'constituency_part_no' => 'required|string|max:255',

        'phone_no' => 'nullable|digits_between:10,15',
        'alternative_phone_no' => 'nullable|digits_between:10,15',
        'email_id' => 'nullable|email',

        'whatsapp_no' => 'nullable|digits_between:10,15',
        'facebook_account' => 'nullable|string',
        'twitter_account' => 'nullable|string',
        'linked_in' => 'nullable|string',

        'pan_details' => 'required|array|min:1',
        'pan_details.*.type' => 'nullable|string',
        'pan_details.*.name' => 'nullable|string',
        'pan_details.*.pan' => 'nullable|string',

        'movable_assets' => 'nullable|array',
        'movable_assets.*.type' => 'nullable|string',
        'movable_assets.*.holders' => 'nullable|array',
        'movable_assets.*.holders.*.holder' => 'nullable|in:self,spouse,huf,dependent_1,dependent_2,dependent_3',
        'movable_assets.*.holders.*.description' => 'nullable|string',
        'movable_assets.*.holders.*.amount' => 'nullable|numeric',

        'immovable_assets' => 'nullable|array',
        'immovable_assets.*.type' => 'nullable|string',
        'immovable_assets.*.description' => 'nullable|string',
        'immovable_assets.*.holders' => 'nullable|array',
        'immovable_assets.*.holders.*.holder' => 'nullable|string',
        'immovable_assets.*.holders.*.details' => 'nullable|string',
        'immovable_assets.*.holders.*.amount' => 'nullable|numeric',
      
        'loan_types' => 'nullable|array',
        'loan_types.*.type' => 'nullable|string',
        'loan_types.*.holders' => 'nullable|array',
        'loan_types.*.holders.*.holder' => 'nullable|string',
        'loan_types.*.holders.*.description' => 'nullable|string',
        'loan_types.*.holders.*.amount' => 'nullable|numeric',

        'government_dues.*.type' => 'nullable|string',
        'government_dues.*.holders' => 'nullable|array',
        'government_dues.*.holders.*.holder' => 'nullable|string',
        'government_dues.*.holders.*.description' => 'nullable|string',
        'government_dues.*.holders.*.amount' => 'nullable|numeric',

        'candidate_occupation' => 'nullable|string',
        'spouse_occupation' => 'nullable|string',
        'source_of_incomes.self' => 'nullable|string',
        'source_of_incomes.spouse' => 'nullable|string',
        'source_of_incomes.dependents' => 'nullable|string',

        'educational_qualifications' => 'nullable|array',
        'educational_qualifications.*.degree' => 'nullable|string|max:255',
        'educational_qualifications.*.university' => 'nullable|string|max:255',
        'educational_qualifications.*.year' => 'nullable|digits:4',
    ];

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            $selfPan = collect($this->pan_details ?? [])
                ->first(function ($row) {
                    return strtolower($row['type'] ?? '') === 'self';
                });

            if (!$selfPan) {
                $validator->errors()->add(
                    'pan_self_required',
                    'PAN details for Self are mandatory.'
                );
                return;
            }

            if (empty($selfPan['pan'])) {
                $validator->errors()->add(
                    'pan_details',
                    'PAN number for Self is mandatory.'
                );
            }

        });
    }

    private function decode($value)
    {
        if (is_array($value)) return $value;
        if (is_string($value)) return json_decode($value, true) ?? [];
        return [];
    }

    public function addLoanType()
    {
        $this->loan_types[] = [
            'type' => '',
            'holders' => [
                [
                    'holder' => '',
                    'description' => '',
                    'amount' => '',
                ],
            ],
        ];
    }

    public function removeLoanType($index)
    {
        unset($this->loan_types[$index]);
        $this->loan_types = array_values($this->loan_types);
    }

    public function addLoanHolder($index)
    {
        $this->loan_types[$index]['holders'][] = [
            'holder' => '',
            'description' => '',
            'amount' => '',
        ];
    }

    public function removeLoanHolder($tIndex, $hIndex)
    {
        unset($this->loan_types[$tIndex]['holders'][$hIndex]);
        $this->loan_types[$tIndex]['holders'] =
            array_values($this->loan_types[$tIndex]['holders']);
    }

    public function addGovernmentDueType()
    {
        $this->government_dues[] = [
            'type' => '',
            'holders' => [
                [
                    'holder' => '',
                    'description' => '',
                    'amount' => '',
                ]
            ]
        ];
    }

    public function removeGovernmentDueType($index)
    {
        unset($this->government_dues[$index]);
        $this->government_dues = array_values($this->government_dues);
    }

    public function addGovernmentDueHolder($index)
    {
        $this->government_dues[$index]['holders'][] = [
            'holder' => '',
            'description' => '',
            'amount' => '',
        ];
    }

    public function removeGovernmentDueHolder($dIndex, $hIndex)
    {
        unset($this->government_dues[$dIndex]['holders'][$hIndex]);

        $this->government_dues[$dIndex]['holders'] =
            array_values($this->government_dues[$dIndex]['holders']);
    }


    public function addPanRow()
    {
        $this->pan_details[] = [
            'type' => '',
            'name' => '',
            'pan' => '',
            'last_filed_year' => '2025-26',

            'income' => array_fill_keys($this->financial_years, ''),    
        ];
    }

    public function updateIncomeYears($index)
    {
        $year = $this->pan_details[$index]['last_filed_year'];

        if (!$year) return;

        $startYear = (int) substr($year, 0, 4);

        $years = [];

        for ($i = 0; $i < 5; $i++) {
            $y = $startYear - $i;
            $years[] = $y . '-' . substr($y + 1, -2);
        }

        $oldIncome = $this->pan_details[$index]['income'] ?? [];

        $newIncome = [];

        foreach ($years as $fy) {
            $newIncome[$fy] = $oldIncome[$fy] ?? '';
        }

        // overwrite with only 5 correct years
        $this->pan_details[$index]['income'] = $newIncome;
    }

    public function removePanRow($index)
    {
        unset($this->pan_details[$index]);
        $this->pan_details = array_values($this->pan_details);
    }

    public function addQualification()
    {
        $this->educational_qualifications[] = [
            'degree' => '',
            'university' => '',
            'year' => '',
        ];
    }

    public function removeQualification($index)
    {
        unset($this->educational_qualifications[$index]);
        $this->educational_qualifications = array_values($this->educational_qualifications);
    }

    public function save()
    {
        $validator = validator($this->all(), $this->rules);

        $this->withValidator($validator);

        $validator->validate();

        $panOnly = [];
        $incomeOnly = [];

        foreach ($this->pan_details as $index => $row) {

            $lastYear = $row['last_filed_year'];
            $startYear = (int) substr($lastYear, 0, 4);

            $validYears = [];

            for ($i = 0; $i < 5; $i++) {
                $y = $startYear - $i;
                $validYears[] = $y . '-' . substr($y + 1, -2);
            }

            $filteredIncome = [];

            foreach ($validYears as $fy) {
                $filteredIncome[$fy] = $row['income'][$fy] ?? '';
            }

            $panOnly[] = [
                'type' => $row['type'],
                'name' => $row['name'],
                'pan' => $row['pan'],
                'last_filed_year' => $row['last_filed_year'],
            ];

            $incomeOnly[] = [
                'income' => $filteredIncome
            ];
        }

        $form = NominationForm::updateOrCreate(
            [
                'candidate_id' => $this->candidate->id,
                'assembly_id' => $this->assembly_id,
                'form_type' => 'form_26',
            ],
            [
                'state' => $this->state,
                'relation_type' => $this->relation_type,
                'relation_name' => $this->relation_name,
                'age' => $this->age,
                'postal_address' => $this->address,
                'political_party_name' => $this->political_party_name,

                'constituency_where_enrolled' => $this->enrolled_constituency_name,
                'candidate_serial_no' => $this->constituency_serial_no,
                'candidate_part_no' => $this->constituency_part_no,

                'contact_phone_nos' => json_encode([
                    'primary' => $this->phone_no,
                    'alternate' => $this->alternative_phone_no,
                ]),

                'email_id' => $this->email_id,

                'social_media_accounts' => json_encode([
                    'whatsapp_no' => $this->whatsapp_no,
                    'facebook_account' => $this->facebook_account,
                    'twitter_account' => $this->twitter_account,
                    'linked_in' => $this->linked_in,
                ]),

                'pan_details' => json_encode($panOnly),
                'last_five_year_incomes' => json_encode($incomeOnly),

                'movable_assets' => json_encode($this->movable_assets),
                'immovable_assets' => json_encode($this->immovable_assets),

                'loans_and_govt_dues' => json_encode([
                    'loans' => $this->loan_types,
                    'government_dues' => $this->government_dues,
                ]),

                'candidate_occupation' => $this->candidate_occupation,
                'spouse_occupation' => $this->spouse_occupation,
                'source_of_incomes' => json_encode(
                    is_array($this->source_of_incomes)
                        ? array_filter($this->source_of_incomes)
                        : []
                ),

                'highest_educational_qualification'
                    => json_encode($this->educational_qualifications),
            ]
        );

        session()->flash('success', 'FORM 26 saved successfully.');

        return redirect()->route(
            'admin.candidates.form26.preview',
            $form->id 
        );
    }

    public function render()
    {
        return view('livewire.form_26')
            ->layout('layouts.admin');
    }
}

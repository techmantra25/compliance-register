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
    public $pan_details = [];
    public $candidate_occupation;
    public $spouse_occupation;
    public $asset_holders = [];
    public $immovable_assets = [];
    public $political_party_name = 'AJP';
    public $source_of_incomes = []; 


    public $loan_holders = [
        [
            'holder' => '',
            'loans' => [
                [
                    'type' => '',
                    'name' => '',
                    'amount' => '',
                    'nature' => '',
                ],
            ],
        ],
    ];

    public $educational_qualifications = [
        [
            'level' => 'Master',
            'degree' => '',
            'university' => '',
            'year' => '',
        ],
        [
            'level' => 'Bachelor',
            'degree' => '',
            'university' => '',
            'year' => '',
        ],
        [
            'level' => 'Higher Secondary (12th)',
            'degree' => '',
            'university' => '',
            'year' => '',
        ],
        [
            'level' => 'Secondary (10th)',
            'degree' => '',
            'university' => '',
            'year' => '',
        ],
    ];

    public $government_dues = [
        [
            'holder' => '',
            'income_tax' => '',
            'gst' => '',
            'property_tax' => '',
            'other_dues' => '',
            'dispute_details' => '',
        ],
    ];

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

        $this->pan_details = $this->mergePanAndIncome(
            $this->decode($form->pan_details),
            $this->decode($form->last_five_year_incomes)
        );

        $this->asset_holders = $this->decode($form->movable_assets);
        $this->immovable_assets = $this->decode($form->immovable_assets);

        $loans = $this->decode($form->loans_and_govt_dues);
        $this->loan_holders = $loans['loans'] ?? [];
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
            $pan['income'] = $incomeOnly[$i]['income'] ?? [
                '2019-20' => '',
                '2018-19' => '',
                '2017-18' => '',
                '2016-17' => '',
                '2015-16' => '',
            ];
        }

        return $panOnly;
    }

    public function mount($id)
    {
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

        // Movable Assets
        if (empty($this->asset_holders)) {
            $this->addAssetHolder();
        }

        // Immovable Assets
        if (empty($this->immovable_assets)) {
            $this->addImmovableHolder();
        }

        // Loans
        if (empty($this->loan_holders)) {
            $this->addLoanHolder();
        }

        // Government dues
        if (empty($this->government_dues)) {
            $this->addGovernmentDue();
        }
    }

    protected $rules = [

        'relation_type' => 'nullable|in:son,daughter,wife',
        'relation_name' => 'nullable|string|max:255',
        'address' => 'nullable|string|max:255',
        'age' => 'nullable|integer|min:18|max:120',

        'enrolled_constituency_name' => 'nullable|string|max:255',
        'constituency_serial_no' => 'nullable|string|max:255',
        'constituency_part_no' => 'nullable|string|max:255',

        'phone_no' => 'nullable|digits_between:10,15',
        'alternative_phone_no' => 'nullable|digits_between:10,15',
        'email_id' => 'nullable|email',

        'whatsapp_no' => 'nullable|digits_between:10,15',
        'facebook_account' => 'nullable|string',
        'twitter_account' => 'nullable|string',

        'pan_details' => 'nullable|array',
        'pan_details.*.type' => 'nullable|string',
        'pan_details.*.name' => 'nullable|string',
        'pan_details.*.pan' => 'nullable|alpha_num|size:10',

        'asset_holders' => 'nullable|array',
        'asset_holders.*.holder' => 'nullable|in:self,spouse,huf,dependent',
        'asset_holders.*.assets' => 'nullable|array',
        'asset_holders.*.assets.*.type' => 'nullable|string',
        'asset_holders.*.assets.*.description' => 'nullable|string',
        'asset_holders.*.assets.*.amount' => 'nullable|numeric',

        'loan_holders' => 'nullable|array',
        'loan_holders.*.holder' => 'nullable|string',
        'loan_holders.*.loans' => 'nullable|array',
        'loan_holders.*.loans.*.type' => 'nullable|string',
        'loan_holders.*.loans.*.name' => 'nullable|string',
        'loan_holders.*.loans.*.amount' => 'nullable|numeric',

        'government_dues' => 'nullable|array',
        'government_dues.*.holder' => 'nullable|string',

        'candidate_occupation' => 'nullable|string',
        'spouse_occupation' => 'nullable|string',
        'source_of_incomes.self' => 'nullable|string',
        'source_of_incomes.spouse' => 'nullable|string',
        'source_of_incomes.dependents' => 'nullable|string',

        'educational_qualifications' => 'nullable|array',
        'educational_qualifications.*.level' => 'nullable|string',
        'educational_qualifications.*.degree' => 'nullable|string|max:255',
        'educational_qualifications.*.university' => 'nullable|string|max:255',
        'educational_qualifications.*.year' => 'nullable|digits:4',
    ];

    private function decode($value)
    {
        if (is_array($value)) return $value;
        if (is_string($value)) return json_decode($value, true) ?? [];
        return [];
    }


    public function addAssetHolder()
    {                                           
        $this->asset_holders[] = [
            'holder' => '',
            'assets' => [
                [
                    'type' => '',
                    'description' => '',
                    'amount' => '',
                ]
            ],
        ];
    }   
    public function addAssetRow($holderIndex)
    {
        $this->asset_holders[$holderIndex]['assets'][] = [
            'type' => '',
            'description' => '',
            'amount' => '',
        ];
    }

    public function removeAssetRow($holderIndex, $assetIndex)
    {
        unset($this->asset_holders[$holderIndex]['assets'][$assetIndex]);
        $this->asset_holders[$holderIndex]['assets']
            = array_values($this->asset_holders[$holderIndex]['assets']);
    }

    public function removeAssetHolder($index)
    {
        unset($this->asset_holders[$index]);
        $this->asset_holders = array_values($this->asset_holders);
    }

    public function addLoanHolder()
    {
        $this->loan_holders[] = [
            'holder' => '',
            'loans' => [
                [
                    'type' => '',
                    'name' => '',
                    'amount' => '',
                    'nature' => '',
                ],
            ],
        ];
    }

    public function addLoanRow($hIndex)
    {
        $this->loan_holders[$hIndex]['loans'][] = [
            'type' => '',
            'name' => '',
            'amount' => '',
            'nature' => '',
        ];
    }

    public function removeLoanRow($hIndex, $lIndex)
    {
        unset($this->loan_holders[$hIndex]['loans'][$lIndex]);
        $this->loan_holders[$hIndex]['loans'] =
            array_values($this->loan_holders[$hIndex]['loans']);
    }

    public function removeLoanHolder($index)
    {
        unset($this->loan_holders[$index]);
        $this->loan_holders = array_values($this->loan_holders);
    }

    public function addGovernmentDue()
    {
        $this->government_dues[] = [
            'holder' => '',
            'income_tax' => '',
            'gst' => '',
            'property_tax' => '',
            'other_dues' => '',
            'dispute_details' => '',
        ];
    }

    public function removeGovernmentDue($index)
    {
        unset($this->government_dues[$index]);
        $this->government_dues = array_values($this->government_dues);
    }


    public function addPanRow()
    {
        $this->pan_details[] = [
            'type' => '',
            'name' => '',
            'pan' => '',
            'last_filed_year' => '',

            'income' => [
                '2019-20' => '',
                '2018-19' => '',
                '2017-18' => '',
                '2016-17' => '',
                '2015-16' => '',
            ],
        ];
    }

    public function removePanRow($index)
    {
        unset($this->pan_details[$index]);
        $this->pan_details = array_values($this->pan_details);
    }

    public function addImmovableHolder()
    {
        $this->immovable_assets[] = [
            'holder' => '',
            'groups' => [$this->emptyGroup()],
        ];
    }

    public function addImmovableGroup($hIndex)
    {
        $this->immovable_assets[$hIndex]['groups'][] = $this->emptyGroup();
    }

    private function emptyGroup()
    {
        return [
            'agricultural' => $this->emptyImmovableRow(),
            'non_agricultural' => $this->emptyImmovableRow(),
            'commercial' => $this->emptyImmovableRow(),
            'residential' => $this->emptyImmovableRow(),
            'others' => [
                'desc' => '',
                'cost' => '',
            ],
        ];
    }

    private function emptyImmovableRow()
    {
        return [
            'location' => '',
            'area' => '',
            'inherited' => '',
            'purchase_date' => '',
            'purchase_cost' => '',
            'investment_made' => '',
            'current_value' => '',
        ];
    }

    public function save()
    {
        $this->validate();

        $panOnly = [];
        $incomeOnly = [];

        foreach ($this->pan_details as $pan) {
            $incomeOnly[] = [
                'type' => $pan['type'] ?? null,
                'name' => $pan['name'] ?? null,
                'income' => $pan['income'] ?? [],
            ];

            $panOnly[] = [
                'type' => $pan['type'] ?? null,
                'name' => $pan['name'] ?? null,
                'pan' => $pan['pan'] ?? null,
                'last_filed_year' => $pan['last_filed_year'] ?? null,
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
                ]),

                'pan_details' => json_encode($panOnly),
                'last_five_year_incomes' => json_encode($incomeOnly),

                'movable_assets' => json_encode($this->asset_holders),
                'immovable_assets' => json_encode($this->immovable_assets),

                'loans_and_govt_dues' => json_encode([
                    'loans' => $this->loan_holders,
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

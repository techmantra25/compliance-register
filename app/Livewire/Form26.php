<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Candidate;
use App\Models\NominationForm;
use Livewire\WithFileUploads;

class Form26 extends Component
{
    use WithFileUploads;

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
    public $occupation;
    public $sources_of_income;
    public $asset_holders = [];
    public $immovable_assets = [];

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

        $phones = json_decode($form->contact_phone_nos, true) ?? [];
        $this->phone_no = $phones['primary'] ?? '';
        $this->alternative_phone_no = $phones['alternate'] ?? '';

        $this->email_id = $form->email_id;

        $social = json_decode($form->social_media_accounts, true) ?? [];
        $this->whatsapp_no = $social['whatsapp_no'] ?? '';
        $this->facebook_account = $social['facebook_account'] ?? '';
        $this->twitter_account = $social['twitter_account'] ?? '';

        // PAN + Income
        $this->pan_details = $this->mergePanAndIncome(
            json_decode($form->pan_details, true),
            json_decode($form->last_five_year_incomes, true)
        );

        // Assets
        $this->asset_holders = json_decode($form->movable_assets, true) ?? [];

        $this->immovable_assets = json_decode($form->immovable_assets, true) ?? [];

        $loans = json_decode($form->loans_and_govt_dues, true) ?? [];
        $this->loan_holders = $loans['loans'] ?? [];
        $this->government_dues = $loans['government_dues'] ?? [];

        $this->occupation = $form->candidate_occupation;
        $this->sources_of_income = $form->source_of_incomes;

        $this->educational_qualifications =
            json_decode($form->highest_educational_qualification, true)
            ?? $this->educational_qualifications;
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

        $this->existingForm = NominationForm::where('candidate_id', $id)
            ->where('form_type', 'form_26')
            ->first();

        if (!$this->existingForm) {
            $this->existingForm = NominationForm::where('candidate_id', $id)->first();
        }

        if ($this->existingForm) {

            $this->relation_type = $this->existingForm->relation_type;
            $this->relation_name = $this->existingForm->relation_name;
            $this->age = $this->existingForm->age;
            $this->address = $this->existingForm->postal_address;

            $this->enrolled_constituency_name = $this->existingForm->constituency_where_enrolled;
            $this->constituency_serial_no = $this->existingForm->candidate_serial_no;
            $this->constituency_part_no = $this->existingForm->candidate_part_no;

            $phones = json_decode($this->existingForm->contact_phone_nos, true);
            $this->phone_no = $phones['primary'] ?? null;
            $this->alternative_phone_no = $phones['alternate'] ?? null;

            $social = json_decode($this->existingForm->social_media_accounts, true);
            $this->whatsapp_no = $social['whatsapp_no'] ?? null;
            $this->facebook_account = $social['facebook_account'] ?? null;
            $this->twitter_account = $social['twitter_account'] ?? null;

            $this->pan_details = json_decode($this->existingForm->pan_details, true) ?? $this->pan_details;
            $this->asset_holders = json_decode($this->existingForm->movable_assets, true) ?? $this->asset_holders;
            $this->immovable_assets = json_decode($this->existingForm->immovable_assets, true) ?? $this->immovable_assets;

            $loansAndDues = json_decode($this->existingForm->loans_and_govt_dues, true);
            $this->loan_holders = $loansAndDues['loans'] ?? $this->loan_holders;
            $this->government_dues = $loansAndDues['government_dues'] ?? $this->government_dues;

            $this->occupation = $this->existingForm->candidate_occupation;
            $this->sources_of_income = $this->existingForm->source_of_incomes;

            $this->educational_qualifications =
                json_decode($this->existingForm->highest_educational_qualification, true)
                ?? $this->educational_qualifications;
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

        'occupation' => 'nullable|string',
        'sources_of_income' => 'nullable|string',

        'educational_qualifications' => 'nullable|array',
        'educational_qualifications.*.level' => 'nullable|string',
        'educational_qualifications.*.degree' => 'nullable|string|max:255',
        'educational_qualifications.*.university' => 'nullable|string|max:255',
        'educational_qualifications.*.year' => 'nullable|digits:4',
    ];


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
                'form_type' => 'form_26',
            ],
            [
                'relation_type' => $this->relation_type,
                'relation_name' => $this->relation_name,
                'age' => $this->age,
                'postal_address' => $this->address,

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

                'candidate_occupation' => $this->occupation,
                'source_of_incomes' => $this->sources_of_income,

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

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
    public $address;
    public $assembly_constituency_serial_no;
    public $assembly_constituency_part_no;
    public $phone_no;
    public $alternative_phone_no;
    public $candidate_epic_no;
    public $caste_tribe_details;
    public $proposer_epic;
    public $email_id;
    public $whatsapp_no;
    public $facebook_account;
    public $twitter_account;
    public $pan_details = [];
    public $loans_govt_dues;
    public $occupation;
    public $sources_of_income;
    public $highest_educational_qualification;
    public $asset_holders = [];
    public $immovable_assets = [];

    public function mount($id)
    {
        $this->candidate = Candidate::findOrFail($id);

        $this->pan_details = [
            [
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
            ]
        ];

        $this->asset_holders = [
            [
                'holder' => '',
                'assets' => [
                    [
                        'type' => '',
                        'description' => '',
                        'amount' => '',
                    ]
                ],
            ]
        ];

        $this->immovable_assets = [
            [
                'holder' => '',
                'groups' => [$this->emptyGroup()],
            ],
        ];
        
    }

    protected $rules = [
        'relation_type' => 'required|in:son,daughter,wife',
        'relation_name' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'phone_no' => 'required|digits_between:10,15',
        'alternative_phone_no' => 'nullable|digits_between:10,15',
        'candidate_epic_no' => 'required|string',
        'photograph' => 'required|image|max:2048',
        'caste_tribe_details' => 'required|string',
        'proposer_epic' => 'required|string',
        'email_id' => 'required|email',
        'whatsapp_no' => 'nullable||digits_between:10,15',
        'facebook_account' => 'nullable|string',
        'twitter_account' => 'nullable|string',
        'asset_holders' => 'required|array',
        'asset_holders.*.holder' => 'required|in:self,spouse,huf,dependent',
        'asset_holders.*.assets' => 'required|array',
        'asset_holders.*.assets.*.type' => 'required|string',
        'asset_holders.*.assets.*.description' => 'nullable|string',
        'asset_holders.*.assets.*.amount' => 'nullable|numeric',
        'loans_govt_dues' => 'required|string',
        'occupation' => 'required|string',
        'sources_of_income' => 'required|string',
        'highest_educational_qualification' => 'required|string',
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
            'agricultural' => $this->emptyRow(),
            'non_agricultural' => $this->emptyRow(),
            'commercial' => $this->emptyRow(),
            'residential' => $this->emptyRow(),
        ];
    }

    private function emptyRow()
    {
        return [
            'location' => '',
            'survey_no' => '',
            'area' => '',
            'inherited' => '',
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
                'type'   => $pan['type'] ?? null,
                'name'   => $pan['name'] ?? null,
                'income' => $pan['income'] ?? [],
            ];

            $panOnly[] = [
                'type'            => $pan['type'] ?? null,
                'name'            => $pan['name'] ?? null,
                'pan'             => $pan['pan'] ?? null,
                'last_filed_year' => $pan['last_filed_year'] ?? null,
            ];
        }
        NominationForm::create([
            'candidate_id' => $this->candidate->id,
            'relation_type' => $this->relation_type,
            'relation_name' => $this->relation_name,
            'postal_address' => $this->address,
            'candidate_serial_no' => $this->assembly_constituency_serial_no,
            'candidate_part_no' => $this->assembly_constituency_part_no,
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
            'last_5_year_incomes' => json_encode($incomeOnly),
            'movable_assets' => json_encode($this->asset_holders),
            'immovable_assets' => json_encode($this->immovable_assets),
            'loans_and_govt_dues' => $this->loans_govt_dues,
            'candidate_occupation' => $this->occupation,
            'source_of_incomes' => $this->sources_of_income,
            'highest_educational_qualification' => $this->highest_educational_qualification,
        ]);

        session()->flash('success', 'FORM 26 submitted successfully.');
    }

    public function render()
    {
        return view('livewire.form_26')
            ->layout('layouts.admin');
    }
}

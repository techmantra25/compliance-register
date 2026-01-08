<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Candidate;
use App\Models\NominationForm26;
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
    public $photograph;
    public $caste_tribe_details;
    public $proposer_epic;
    public $email_id;
    public $whatsapp_no;
    public $facebook_account;
    public $twitter_account;
    public $pan_details = [];
    public $last_5_yrs_income;
    public $loans_govt_dues;
    public $occupation;
    public $sources_of_income;
    public $highest_educational_qualification;

    public $movable_assets = [
        [
            'type' => '',
            'holder' => '',
            'description' => '',
            'amount' => '',
        ]
    ];

    public $immovable_assets = [
        'agricultural_land' => [
            [
                'holder' => 'self',
                'location' => '',
                'area' => '',
                'inherited' => '',
                'purchase_date' => '',
                'cost' => '',
                'current_value' => '',
            ]
        ]
    ];



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
        'last_5_yrs_income' => 'required|string',
        'movable_assets.*.type' => 'required',
        'movable_assets.*.holder' => 'required|in:self,spouse,huf,dependent',
        'movable_assets.*.amount' => 'nullable|numeric',
        'loans_govt_dues' => 'required|string',
        'occupation' => 'required|string',
        'sources_of_income' => 'required|string',
        'highest_educational_qualification' => 'required|string',
    ];

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

    public function addMovableAsset()
    {
        $this->movable_assets[] = [
            'type' => '',
            'holder' => '',
            'description' => '',
            'amount' => '',
        ];
    }

    public function removeMovableAsset($index)
    {
        unset($this->movable_assets[$index]);
        $this->movable_assets = array_values($this->movable_assets);
    }

    public function addLand()
    {
        $this->immovable_assets['agricultural_land'][] = [
            'holder' => 'self',
            'location' => '',
            'area' => '',
            'inherited' => '',
            'purchase_date' => '',
            'cost' => '',
            'current_value' => '',
        ];
    }

    public function removeLand($index)
    {
        unset($this->immovable_assets['agricultural_land'][$index]);
        $this->immovable_assets['agricultural_land'] = array_values(
            $this->immovable_assets['agricultural_land']
        );
    }

    public function save()
    {
        $this->validate();

        $photoPath = $this->photograph->store('form26', 'public');

        NominationForm26::create([
            'relation_type' => $this->relation_type,
            'relation_name' => $this->relation_name,
            'candidate_id' => $this->candidate->id,
            'address' => $this->address,
            'assembly_constituency_no' => $this->candidate->assembly->assembly_number ?? null,
            'assembly_constituency_serial_no' => $this->assembly_constituency_serial_no,
            'assembly_constituency_part_no' => $this->assembly_constituency_part_no,
            'phone_no' => $this->phone_no,
            'alternative_phone_no' => $this->alternative_phone_no,
            'candidate_epic_no' => $this->candidate_epic_no,
            'photograph' => $photoPath,
            'caste_tribe_details' => $this->caste_tribe_details,
            'proposer_epic' => $this->proposer_epic,
            'email_id' => $this->email_id,
            'social_media_accounts' => json_encode([
                                            'whatsapp_no' => $this->whatsapp_no,
                                            'facebook_account' => $this->facebook_account,
                                            'twitter_account' => $this->twitter_account,
                                        ]),
            'pan_and_itr_details' => json_encode($this->pan_details),
            'last_5_yrs_income' => $this->last_5_yrs_income,
            'movable_assets' => json_encode($this->movable_assets),
            'immovable_assets' => json_encode($this->immovable_assets),
            'loans_govt_dues' => $this->loans_govt_dues,
            'occupation' => $this->occupation,
            'sources_of_income' => $this->sources_of_income,
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

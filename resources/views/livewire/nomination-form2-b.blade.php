<div>
    <style>
        label{
            cursor: pointer;
        },
        input:invalid {
            border-color: red;
        },
        .error-field {
            font-weight: 500;
        }
    </style>
   
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0 text-primary">
            <i class="bi bi-person-circle me-2"></i>
            {{ ucwords($candidate->name ?? 'N/A') }}
        </h4>

        <a href="{{ route('admin.candidates.contacts') }}" class="btn btn-danger btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <strong><h3>FORM 2B</h3></strong>
            <p><strong>Assembly:</strong> ({{ $candidate->assembly->assembly_number }}) {{ $candidate->assembly->assembly_name_en }}</p>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-3">
        <div class="card-body">

            <h5 class="text-danger fw-bold mb-3">
                Criminal Offense Check
            </h5>

            <div class="form-check form-check-inline">
                <input class="form-check-input"
                    type="radio"
                    id="criminal_yes"
                    name="criminal_check"
                    wire:model.live="criminal_check"
                    value="Yes">

                <label class="form-check-label" for="criminal_yes">Yes</label>
            </div>

            <div class="form-check form-check-inline">
                <input class="form-check-input"
                    type="radio"
                    id="criminal_no"
                    name="criminal_check"
                    wire:model.live="criminal_check"
                    value="No">

                <label class="form-check-label" for="criminal_no">No</label>
            </div>

        </div>
    </div>

    @if($criminal_check === 'Yes')
        <div class="alert alert-danger text-center fw-bold">
            The candidate has a criminal offense record. Please contact the upper-level officer for further action.
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="{{ $criminal_check === 'Yes' ? 'opacity-50 pointer-events-none' : '' }}">
                <form wire:submit.prevent="save">
                    <div class="row mb-3">
                        <label class="col-md-3 col-form-label fw-semibold">Candidate Name</label>
                        <div class="col-md-9">
                            <input type="text"
                                class="form-control"
                                wire:model.defer="candidate_name"
                                readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-3 col-form-label fw-semibold">Age</label>
                        <div class="col-md-9">
                            <input type="number"
                                class="form-control"
                                wire:model.defer="age">
                                @error('age')
                                    <small class="text-danger d-block error-field" id="error-age">{{ $message }}</small>
                                @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-3 col-form-label fw-semibold">Relation Type</label>
                        <div class="col-md-9">

                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                    type="radio"
                                    name="relation_type"
                                    id="relation_father"
                                    wire:model.defer="relation_type"
                                    value="father">
                                <label class="form-check-label" for="relation_father">Father</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                    type="radio"
                                    name="relation_type"
                                    id="relation_mother"
                                    wire:model.defer="relation_type"
                                    value="mother">
                                <label class="form-check-label" for="relation_mother">Mother</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                    type="radio"
                                    name="relation_type"
                                    id="relation_husband"
                                    wire:model.defer="relation_type"
                                    value="husband">
                                <label class="form-check-label" for="relation_husband">Husband</label>
                            </div>

                        </div>

                        @error('relation_type')
                            <small class="text-danger d-block error-field" id="error-relation_type">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-3 col-form-label fw-semibold">Relation Name</label>
                        <div class="col-md-9">
                            <input type="text"
                                class="form-control"
                                wire:model.defer="relation_name">
                                @error('relation_name')
                                    <small class="text-danger d-block error-field" id="error-relation_name">{{ $message }}</small>
                                @enderror
                                
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-3 col-form-label fw-semibold">Pronoun</label>
                        <div class="col-md-9">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                    type="radio"
                                    name="pronoun"
                                    wire:model.defer="pronoun"
                                    id = "pronoun_his"
                                    value="his">
                                <label class="form-check-label" for="pronoun_his">His</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                    type="radio"
                                    name="pronoun"
                                    wire:model.defer="pronoun"
                                    id = "pronoun_her"
                                    value="her">
                                <label class="form-check-label" for="pronoun_her">Her</label>
                            </div>
                            @error('pronoun')
                                <small class="text-danger d-block error-field" id="error-pronoun">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-3 col-form-label fw-semibold">Postal Address</label>
                        <div class="col-md-9">
                            <input type="text"
                                class="form-control"
                                wire:model.defer="postal_address">
                            @error('postal_address')
                                <small class="text-danger d-block error-field" id="error-postal_address">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-3 col-form-label fw-semibold">Electoral Roll Details</label>
                        <div class="col-md-3">
                            <input type="text"
                                class="form-control"
                                placeholder="Sl. No."
                                wire:model.defer="candidate_serial_no">
                            @error('candidate_serial_no')
                                <small class="text-danger d-block error-field" id="error-candidate_serial_no">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <input type="text"
                                class="form-control"
                                placeholder="Part No."
                                wire:model.defer="candidate_part_no">
                            @error('candidate_part_no')
                                <small class="text-danger d-block error-field" id="error-candidate_part_no">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <input type="text"
                                class="form-control"
                                placeholder="Assembly Constituency"
                                wire:model.defer="assembly_name"
                                readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-3 col-form-label fw-semibold">Enrolled Constituency Name</label>
                        <div class="col-md-9">
                            <input type="text"
                                class="form-control"
                                wire:model.defer="constituency_where_enrolled">
                        </div>
                    </div>

                    <hr>

                    <h6 class="text-primary fw-semibold mb-3">Proposer Details</h6>

                    <div class="row mb-3">
                        <label class="col-md-3 col-form-label fw-semibold">Proposer Name</label>
                        <div class="col-md-9">
                            <input type="text"
                                class="form-control"
                                wire:model.defer="proposer_name">
                            @error('proposer_name')
                                <small class="text-danger d-block error-field" id="error-proposer_name">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-3 col-form-label fw-semibold">Proposer Roll Details</label>
                        <div class="col-md-3">
                            <input type="text"
                                class="form-control"
                                placeholder="Sl. No."
                                wire:model.defer="proposer_serial_no">
                            @error('proposer_serial_no')
                                <small class="text-danger d-block error-field" id="error-proposer_serial_no">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <input type="text"
                                class="form-control"
                                placeholder="Part No."
                                wire:model.defer="proposer_part_no">
                            @error('proposer_part_no')
                                <small class="text-danger d-block error-field" id="error-proposer_part_no">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <input type="text"
                                class="form-control"
                                placeholder="Assembly Constituency"
                                wire:model.defer="proposer_constituency">
                        </div>
                    </div>

                    <hr>

                    <div class="text-center mb-3">
                        <h5 class="fw-bold">PART IIIA</h5>
                        <small class="text-muted">(To be filled by the candidate)</small>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label fw-semibold">
                            Whether the candidate has been convicted
                        </label>
                        <div class="col-md-8">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                    type="radio"
                                    id="convicted_yes"
                                    name="convicted"
                                    wire:model="convicted"
                                    value="Yes" wire:change="toggleConvicted('Yes')" @disabled(true)>
                                <label class="form-check-label" for="convicted_yes" >Yes</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                    type="radio"
                                    id="convicted_no"
                                    name="convicted"
                                    wire:model="convicted"
                                    value="No" wire:change="toggleConvicted('No')">
                                <label class="form-check-label" for="convicted_no">No</label>
                            </div>
                            @error('convicted')
                                <small class="text-danger d-block">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    @if($convicted === "Yes")
                    <hr>
                    <h6 class="text-danger fw-semibold mb-3">
                        Details of Conviction
                    </h6>

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label">Case / FIR Number</label>
                        <div class="col-md-8">
                            <input type="number"
                                class="form-control"
                                wire:model.defer="convicted_details.case_no">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label">Police Station</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control"
                            wire:model.defer="convicted_details.police_station">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label">District</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control"
                                wire:model.defer="convicted_details.district">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label">State</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control"
                                wire:model.defer="convicted_details.state">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label">
                            Sections & Description of Offence
                        </label>
                        <div class="col-md-8">
                            <textarea class="form-control"
                                    rows="2"
                                    wire:model.defer="convicted_details.sections">
                            </textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label">Date of Conviction</label>
                        <div class="col-md-4">
                            <input type="date"
                                class="form-control"
                                wire:model.defer="convicted_details.conviction_date">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label">Court Name</label>
                        <div class="col-md-8">
                            <input type="text"
                                class="form-control"
                                wire:model.defer="convicted_details.court">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label">Punishment Details</label>
                        <div class="col-md-8">
                            <textarea class="form-control"
                                    rows="2"
                                    wire:model.defer="convicted_details.punishment"></textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label">Date of Release</label>
                        <div class="col-md-4">
                            <input type="date"
                                class="form-control"
                                wire:model.defer="convicted_details.release_date">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label">Appeal Filed</label>
                        <div class="col-md-8">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                    type="radio"
                                    name="appeal_filed"
                                    id ="appeal_filed_yes"
                                    wire:model.defer="convicted_details.appeal_filed"
                                    value="Yes">
                                <label class="form-check-label" for="appeal_filed_yes">Yes</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                    type="radio"
                                    name="appeal_filed"
                                    id="appeal_filed_no"
                                    wire:model.defer="convicted_details.appeal_filed"
                                    value="No">
                                <label class="form-check-label" for="appeal_filed_no">No</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label">Appeal Details</label>
                        <div class="col-md-8">
                            <input type="text"
                                class="form-control"
                                wire:model.defer="convicted_details.appeal_details">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label">Appeal Court</label>
                        <div class="col-md-8">
                            <input type="text"
                                class="form-control"
                                wire:model.defer="convicted_details.appeal_court">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label">Appeal Status</label>
                        <div class="col-md-8">
                            <input type="text"
                                class="form-control"
                                wire:model.defer="convicted_details.appeal_status">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label">Date of Disposal</label>
                        <div class="col-md-4">
                            <input type="date"
                                class="form-control"
                                wire:model.defer="convicted_details.disposal_date">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label">Nature of Order</label>
                        <div class="col-md-8">
                            <input type="text"
                                class="form-control"
                                wire:model.defer="convicted_details.order_nature">
                        </div>
                    </div>

                    @endif

                    <hr>

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label fw-semibold">
                            Whether the candidate is holding any office of profit under the Government?
                        </label>
                        <div class="col-md-8">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="office_of_profit_yes" name="office_of_profit" wire:model="office_of_profit" value="1" wire:change="FieldToggle('office_of_profit', 1)">
                                <label class="form-check-label" for="office_of_profit_yes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="office_of_profit_no" name="office_of_profit" wire:model="office_of_profit" value="0" wire:change="FieldToggle('office_of_profit', 0)">
                                <label class="form-check-label" for="office_of_profit_no">No</label>
                            </div>
                        </div>
                    </div>
                    {{-- Yes --}}
                    @if($office_of_profit == 1 ) 
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label">Details of office held</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" wire:model.defer="holding_office_of_profit">
                                @error('holding_office_of_profit')
                                    <small class="text-danger d-block error-field" id="error-holding_office_of_profit">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    @endif

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label fw-semibold">
                            Whether the candidate has been declared insolvent by any Court?
                        </label>
                        <div class="col-md-8">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="insolvent_yes" name="insolvent" wire:model="insolvent" value="1" wire:change="FieldToggle('insolvent', 1)">
                                <label class="form-check-label" for="insolvent_yes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="insolvent_no" name="insolvent" wire:model="insolvent" value="0" wire:change="FieldToggle('insolvent', 0)">
                                <label class="form-check-label" for="insolvent_no">No</label>
                            </div>
                        </div>
                    </div>

                    @if($insolvent == 1)
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label">Insolvency details</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" wire:model.defer="declared_insolvent">
                                @error('declared_insolvent')
                                    <small class="text-danger d-block error-field" id="error-declared_insolvent">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    @endif

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label fw-semibold">
                            Whether the candidate is under allegiance to any foreign country?
                        </label>
                        <div class="col-md-8">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="foreign_allegiance_yes" name="foreign_allegiance" wire:model="foreign_allegiance" value="1" wire:change="FieldToggle('foreign_allegiance', 1)">
                                <label class="form-check-label" for="foreign_allegiance_yes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="foreign_allegiance_no" name="foreign_allegiance" wire:model="foreign_allegiance" value="0" wire:change="FieldToggle('foreign_allegiance', 0)">
                                <label class="form-check-label" for="foreign_allegiance_no">No</label> 
                            </div>
                        </div>
                    </div>

                    @if($foreign_allegiance == 1)
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label">Details</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" wire:model.defer="allegiance_to_foreign_country">
                                @error('allegiance_to_foreign_country')
                                    <small class="text-danger d-block error-field" id="error-allegiance_to_foreign_country">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    @endif


                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label fw-semibold">
                            Whether the candidate has been disqualified under section 8A of the said Act by an order of
                            the President?
                        </label>
                        <div class="col-md-8">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="disqualified_president_yes" name="disqualified_president" wire:model="disqualified_president" value="1" wire:change="FieldToggle('disqualified_president', 1)">
                                <label class="form-check-label" for="disqualified_president_yes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="disqualified_president_no" name="disqualified_president" wire:model="disqualified_president" value="0" wire:change="FieldToggle('disqualified_president', 0)">
                                <label class="form-check-label" for="disqualified_president_no">No</label>
                            </div>
                        </div>
                    </div>

                    @if($disqualified_president == 1)
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label">If Yes, the period for which disqualified</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" wire:model.defer="disqualified_by_president">
                                @error('disqualified_by_president')
                                    <small class="text-danger d-block error-field" id="error-disqualified_by_president">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    @endif


                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label fw-semibold">
                            Whether the candidate was dismissed for corruption or disloyalty?
                        </label>
                        <div class="col-md-8">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="dismissed_for_corruptions_yes" name="dismissed_for_corruptions"
                                    wire:model="dismissed_for_corruptions" value="1" wire:change="FieldToggle('dismissed_for_corruptions', 1)">
                                <label class="form-check-label" for="dismissed_for_corruptions_yes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="dismissed_for_corruptions_no" name="dismissed_for_corruptions"
                                    wire:model="dismissed_for_corruptions" value="0" wire:change="FieldToggle('dismissed_for_corruptions', 0)">
                                <label class="form-check-label" for="dismissed_for_corruptions_no">No</label>
                            </div>
                        </div>
                    </div>

                    @if($dismissed_for_corruptions == 1)
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label">Date of dismissal</label>
                            <div class="col-md-4">
                                <input type="date" class="form-control" wire:model.defer="dismissed_for_corruption">
                                @error('dismissed_for_corruption')
                                    <small class="text-danger d-block error-field" id="error-dismissed_for_corruption">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    @endif


                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label fw-semibold">
                            Whether the candidate has any subsisting contract(s) with the Government?
                        </label>
                        <div class="col-md-8">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="govt_contract_yes" name="govt_contract"
                                    wire:model="govt_contract" value="1" wire:change="FieldToggle('govt_contract', 1)">
                                <label class="form-check-label" for="govt_contract_yes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="govt_contract_no" name="govt_contract"
                                    wire:model="govt_contract" value="0" wire:change="FieldToggle('govt_contract', 0)">
                                <label class="form-check-label" for="govt_contract_no">No</label>
                            </div>
                        </div>
                    </div>

                    @if($govt_contract == 1)
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label">
                                With which Government and details of subsisting contract(s)
                            </label>
                            <div class="col-md-8">
                                <input type="text"
                                    class="form-control"
                                    wire:model.defer="subsisting_govt_contract">
                                    @error('subsisting_govt_contract')
                                        <small class="text-danger d-block error-field" id="error-subsisting_govt_contract">{{ $message }}</small>
                                    @enderror
                            </div>
                        </div>
                    @endif


                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label fw-semibold">
                            Whether the candidate is a managing agent, manager or Secretary of any company or Corporation?
                        </label>
                        <div class="col-md-8">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="company_position_yes" name="company_position"
                                    wire:model="company_position" value="1" wire:change="FieldToggle('company_position', 1)">
                                <label class="form-check-label" for="company_position_yes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="company_position_no" name="company_position"
                                    wire:model="company_position" value="0" wire:change="FieldToggle('company_position', 0)">
                                <label class="form-check-label" for="company_position_no">No</label>
                            </div>
                        </div>
                    </div>

                    @if($company_position == 1)
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label">
                                Details thereof
                            </label>
                            <div class="col-md-8">
                                <input type="text"
                                    class="form-control"
                                    wire:model.defer="managing_agent_role">
                                    @error('managing_agent_role')
                                        <small class="text-danger d-block error-field" id="error-managing_agent_role">{{ $message }}</small>
                                    @enderror
                            </div>
                        </div>
                    @endif


                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label fw-semibold">
                            Whether the candidate has been disqualified by the Commission under section 10A of the said Act?
                        </label>
                        <div class="col-md-8">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="commission_disqualified_yes" name="disqualified_by_commission"
                                    wire:model="commission_disqualified" value="1" wire:change="FieldToggle('commission_disqualified', 1)">
                                <label class="form-check-label" for="commission_disqualified_yes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="commission_disqualified_no" name="disqualified_by_commission"
                                    wire:model="commission_disqualified" value="0" wire:change="FieldToggle('commission_disqualified', 0)">
                                <label class="form-check-label" for="commission_disqualified_no">No</label>
                            </div>
                        </div>
                    </div>

                    @if($commission_disqualified == 1)
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label">
                                Date of disqualification
                            </label>
                            <div class="col-md-4">
                                <input type="date"
                                    class="form-control"
                                    wire:model.defer="date_of_disqualification">
                                    @error('date_of_disqualification')
                                        <small class="text-danger d-block error-field" id="error-date_of_disqualification">{{ $message }}</small>
                                    @enderror
                            </div>
                        </div>
                    @endif

                     {{-- @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif --}}
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary" 
                            {{ $criminal_check === 'Yes' ? 'disabled' : '' }}>
                            Save & Preview
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.addEventListener('toastr:error', e => toastr.error(e.detail.message));
        window.addEventListener('toastr:success', e => toastr.success(e.detail.message));
    </script>
    <script>
        document.addEventListener('livewire:init', function () {

            Livewire.on('scroll-to-error', () => {
                let firstError = document.querySelector('.error-field');

                if (firstError) {

                    firstError.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    let parent = firstError.closest('.row');

                    if (parent) {
                        let input = parent.querySelector('input, textarea, select');

                        if (input) {
                            setTimeout(() => {
                                input.focus();
                            }, 500);
                        }
                    }

                }

            });

        });
    </script>
@endpush

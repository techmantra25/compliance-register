<div>
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
            <p><strong>Assembly:</strong> {{ $candidate->assembly->assembly_name_en }} ({{ $candidate->assembly->assembly_code }})</p>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
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
                        <input type="text"
                            class="form-control"
                            wire:model.defer="age"
                            value="age">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-3 col-form-label fw-semibold">Relation Type</label>
                    <div class="col-md-9">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="relation_type"
                                wire:model.defer="relation_type"
                                value="father">
                            <label class="form-check-label">Father</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="relation_type"
                                wire:model.defer="relation_type"
                                value="mother">
                            <label class="form-check-label">Mother</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="relation_type"
                                wire:model.defer="relation_type"
                                value="husband">
                            <label class="form-check-label">Husband</label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-3 col-form-label fw-semibold">Relation Name</label>
                    <div class="col-md-9">
                        <input type="text"
                            class="form-control"
                            wire:model.defer="relation_name">
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
                                value="his">
                            <label class="form-check-label">His</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="pronoun"
                                wire:model.defer="pronoun"
                                value="her">
                            <label class="form-check-label">Her</label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-3 col-form-label fw-semibold">Postal Address</label>
                    <div class="col-md-9">
                        <input type="text"
                            class="form-control"
                            wire:model.defer="postal_address">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-3 col-form-label fw-semibold">Electoral Roll Details</label>
                    <div class="col-md-3">
                        <input type="text"
                            class="form-control"
                            placeholder="Sl. No."
                            wire:model.defer="candidate_serial_no">
                    </div>
                    <div class="col-md-3">
                        <input type="text"
                            class="form-control"
                            placeholder="Part No."
                            wire:model.defer="candidate_part_no">
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
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-3 col-form-label fw-semibold">Proposer Roll Details</label>
                    <div class="col-md-3">
                        <input type="text"
                            class="form-control"
                            placeholder="Sl. No."
                            wire:model.defer="proposer_serial_no">
                    </div>
                    <div class="col-md-3">
                        <input type="text"
                            class="form-control"
                            placeholder="Part No."
                            wire:model.defer="proposer_part_no">
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
                                name="convicted"
                                wire:model.live="convicted"
                                value="yes">
                            <label class="form-check-label">Yes</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="convicted"
                                wire:model.live="convicted"
                                value="no">
                            <label class="form-check-label">No</label>
                        </div>
                    </div>
                </div>

                @if($convicted === 'yes')
                <hr>
                <h6 class="text-danger fw-semibold mb-3">
                    Details of Conviction
                </h6>

                <div class="row mb-3">
                    <label class="col-md-4 col-form-label">Case / FIR Number</label>
                    <div class="col-md-8">
                        <input type="text"
                            class="form-control"
                            wire:model.defer="case_no">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-4 col-form-label">Police Station</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control"
                            wire:model.defer="police_station">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-4 col-form-label">District</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control"
                            wire:model.defer="district">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-4 col-form-label">State</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control"
                            wire:model.defer="state">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-4 col-form-label">
                        Sections & Description of Offence
                    </label>
                    <div class="col-md-8">
                        <textarea class="form-control"
                                rows="2"
                                wire:model.defer="sections"></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-4 col-form-label">Date of Conviction</label>
                    <div class="col-md-4">
                        <input type="date"
                            class="form-control"
                            wire:model.defer="conviction_date">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-4 col-form-label">Court Name</label>
                    <div class="col-md-8">
                        <input type="text"
                            class="form-control"
                            wire:model.defer="court">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-4 col-form-label">Punishment Details</label>
                    <div class="col-md-8">
                        <textarea class="form-control"
                                rows="2"
                                wire:model.defer="punishment"></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-4 col-form-label">Date of Release</label>
                    <div class="col-md-4">
                        <input type="date"
                            class="form-control"
                            wire:model.defer="release_date">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-4 col-form-label">Appeal Filed</label>
                    <div class="col-md-8">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="appeal_filed"
                                wire:model="appeal_filed"
                                value="yes">
                            <label class="form-check-label">Yes</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="appeal_filed"
                                wire:model="appeal_filed"
                                value="no">
                            <label class="form-check-label">No</label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-4 col-form-label">Appeal Details</label>
                    <div class="col-md-8">
                        <input type="text"
                            class="form-control"
                            wire:model.defer="appeal_details">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-4 col-form-label">Appeal Court</label>
                    <div class="col-md-8">
                        <input type="text"
                            class="form-control"
                            wire:model.defer="appeal_court">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-4 col-form-label">Appeal Status</label>
                    <div class="col-md-8">
                        <input type="text"
                            class="form-control"
                            wire:model.defer="appeal_status">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-4 col-form-label">Date of Disposal</label>
                    <div class="col-md-4">
                        <input type="date"
                            class="form-control"
                            wire:model.defer="disposal_date">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-4 col-form-label">Nature of Order</label>
                    <div class="col-md-8">
                        <input type="text"
                            class="form-control"
                            wire:model.defer="order_nature">
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
                            <input class="form-check-input" type="radio" name="office_of_profit" wire:model="office_of_profit" value="yes">
                            <label class="form-check-label">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="office_of_profit" wire:model="office_of_profit" value="no">
                            <label class="form-check-label">No</label>
                        </div>
                    </div>
                </div>

                {{-- @if($office_of_profit === 'yes') --}}
                <div class="row mb-3">
                    <label class="col-md-4 col-form-label">Details of office held</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" wire:model.defer="office_details">
                    </div>
                </div>
                {{-- @endif --}}

                <div class="row mb-3">
                    <label class="col-md-4 col-form-label fw-semibold">
                        Whether the candidate has been declared insolvent by any Court?
                    </label>
                    <div class="col-md-8">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="insolvent" wire:model="insolvent" value="yes">
                            <label class="form-check-label">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="insolvent" wire:model="insolvent" value="no">
                            <label class="form-check-label">No</label>
                        </div>
                    </div>
                </div>

                {{-- @if($insolvent === 'yes') --}}
                <div class="row mb-3">
                    <label class="col-md-4 col-form-label">Insolvency details</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" wire:model.defer="insolvent_details">
                    </div>
                </div>
                {{-- @endif --}}

                <div class="row mb-3">
                    <label class="col-md-4 col-form-label fw-semibold">
                        Whether the candidate is under allegiance to any foreign country?
                    </label>
                    <div class="col-md-8">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="foreign_allegiance" wire:model="foreign_allegiance" value="yes">
                            <label class="form-check-label">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="foreign_allegiance" wire:model="foreign_allegiance" value="no">
                            <label class="form-check-label">No</label>
                        </div>
                    </div>
                </div>

                {{-- @if($foreign_allegiance === 'yes') --}}
                <div class="row mb-3">
                    <label class="col-md-4 col-form-label">Details</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" wire:model.defer="foreign_details">
                    </div>
                </div>
                {{-- @endif --}}


                <div class="row mb-3">
                    <label class="col-md-4 col-form-label fw-semibold">
                        Whether the candidate has been disqualified under section 8A of the said Act by an order of
                        the President?
                    </label>
                    <div class="col-md-8">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="disqualified_president" wire:model="disqualified_president" value="yes">
                            <label class="form-check-label">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="disqualified_president" wire:model="disqualified_president" value="no">
                            <label class="form-check-label">No</label>
                        </div>
                    </div>
                </div>

                {{-- @if($disqualified_president === 'yes') --}}
                <div class="row mb-3">
                    <label class="col-md-4 col-form-label">If Yes, the period for which disqualified</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" wire:model.defer="disqualified_period">
                    </div>
                </div>
                {{-- @endif --}}


                <div class="row mb-3">
                    <label class="col-md-4 col-form-label fw-semibold">
                        Whether the candidate was dismissed for corruption or disloyalty?
                    </label>
                    <div class="col-md-8">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="dismissed_for_corruptions"
                                wire:model="dismissed_for_corruptions" value="yes">
                            <label class="form-check-label">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="dismissed_for_corruptions"
                                wire:model="dismissed_for_corruptions" value="no">
                            <label class="form-check-label">No</label>
                        </div>
                    </div>
                </div>

                {{-- @if($dismissed_for_corruptions === 'yes') --}}
                <div class="row mb-3">
                    <label class="col-md-4 col-form-label">Date of dismissal</label>
                    <div class="col-md-4">
                        <input type="date" class="form-control" wire:model.defer="dismissed_date">
                    </div>
                </div>
                {{-- @endif --}}


                <div class="row mb-3">
                    <label class="col-md-4 col-form-label fw-semibold">
                        Whether the candidate has any subsisting contract(s) with the Government?
                    </label>
                    <div class="col-md-8">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="govt_contract"
                                wire:model="govt_contract" value="yes">
                            <label class="form-check-label">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="govt_contract"
                                wire:model="govt_contract" value="no">
                            <label class="form-check-label">No</label>
                        </div>
                    </div>
                </div>

                {{-- @if($govt_contract === 'yes') --}}
                <div class="row mb-3">
                    <label class="col-md-4 col-form-label">
                        With which Government and details of subsisting contract(s)
                    </label>
                    <div class="col-md-8">
                        <input type="text"
                            class="form-control"
                            wire:model.defer="govt_contract_details">
                    </div>
                </div>
                {{-- @endif --}}


                <div class="row mb-3">
                    <label class="col-md-4 col-form-label fw-semibold">
                        Whether the candidate is a managing agent, manager or Secretary of any company or Corporation?
                    </label>
                    <div class="col-md-8">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="company_position"
                                wire:model="company_position" value="yes">
                            <label class="form-check-label">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="company_position"
                                wire:model="company_position" value="no">
                            <label class="form-check-label">No</label>
                        </div>
                    </div>
                </div>

                {{-- @if($company_position === 'yes') --}}
                <div class="row mb-3">
                    <label class="col-md-4 col-form-label">
                        Details thereof
                    </label>
                    <div class="col-md-8">
                        <input type="text"
                            class="form-control"
                            wire:model.defer="company_details">
                    </div>
                </div>
                {{-- @endif --}}


                <div class="row mb-3">
                    <label class="col-md-4 col-form-label fw-semibold">
                        Whether the candidate has been disqualified by the Commission under section 10A of the said Act?
                    </label>
                    <div class="col-md-8">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="commission_disqualified"
                                wire:model="commission_disqualified" value="yes">
                            <label class="form-check-label">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="commission_disqualified"
                                wire:model="commission_disqualified" value="no">
                            <label class="form-check-label">No</label>
                        </div>
                    </div>
                </div>

                {{-- @if($commission_disqualified === 'yes') --}}
                <div class="row mb-3">
                    <label class="col-md-4 col-form-label">
                        Date of disqualification
                    </label>
                    <div class="col-md-4">
                        <input type="date"
                            class="form-control"
                            wire:model.defer="commission_disqualified_date">
                    </div>
                </div>
                {{-- @endif --}}


                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        Save & Preview
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
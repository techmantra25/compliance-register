<div>
    <style>
        label {
            cursor: pointer;
        }

        /* ✅ Better UI */
        .card {
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .form-control {
            border-radius: 8px;
            padding: 10px;
        }

        .error-message {
            font-size: 13px;
            margin-top: 4px;
            display: block;
        }

        /* ✅ Mobile Fix */
        @media (max-width: 768px) {
            .row {
                display: block;
            }
            .col-md-3, .col-md-4, .col-md-8, .col-md-9 {
                width: 100%;
                max-width: 100%;
            }
            label {
                margin-bottom: 5px;
            }
        }
    </style>
    <div class="card mb-3">
        <div class="card-body">
            <strong><h3>Generate Form 2B</h3></strong>
            <p><strong>Assembly:</strong> {{ $assembly_data->name }}</p>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="">
                <form id="form2b" wire:submit.prevent="save">
                    <div class="row mb-3">
                        <label class="col-md-3 col-form-label fw-semibold">Candidate Name</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" wire:model.defer="candidate_name">
                              @error('candidate_name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-3 col-form-label fw-semibold">Age</label>
                        <div class="col-md-9">
                            <input type="number" class="form-control" wire:model.defer="age">
                              @error('age') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-3 col-form-label fw-semibold">Relation Type</label>
                        <div class="col-md-9">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="relation_type" id="relation_father" wire:model.defer="relation_type" value="father">
                                <label class="form-check-label" for="relation_father">Father</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="relation_type" id="relation_mother" wire:model.defer="relation_type" value="mother">
                                <label class="form-check-label" for="relation_mother">Mother</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="relation_type" id="relation_husband" wire:model.defer="relation_type" value="husband">
                                <label class="form-check-label" for="relation_husband">Husband</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-3 col-form-label fw-semibold">Name of Relative as stated above</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" wire:model.defer="relation_name">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-3 col-form-label fw-semibold">Gender</label>
                        <div class="col-md-9">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pronoun" wire:model.defer="pronoun" id="pronoun_his" value="his">
                                <label class="form-check-label" for="pronoun_his">His</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pronoun" wire:model.defer="pronoun" id="pronoun_her" value="her">
                                <label class="form-check-label" for="pronoun_her">Her</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-3 col-form-label fw-semibold">Postal Address</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" wire:model.defer="postal_address">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-3 col-form-label fw-semibold">Electoral Roll Details</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" placeholder="Sl. No." wire:model.defer="candidate_serial_no">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" placeholder="Part No." wire:model.defer="candidate_part_no">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" placeholder="Assembly Constituency" wire:model.defer="assembly_name" readonly="">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-3 col-form-label fw-semibold">Enrolled Constituency Name</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" wire:model.defer="constituency_where_enrolled">
                        </div>
                    </div>

                    <hr>
                    <div class="text-center mb-3">
                        <h5 class="fw-bold">PART II</h5>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <h6 class="text-primary fw-semibold">Proposer Details</h6>
                        <button type="button" class="btn btn-sm btn-info" wire:click="addProposer">+ Add More Proposer</button>
                    </div>

                    @foreach($proposers as $index => $prop)
                    <div class="border p-3 mb-3 rounded shadow-sm">
                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label fw-semibold">Proposer Name</label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" wire:model.defer="proposers.{{$index}}.name">
                            </div>
                            <div class="col-md-2 text-end">
                                @if(count($proposers) > 1)
                                <button type="button" class="btn btn-danger btn-sm" wire:click="removeProposer({{$index}})">×</button>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label fw-semibold">Proposer Roll Details</label>
                            <div class="col-md-3">
                                <input type="text" class="form-control" placeholder="Sl. No." wire:model.defer="proposers.{{$index}}.sl_no">
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" placeholder="Part No." wire:model.defer="proposers.{{$index}}.part_no">
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" placeholder="Assembly Constituency" wire:model.defer="proposers.{{$index}}.constituency">
                            </div>
                        </div>
                    </div>
                    @endforeach

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
                                <input class="form-check-input" type="radio" id="convicted_yes" name="convicted" wire:model="convicted" value="Yes" @disabled(true)>
                                <label class="form-check-label" for="convicted_yes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="convicted_no" name="convicted" wire:model="convicted" value="No">
                                <label class="form-check-label" for="convicted_no">No</label>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label fw-semibold">
                            Whether the candidate is holding any office of profit under the Government?
                        </label>
                        <div class="col-md-8">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="office_of_profit_yes" name="office_of_profit" wire:click="FieldToggle('office_of_profit', 1)" {{ $office_of_profit == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="office_of_profit_yes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="office_of_profit_no" name="office_of_profit" wire:click="FieldToggle('office_of_profit', 0)" {{ $office_of_profit == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="office_of_profit_no">No</label>
                            </div>
                        </div>
                    </div>
                    
                    @if($office_of_profit == 1)
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label">Details of office held</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" wire:model.defer="holding_office_of_profit">
                                @error('holding_office_of_profit') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                    @endif

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label fw-semibold">
                            Whether the candidate has been declared insolvent by any Court?
                        </label>
                        <div class="col-md-8">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="insolvent_yes" name="insolvent" wire:click="FieldToggle('insolvent', 1)" {{ $insolvent == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="insolvent_yes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="insolvent_no" name="insolvent" wire:click="FieldToggle('insolvent', 0)" {{ $insolvent == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="insolvent_no">No</label>
                            </div>
                        </div>
                    </div>

                    @if($insolvent == 1)
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label">Insolvency details</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" wire:model.defer="declared_insolvent">
                                @error('declared_insolvent') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                    @endif

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label fw-semibold">
                            Whether the candidate is under allegiance to any foreign country?
                        </label>
                        <div class="col-md-8">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="foreign_allegiance_yes" name="foreign_allegiance" wire:click="FieldToggle('foreign_allegiance', 1)" {{ $foreign_allegiance == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="foreign_allegiance_yes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="foreign_allegiance_no" name="foreign_allegiance" wire:click="FieldToggle('foreign_allegiance', 0)" {{ $foreign_allegiance == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="foreign_allegiance_no">No</label> 
                            </div>
                        </div>
                    </div>

                    @if($foreign_allegiance == 1)
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label">Details</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" wire:model.defer="allegiance_to_foreign_country">
                                @error('allegiance_to_foreign_country') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                    @endif

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label fw-semibold">
                            Whether the candidate has been disqualified under section 8A of the said Act by an order of the President?
                        </label>
                        <div class="col-md-8">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="disqualified_president_yes" name="disqualified_president" wire:click="FieldToggle('disqualified_president', 1)" {{ $disqualified_president == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="disqualified_president_yes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="disqualified_president_no" name="disqualified_president" wire:click="FieldToggle('disqualified_president', 0)" {{ $disqualified_president == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="disqualified_president_no">No</label>
                            </div>
                        </div>
                    </div>

                    @if($disqualified_president == 1)
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label">If Yes, the period for which disqualified</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" wire:model.defer="disqualified_by_president">
                                @error('disqualified_by_president') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                    @endif

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label fw-semibold">
                            Whether the candidate was dismissed for corruption or disloyalty?
                        </label>
                        <div class="col-md-8">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="dismissed_for_corruptions_yes" name="dismissed_for_corruptions" wire:click="FieldToggle('dismissed_for_corruptions', 1)" {{ $dismissed_for_corruptions == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="dismissed_for_corruptions_yes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="dismissed_for_corruptions_no" name="dismissed_for_corruptions" wire:click="FieldToggle('dismissed_for_corruptions', 0)" {{ $dismissed_for_corruptions == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="dismissed_for_corruptions_no">No</label>
                            </div>
                        </div>
                    </div>

                    @if($dismissed_for_corruptions == 1)
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label">Date of dismissal</label>
                            <div class="col-md-4">
                                <input type="date" class="form-control" wire:model.defer="dismissed_for_corruption">
                                @error('dismissed_for_corruption') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                    @endif

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label fw-semibold">
                            Whether the candidate has any subsisting contract(s) with the Government?
                        </label>
                        <div class="col-md-8">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="govt_contract_yes" name="govt_contract" wire:click="FieldToggle('govt_contract', 1)" {{ $govt_contract == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="govt_contract_yes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="govt_contract_no" name="govt_contract" wire:click="FieldToggle('govt_contract', 0)" {{ $govt_contract == 0 ? 'checked' : '' }}>
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
                                <input type="text" class="form-control" wire:model.defer="subsisting_govt_contract">
                                @error('subsisting_govt_contract') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                    @endif

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label fw-semibold">
                            Whether the candidate is a managing agent, manager or Secretary of any company or Corporation?
                        </label>
                        <div class="col-md-8">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="company_position_yes" name="company_position" wire:click="FieldToggle('company_position', 1)" {{ $company_position == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="company_position_yes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="company_position_no" name="company_position" wire:click="FieldToggle('company_position', 0)" {{ $company_position == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="company_position_no">No</label>
                            </div>
                        </div>
                    </div>

                    @if($company_position == 1)
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label">Details thereof</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" wire:model.defer="managing_agent_role">
                                @error('managing_agent_role') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                    @endif

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label fw-semibold">
                            Whether the candidate has been disqualified by the Commission under section 10A of the said Act?
                        </label>
                        <div class="col-md-8">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="commission_disqualified_yes" name="commission_disqualified" wire:click="FieldToggle('commission_disqualified', 1)" {{ $commission_disqualified == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="commission_disqualified_yes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="commission_disqualified_no" name="commission_disqualified" wire:click="FieldToggle('commission_disqualified', 0)" {{ $commission_disqualified == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="commission_disqualified_no">No</label>
                            </div>
                        </div>
                    </div>

                    @if($commission_disqualified == 1)
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label">Date of disqualification</label>
                            <div class="col-md-4">
                                <input type="date" class="form-control" wire:model.defer="date_of_disqualification">
                                @error('date_of_disqualification') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                    @endif

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            Save &amp; Preview
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    document.addEventListener('livewire:initialized', () => {

        Livewire.on('scrollTop', () => {
            scrollToFirstError();
        });

    });

    function scrollToFirstError() {
        setTimeout(() => {
            const firstError = document.querySelector('.error-message');
            if (firstError) {
                firstError.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'center' 
                });

                const parentInput = firstError.closest('.row')?.querySelector('.form-control');
                if(parentInput) parentInput.focus();
            }
        }, 100);
    }

    const myForm = document.getElementById('form2b');

    if (myForm) {
        myForm.addEventListener('submit', function () {
            setTimeout(scrollToFirstError, 500);
        });
    }
</script>
@endpush
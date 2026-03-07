<div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0 text-primary">
            <i class="bi bi-person-circle me-2"></i>
            {{ ucwords($candidate->name) }}
        </h4>

        <a href="{{ route('admin.candidates.contacts') }}" class="btn btn-danger btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <strong><h3>FORM 26</h3></strong>
            <p>
                <strong>Assembly:</strong>
                {{ $candidate->assembly->assembly_name_en ?? 'N/A' }}
                ({{ $candidate->assembly->assembly_code ?? '' }})
            </p>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="save">

                <div class="row g-3">

                   <div class="col-md-6">
                        <label class="form-label text-primary">Relation</label>
                        <div class="input-group">
                            <select class="form-select" wire:model.defer="relation_type" style="max-width: 120px;">
                                <option value="">--</option>
                                <option value="son">Son of</option>
                                <option value="daughter">Daughter of</option>
                                <option value="wife">Wife of</option>
                            </select>

                            <input type="text"
                                class="form-control"
                                placeholder="Enter Name"
                                wire:model.defer="relation_name">

                        </div>
                        @error('relation_type') <small class="text-danger">{{ $message }}</small> @enderror
                        @error('relation_name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-primary">Age</label>
                        <input type="number" class="form-control" wire:model.defer="age">
                        @error('age') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label text-primary">Address</label>
                        <textarea class="form-control" wire:model.defer="address" rows="2"></textarea>
                        @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label text-primary">Enrolled Constituency Name</label>
                        <input type="text" class="form-control" wire:model.defer="enrolled_constituency_name">
                        @error('enrolled_constituency_name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label text-primary">Constituency Serial No</label>
                        <input type="text" class="form-control" wire:model.defer="constituency_serial_no">
                        @error('constituency_serial_no') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                     <div class="col-md-6">
                        <label class="form-label text-primary">Constituency Part No</label>
                        <input type="text" class="form-control" wire:model.defer="constituency_part_no">
                        @error('constituency_part_no') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label text-primary">Phone No</label>
                        <input type="number" class="form-control" wire:model.defer="phone_no" min="0">
                        @error('phone_no') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-primary">Alternative Phone No</label>
                        <input type="number" class="form-control" wire:model.defer="alternative_phone_no" min="0">
                        @error('alternative_phone_no') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label text-primary">Email</label>
                        <input type="email" class="form-control" wire:model.defer="email_id">
                    </div>

                    <div class="col-md-12">
                        <h5 class="text-primary mt-3">
                            Social Media
                        </h5>
                    </div>

                   <div class="col-md-12">
                        <div class="row g-2">
                            <div class="col-md-4">
                                <label for="whatsapp_no" class="form-label text-primary">WhatsApp Number</label>
                                <input type="number"
                                    id="whatsapp_no"
                                    class="form-control"
                                    wire:model.defer="whatsapp_no"
                                    min="0">
                                @error('whatsapp_no') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="facebook_account" class="form-label text-primary">Facebook Account</label>
                                <input type="text"
                                    id="facebook_account"
                                    class="form-control"
                                    wire:model.defer="facebook_account">
                                @error('facebook_account') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="twitter_account" class="form-label text-primary">Twitter Account</label>
                                <input type="text"
                                    id="twitter_account"
                                    class="form-control"
                                    wire:model.defer="twitter_account">
                                @error('twitter_account') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="linked_in" class="form-label text-primary">LinkedIn Account</label>
                                <input type="text"
                                    id="linked_in"
                                    class="form-control"
                                    wire:model.defer="linked_in">
                                @error('linked_in') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                    </div>

                    <h5 class="text-primary mt-4">PAN and ITR Details</h5>
                    @error('pan_self_required')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                        @foreach ($pan_details as $index => $row)
                            <div class="card mb-2 shadow-sm position-relative">
                                <div class="card-body">

                                    @if ($index > 0)
                                        <button type="button"
                                            class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 m-2"
                                            wire:click="removePanRow({{ $index }})">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    @endif

                                    <span class="badge bg-secondary mb-3">
                                        PAN {{ $index + 1 }}
                                    </span>

                                    <div class="row g-2 mb-3">
                                        <div class="col-md-2">
                                            <label class="form-label text-primary">Holder</label>
                                            <select class="form-select"
                                                wire:model.defer="pan_details.{{ $index }}.type">
                                                <option value="">Select</option>
                                                <option value="self">Self</option>
                                                <option value="spouse">Spouse</option>
                                                <option value="huf">HUF</option>
                                                <option value="dependent_1">Dependent 1</option>
                                                <option value="dependent_2">Dependent 2</option>
                                                <option value="dependent_3">Dependent 3</option>
                                            </select>
                                            @error('pan_details.'.$index.'.type')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label text-primary">Name</label>
                                            <input type="text"
                                                class="form-control"
                                                wire:model.defer="pan_details.{{ $index }}.name">
                                                @error('pan_details.'.$index.'.name')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label text-primary">PAN</label>
                                            <input type="text"
                                                class="form-control text-uppercase"
                                                wire:model.defer="pan_details.{{ $index }}.pan">
                                                @error('pan_details.'.$index.'.pan')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label text-primary">Last ITR Filed (FY)</label>
                                            <select class="form-select"
                                                wire:model.defer="pan_details.{{ $index }}.last_filed_year">
                                                @foreach($financial_years as $year)
                                                    <option value="{{ $year }}">{{ $year }}</option>
                                                @endforeach
                                            </select>
                                            @error('pan_details.'.$index.'.last_filed_year')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <label class="form-label fw-semibold">
                                        Income Declared (Last 5 Financial Years)
                                    </label>

                                    <div class="row g-2">
                                        @foreach ($financial_years as $year)
                                            <div class="col-md-2">
                                                <label class="small text-muted">{{ $year }}</label>
                                                <input type="number"
                                                    class="form-control"
                                                    wire:model.defer="pan_details.{{ $index }}.income.{{ $year }}">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        @endforeach

                        <div class="text-center mb-2">
                            <button type="button"
                                class="btn btn-outline-primary btn-sm px-4"
                                wire:click="addPanRow">
                                <i class="bi bi-plus-circle"></i> Add PAN
                            </button>
                        </div>


                    <h5 class="text-primary mt-4">Movable Assets</h5>

                        @foreach ($movable_assets as $aIndex => $asset)

                        <div class="card mb-3 shadow-sm position-relative">
                            <div class="card-body">

                                @if($aIndex > 0)
                                    <button type="button"
                                        class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 m-2"
                                        wire:click="removeMovableAssetType({{ $aIndex }})">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                @endif

                                <div class="mb-3 col-md-4">
                                    <label class="form-label text-primary">Asset Type</label>
                                    <select class="form-select"
                                        wire:model.defer="movable_assets.{{ $aIndex }}.type">
                                        <option value="">Select</option>
                                        <option value="cash">Cash</option>
                                        <option value="bank_deposit">Bank Deposit</option>
                                        <option value="securities">Securities</option>
                                        <option value="postal_investment">Postal / Insurance</option>
                                        <option value="loan_given">Loan Given</option>
                                        <option value="vehicle">Vehicle</option>
                                        <option value="jewellery">Jewellery</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>

                                @foreach($asset['holders'] as $hIndex => $holder)

                                <div class="border rounded p-3 mb-2">

                                    <div class="d-flex justify-content-between">
                                        <span class="badge bg-secondary">
                                            Holder {{ $hIndex + 1 }}
                                        </span>

                                        @if($hIndex > 0)
                                        <button type="button" 
                                            class="btn btn-sm btn-outline-danger"
                                            wire:click="removeMovableHolder({{ $aIndex }}, {{ $hIndex }})">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                        @endif
                                    </div>

                                    <div class="row g-2 mt-2">

                                        <div class="col-md-3">
                                            <label class="form-label text-primary">Holder</label>
                                            <select class="form-select"
                                                wire:model.defer="movable_assets.{{ $aIndex }}.holders.{{ $hIndex }}.holder">
                                                <option value="">Select Holder</option>
                                                <option value="self">Self</option>
                                                <option value="spouse">Spouse</option>
                                                <option value="huf">HUF</option>
                                                <option value="dependent_1">Dependent 1</option>
                                                <option value="dependent_2">Dependent 2</option>
                                                <option value="dependent_3">Dependent 3</option>
                                            </select>
                                        </div>

                                        <div class="col-md-5">
                                            <label class="form-label text-primary">Description</label>
                                            <textarea class="form-control"
                                                wire:model.defer="movable_assets.{{ $aIndex }}.holders.{{ $hIndex }}.description">
                                            </textarea>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label text-primary">Total Amount</label>
                                            <input type="text"
                                                class="form-control"
                                                wire:model="movable_assets.{{ $aIndex }}.holders.{{ $hIndex }}.amount">
                                        </div>

                                    </div>
                                </div>

                                @endforeach

                                <div class="text-end mt-2">
                                    <button type="button"
                                        class="btn btn-outline-success btn-sm"
                                        wire:click="addMovableHolder({{ $aIndex }})">
                                        <i class="bi bi-plus-circle"></i> Add Holder
                                    </button>
                                </div>

                            </div>
                        </div>

                        @endforeach

                        <div class="text-center">
                            <button type="button"
                                class="btn btn-outline-primary btn-sm px-4"
                                wire:click="addMovableAssetType">
                                <i class="bi bi-plus-circle"></i> Add Asset Type
                            </button>
                        </div>

                        <h5 class="text-primary mt-4">Immovable Assets</h5>

                            @foreach ($immovable_assets as $aIndex => $asset)
                                <div wire:key="immovable-{{ $aIndex }}">

                                    <div class="card mb-3 shadow-sm position-relative">
                                        <div class="card-body">

                                            @if($aIndex > 0)
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 m-2"
                                                    wire:click="removeImmovableAssetType({{ $aIndex }})">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            @endif

                                            <!-- Asset Type -->
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label class="form-label text-primary">Asset Type</label>
                                                    <select class="form-select"
                                                        wire:model="immovable_assets.{{ $aIndex }}.type"
                                                        wire:change="typeChanged({{ $aIndex }})">
                                                        <option value="">Select</option>
                                                        <option value="agricultural">Agricultural Land</option>
                                                        <option value="non_agricultural">Non-Agricultural Land</option>
                                                        <option value="commercial">Commercial Building</option>
                                                        <option value="residential">Residential Building</option>
                                                        <option value="others">Others</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-8">
                                                    <label class="form-label text-primary">Description</label>

                                                    @if(($immovable_assets[$aIndex]['type'] ?? '') === 'others')
                                                        <textarea class="form-control"
                                                            wire:key="description-{{ $aIndex }}-others"
                                                            wire:model="immovable_assets.{{ $aIndex }}.description">
                                                        </textarea>
                                                    @else
                                                        <select class="form-select"
                                                            wire:key="description-{{ $aIndex }}-{{ $immovable_assets[$aIndex]['type'] ?? 'none' }}"
                                                            wire:model.defer="immovable_assets.{{ $aIndex }}.description">
                                                            <option value="">Select Description</option>
                                                            @foreach(
                                                                $this->getImmovableDescriptionOptions(
                                                                    $immovable_assets[$aIndex]['type'] ?? ''
                                                                ) as $key => $label
                                                            )
                                                                <option value="{{ $key }}">{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Holders -->
                                            @foreach($asset['holders'] as $hIndex => $holder)

                                            <div class="border rounded p-3 mb-2">
                                                <div class="d-flex justify-content-between">
                                                    <span class="badge bg-secondary">
                                                        Holder {{ $hIndex + 1 }}
                                                    </span>

                                                    @if($hIndex > 0)
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger"
                                                        wire:click="removeImmovableHolder({{ $aIndex }}, {{ $hIndex }})">
                                                        <i class="bi bi-x-lg"></i>
                                                    </button>
                                                    @endif
                                                </div>

                                                <div class="row g-2 mt-2">

                                                    <div class="col-md-3">
                                                        <label class="form-label text-primary">Holder</label>
                                                        <select class="form-select"
                                                            wire:model.defer="immovable_assets.{{ $aIndex }}.holders.{{ $hIndex }}.holder">
                                                            <option value="">Select Holder</option>
                                                            <option value="self">Self</option>
                                                            <option value="spouse">Spouse</option>
                                                            <option value="huf">HUF</option>
                                                            <option value="dependent_1">Dependent 1</option>
                                                            <option value="dependent_2">Dependent 2</option>
                                                            <option value="dependent_3">Dependent 3</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label text-primary">Details</label>
                                                        <textarea class="form-control"
                                                            wire:model.defer="immovable_assets.{{ $aIndex }}.holders.{{ $hIndex }}.details">
                                                        </textarea>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label class="form-label text-primary">Total Amount</label>
                                                        <input type="number"
                                                            class="form-control"
                                                            wire:model.defer="immovable_assets.{{ $aIndex }}.holders.{{ $hIndex }}.amount">
                                                    </div>

                                                </div>

                                            </div>

                                            @endforeach

                                            <div class="text-end mt-2">
                                                <button type="button"
                                                    class="btn btn-outline-success btn-sm"
                                                    wire:click="addImmovableHolder({{ $aIndex }})">
                                                    <i class="bi bi-plus-circle"></i> Add Holder
                                                </button>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            @endforeach

                            <div class="text-center">
                                <button type="button"
                                    class="btn btn-outline-primary btn-sm px-4"
                                    wire:click="addImmovableAssetType">
                                    <i class="bi bi-plus-circle"></i> Add Asset Type
                                </button>
                            </div>

                        <h5 class="text-primary mt-2">Loans / Liabilities</h5>

                        @foreach($loan_holders as $hIndex => $holder)
                        <div class="card mb-1 shadow-sm position-relative">
                            <div class="card-body">

                                @if($hIndex > 0)
                                    <button type="button"
                                        class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 m-2"
                                        wire:click="removeLoanHolder({{ $hIndex }})">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                @endif

                                <!-- Holder -->
                                <div class="mb-3 col-md-4">
                                    <label class="form-label text-primary">Holder</label>
                                    <select class="form-select"
                                        wire:model.defer="loan_holders.{{ $hIndex }}.holder">
                                        <option value="">Select</option>
                                        <option value="self">Self</option>
                                        <option value="spouse">Spouse</option>
                                        <option value="huf">HUF</option>
                                        <option value="dependent_1">Dependent 1</option>
                                        <option value="dependent_2">Dependent 2</option>
                                        <option value="dependent_3">Dependent 3</option>
                                    </select>
                                </div>

                                @foreach($holder['loans'] as $lIndex => $loan)
                                <div class="border rounded p-3 mb-3 shadow-sm">

                                    <div class="d-flex justify-content-between">
                                        <span class="badge bg-secondary">Loan {{ $lIndex + 1 }}</span>

                                        @if($lIndex > 0)
                                            <button type="button"
                                                class="btn btn-sm btn-outline-danger"
                                                wire:click="removeLoanRow({{ $hIndex }}, {{ $lIndex }})">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        @endif
                                    </div>

                                    <div class="row g-2 mt-2">

                                        <div class="col-md-3">
                                            <label class="form-label text-primary">Loan Type</label>
                                            <select class="form-select"
                                                wire:model.defer="loan_holders.{{ $hIndex }}.loans.{{ $lIndex }}.type">
                                                <option value="">Select Type</option>
                                                <option value="bank">Bank</option>
                                                <option value="individual">Individual</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label text-primary">Name</label>
                                            <input class="form-control"
                                                wire:model.defer="loan_holders.{{ $hIndex }}.loans.{{ $lIndex }}.name">
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label text-primary">Amount</label>
                                            <input class="form-control" type="number"
                                                wire:model.defer="loan_holders.{{ $hIndex }}.loans.{{ $lIndex }}.amount">
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label text-primary">Nature</label>
                                            <input class="form-control"
                                                wire:model.defer="loan_holders.{{ $hIndex }}.loans.{{ $lIndex }}.nature">
                                        </div>

                                    </div>
                                </div>
                                @endforeach

                                <div class="text-end">
                                    <button type="button"
                                        class="btn btn-outline-success btn-sm"
                                        wire:click="addLoanRow({{ $hIndex }})">
                                        <i class="bi bi-plus-circle"></i> Add Loan
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="text-center mb-2">
                            <button type="button"
                                class="btn btn-outline-primary btn-sm px-4"
                                wire:click="addLoanHolder">
                                <i class="bi bi-person-plus"></i> Add Holder
                            </button>
                        </div>

                    <h5 class="text-primary mt-2">Government Dues</h5>

                    @foreach($government_dues as $gIndex => $due)
                    <div class="card mb-1 shadow-sm position-relative">
                        <div class="card-body">

                            @if($gIndex > 0)
                                <button class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 m-2"
                                    wire:click="removeGovernmentDue({{ $gIndex }})">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            @endif

                            <!-- Holder -->
                            <div class="mb-3 col-md-4">
                                <label class="form-label text-primary">Holder</label>
                                <select class="form-select"
                                    wire:model.defer="government_dues.{{ $gIndex }}.holder">
                                    <option value="">Select</option>
                                    <option value="self">Self</option>
                                    <option value="spouse">Spouse</option>
                                    <option value="huf">HUF</option>
                                    <option value="dependent_1">Dependent 1</option>
                                    <option value="dependent_2">Dependent 2</option>
                                    <option value="dependent_3">Dependent 3</option>
                                </select>
                            </div>

                            <div class="row g-2">
                                <div class="col-md-3">
                                    <label class="form-label text-primary">Income Tax</label>
                                    <input class="form-control" type="number"
                                        wire:model.defer="government_dues.{{ $gIndex }}.income_tax">
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label text-primary">GST</label>
                                    <input class="form-control" type="number"
                                        wire:model.defer="government_dues.{{ $gIndex }}.gst">
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label text-primary">Property Tax</label>
                                    <input class="form-control" type="number"
                                        wire:model.defer="government_dues.{{ $gIndex }}.property_tax">
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label text-primary">Other Dues</label>
                                    <input class="form-control" type="number"
                                        wire:model.defer="government_dues.{{ $gIndex }}.other_dues">
                                </div>

                                <div class="col-md-12 mt-2">
                                    <label class="form-label text-primary">Dispute Details</label>
                                    <textarea class="form-control"
                                        wire:model.defer="government_dues.{{ $gIndex }}.dispute_details"></textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                    @endforeach

                    <div class="text-center mb-2">
                            <button type="button"
                                class="btn btn-outline-primary btn-sm px-4"
                                wire:click="addGovernmentDue">
                                <i class="bi bi-plus-circle"></i> Add Holder
                            </button>
                    </div>

                    <div class="col-md-12">
                        <h5 class="text-primary mt-2">Profession / Occupation</h5>

                        <div class="ms-3">
                            <div class="mb-2">
                                <label class="form-label text-primary">Self</label>
                                <input type="text"
                                    class="form-control"
                                    wire:model.defer="candidate_occupation">
                            </div>

                            <div class="mb-2">
                                <label class="form-label text-primary">Spouse</label>
                                <input type="text"
                                    class="form-control"
                                    wire:model.defer="spouse_occupation">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mt-3">
                        <h5 class="text-primary mt-2">Source(s) of Income</h5>

                        <div class="ms-3">
                            <div class="mb-2">
                                <label class="form-label text-primary">Self</label>
                                <input type="text"
                                    class="form-control"
                                    wire:model.defer="source_of_incomes.self">
                            </div>

                            <div class="mb-2">
                                <label class="form-label text-primary">Spouse</label>
                                <input type="text"
                                    class="form-control"
                                    wire:model.defer="source_of_incomes.spouse">
                            </div>

                            <div class="mb-2">
                                <label class="form-label text-primary">Dependents</label>
                                <input type="text"
                                    class="form-control"
                                    wire:model.defer="source_of_incomes.dependents">
                            </div>
                        </div>
                    </div>
                        <div class="col-md-12 mt-3">
                            <h5 class="text-primary mt-2">Educational Qualifications</h5>

                            @foreach($educational_qualifications as $index => $edu)
                                <div class="border rounded p-3 mb-3 bg-white shadow-sm position-relative">

                                    <!-- Remove Button -->
                                    @if($index > 0)
                                        <button type="button"
                                            class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 m-2"
                                            wire:click="removeQualification({{ $index }})">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    @endif

                                    <div class="row g-2 mt-2">

                                        <!-- Qualification Level Dropdown -->
                                        <div class="col-md-3">
                                            <label class="form-label text-primary">Qualification Level</label>
                                            <select class="form-select"
                                                wire:model.defer="educational_qualifications.{{ $index }}.level">
                                                <option value="">Select Level</option>
                                                <option value="Master">Master</option>
                                                <option value="Bachelor">Bachelor</option>
                                                <option value="Higher Secondary (12th)">Higher Secondary (12th)</option>
                                                <option value="Secondary (10th)">Secondary (10th)</option>
                                            </select>
                                        </div>

                                        <!-- Degree / Course -->
                                        <div class="col-md-3">
                                            <label class="form-label text-primary">Degree / Course</label>
                                            <input type="text"
                                                class="form-control"
                                                wire:model.defer="educational_qualifications.{{ $index }}.degree">
                                        </div>

                                        <!-- University / Institution -->
                                        <div class="col-md-4">
                                            <label class="form-label text-primary">University / Institution</label>
                                            <input type="text"
                                                class="form-control"
                                                wire:model.defer="educational_qualifications.{{ $index }}.university">
                                        </div>

                                        <!-- Year of Passing -->
                                        <div class="col-md-2">
                                            <label class="form-label text-primary">Year of Passing</label>
                                            <input type="number"
                                                class="form-control"
                                                wire:model.defer="educational_qualifications.{{ $index }}.year">
                                        </div>

                                    </div>

                                </div>
                            @endforeach

                            <div class="text-center mb-2">
                                <button type="button" class="btn btn-outline-primary btn-sm px-4" wire:click="addQualification">
                                    <i class="bi bi-plus-circle"></i> Add Qualification
                                </button>
                            </div>
                        </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Save & Preview
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

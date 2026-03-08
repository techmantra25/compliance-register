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
                        <label class="form-label text-primary small text-muted">Relation</label>
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
                        <label class="form-label text-primary small text-muted">Age</label>
                        <input type="number" class="form-control" wire:model.defer="age">
                        @error('age') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label text-primary small text-muted">Address</label>
                        <textarea class="form-control" wire:model.defer="address" rows="2"></textarea>
                        @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label text-primary small text-muted">Enrolled Constituency Name</label>
                        <input type="text" class="form-control" wire:model.defer="enrolled_constituency_name">
                        @error('enrolled_constituency_name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label text-primary small text-muted">Constituency Serial No</label>
                        <input type="text" class="form-control" wire:model.defer="constituency_serial_no">
                        @error('constituency_serial_no') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                     <div class="col-md-6">
                        <label class="form-label text-primary small text-muted">Constituency Part No</label>
                        <input type="text" class="form-control" wire:model.defer="constituency_part_no">
                        @error('constituency_part_no') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label text-primary small text-muted">Phone No</label>
                        <input type="number" class="form-control" wire:model.defer="phone_no" min="0">
                        @error('phone_no') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-primary small text-muted">Alternative Phone No</label>
                        <input type="number" class="form-control" wire:model.defer="alternative_phone_no" min="0">
                        @error('alternative_phone_no') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label text-primary small text-muted">Email</label>
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
                                <label for="whatsapp_no" class="form-label text-primary small text-muted">WhatsApp Number</label>
                                <input type="number"
                                    id="whatsapp_no"
                                    class="form-control"
                                    wire:model.defer="whatsapp_no"
                                    min="0">
                                @error('whatsapp_no') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="facebook_account" class="form-label text-primary small text-muted">Facebook Account</label>
                                <input type="text"
                                    id="facebook_account"
                                    class="form-control"
                                    wire:model.defer="facebook_account">
                                @error('facebook_account') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="twitter_account" class="form-label text-primary small text-muted">Twitter Account</label>
                                <input type="text"
                                    id="twitter_account"
                                    class="form-control"
                                    wire:model.defer="twitter_account">
                                @error('twitter_account') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="linked_in" class="form-label text-primary small text-muted">LinkedIn Account</label>
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
                                            <label class="form-label text-primary small text-muted">Holder</label>
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
                                            <label class="form-label text-primary small text-muted">Name</label>
                                            <input type="text"
                                                class="form-control"
                                                wire:model.defer="pan_details.{{ $index }}.name">
                                                @error('pan_details.'.$index.'.name')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label text-primary small text-muted">PAN</label>
                                            <input type="text"
                                                class="form-control text-uppercase"
                                                wire:model.defer="pan_details.{{ $index }}.pan">
                                                @error('pan_details.'.$index.'.pan')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label text-primary small text-muted">Last ITR Filed (FY)</label>
                                           <select class="form-select"
                                                    wire:model="pan_details.{{ $index }}.last_filed_year"
                                                    wire:change="updateIncomeYears({{ $index }})">
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
                                        @foreach (($pan_details[$index]['income'] ?? []) as $year => $value)
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
                                    <label class="form-label text-primary small text-muted">Asset Type</label>
                                    <select class="form-select"
                                        wire:model.defer="movable_assets.{{ $aIndex }}.type">
                                        <option value="">Select</option>
                                        <option value="cash">I. Cash</option>
                                        <option value="bank_deposit">II. Bank Deposit</option>
                                        <option value="securities">III. Securities</option>
                                        <option value="postal_investment">IV. Postal / Insurance</option>
                                        <option value="loan_given">V. Loan Given</option>
                                        <option value="vehicle">VI. Vehicle</option>
                                        <option value="jewellery">VII. Jewellery</option>
                                        <option value="other">VIII. Other</option>
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
                                            <label class="form-label text-primary small text-muted">Holder</label>
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
                                            <label class="form-label text-primary small text-muted">Description</label>
                                            <textarea class="form-control"
                                                wire:model.defer="movable_assets.{{ $aIndex }}.holders.{{ $hIndex }}.description">
                                            </textarea>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label text-primary small text-muted">Total Amount</label>
                                            <input type="number"
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
                                                    <label class="form-label text-primary small text-muted">Asset Type</label>
                                                    <select class="form-select"
                                                        wire:model="immovable_assets.{{ $aIndex }}.type"
                                                        wire:change="typeChanged({{ $aIndex }})">
                                                        <option value="">Select</option>
                                                        <option value="agricultural">I. Agricultural Land</option>
                                                        <option value="non_agricultural">II. Non-Agricultural Land</option>
                                                        <option value="commercial">III. Commercial Building</option>
                                                        <option value="residential">IV. Residential Building</option>
                                                        <option value="others">V. Others</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-8">
                                                    <label class="form-label text-primary small text-muted">Description</label>

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
                                                        <label class="form-label text-primary small text-muted">Holder</label>
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
                                                        <label class="form-label text-primary small text-muted">Details</label>
                                                        <textarea class="form-control"
                                                            wire:model.defer="immovable_assets.{{ $aIndex }}.holders.{{ $hIndex }}.details">
                                                        </textarea>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label class="form-label text-primary small text-muted">Total Amount</label>
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

                                @foreach($loan_types as $tIndex => $loanType)

                                <div class="card mb-3 shadow-sm position-relative">
                                    <div class="card-body">

                                        @if($tIndex > 0)
                                            <button type="button"
                                            class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 m-2"
                                            wire:click="removeLoanType({{ $tIndex }})">
                                            <i class="bi bi-x-lg"></i>
                                            </button>
                                        @endif

                                            <!-- Loan Type -->
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label text-primary small text-muted">Loan Type</label>
                                                    <select class="form-select"
                                                    wire:model.defer="loan_types.{{ $tIndex }}.type">

                                                        <option value="">Select Type</option>
                                                        <option value="bank">Bank / Financial Institution</option>
                                                        <option value="individual">Individual / Entity</option>
                                                        <option value="liability">Other Liability</option>

                                                    </select>
                                                </div>

                                                @foreach($loanType['holders'] as $hIndex => $holder)

                                                    <div class="border rounded p-3 mb-2">

                                                        <div class="d-flex justify-content-between">
                                                            <span class="badge bg-secondary">
                                                            Holder {{ $hIndex + 1 }}
                                                            </span>

                                                            @if($hIndex > 0)
                                                            <button type="button"
                                                            class="btn btn-sm btn-outline-danger"
                                                            wire:click="removeLoanHolder({{ $tIndex }},{{ $hIndex }})">
                                                            <i class="bi bi-x-lg"></i>
                                                            </button>
                                                            @endif

                                                    </div>

                                                <div class="row g-2 mt-2">

                                                    <div class="col-md-3">
                                                        <label class="form-label text-primary small text-muted">Holder</label>
                                                        <select class="form-select"
                                                        wire:model.defer="loan_types.{{ $tIndex }}.holders.{{ $hIndex }}.holder">

                                                            <option value="">Select</option>
                                                            <option value="self">Self</option>
                                                            <option value="spouse">Spouse</option>
                                                            <option value="huf">HUF</option>
                                                            <option value="dependent_1">Dependent 1</option>
                                                            <option value="dependent_2">Dependent 2</option>
                                                            <option value="dependent_3">Dependent 3</option>

                                                        </select>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label text-primary small text-muted">Description</label>
                                                        <textarea
                                                            class="form-control"
                                                            wire:model.defer="loan_types.{{ $tIndex }}.holders.{{ $hIndex }}.description">
                                                        </textarea>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label class="form-label text-primary small text-muted">Total Amount</label>
                                                        <input type="number"
                                                        class="form-control"
                                                        wire:model.defer="loan_types.{{ $tIndex }}.holders.{{ $hIndex }}.amount">
                                                    </div>

                                                </div>
                                            </div>

                                         @endforeach

                                                <div class="text-end">
                                                    <button type="button"
                                                    class="btn btn-outline-success btn-sm"
                                                    wire:click="addLoanHolder({{ $tIndex }})">

                                                    <i class="bi bi-plus-circle"></i>
                                                    Add Holder

                                                    </button>
                                                </div>

                                    </div>
                                </div>

                                @endforeach

                                <div class="text-center mb-2">
                                <button type="button"
                                class="btn btn-outline-primary btn-sm px-4"
                                wire:click="addLoanType">

                                <i class="bi bi-plus-circle"></i>
                                Add Loan Type

                                </button>
                            </div>

                    <h5 class="text-primary mt-2">Government Dues</h5>

                    @foreach($government_dues as $dIndex => $due)

                        <div class="card mb-3 shadow-sm position-relative">
                        <div class="card-body">

                        @if($dIndex > 0)
                        <button type="button" class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 m-2"
                                wire:click="removeGovernmentDueType({{ $dIndex }})">
                        <i class="bi bi-x-lg"></i>
                        </button>
                        @endif

                        <!-- Dues Type -->
                        <div class="mb-3 col-md-4">
                        <label class="form-label text-primary small text-muted">Dues Type</label>

                        <select class="form-select"
                        wire:model.defer="government_dues.{{ $dIndex }}.type">

                        <option value="">Select</option>
                        <option value="income_tax">Income Tax</option>
                        <option value="gst">GST</option>
                        <option value="property_tax">Municipal/Property Tax</option>
                        <option value="other">Other Dues</option>

                        </select>
                        </div>


                        {{-- HOLDERS --}}
                        @foreach($due['holders'] as $hIndex => $holder)

                        <div class="border rounded p-3 mb-2 position-relative">

                        @if($hIndex > 0)
                            <button type="button" class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 m-1"
                                wire:click="removeGovernmentDueHolder({{ $dIndex }},{{ $hIndex }})">
                                <i class="bi bi-x"></i>
                             </button>
                        @endif

                            <div class="row g-2">

                                <div class="col-md-3">
                                    <label class="form-label text-primary small text-muted">Holder</label>
                                    <select class="form-select"
                                    wire:model.defer="government_dues.{{ $dIndex }}.holders.{{ $hIndex }}.holder">

                                        <option value="">Select</option>
                                        <option value="self">Self</option>
                                        <option value="spouse">Spouse</option>
                                        <option value="huf">HUF</option>
                                        <option value="dependent_1">Dependent 1</option>
                                        <option value="dependent_2">Dependent 2</option>
                                        <option value="dependent_3">Dependent 3</option>

                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label text-primary small text-muted">Description</label>
                                    <textarea
                                        class="form-control"
                                        wire:model.defer="government_dues.{{ $dIndex }}.holders.{{ $hIndex }}.description"></textarea>
                                </div>


                                <div class="col-md-3">
                                    <label class="form-label text-primary small text-muted">Total Amount</label>
                                    <input type="number"
                                    class="form-control"
                                    wire:model.defer="government_dues.{{ $dIndex }}.holders.{{ $hIndex }}.amount">
                                </div>

                            </div>

                        </div>

                        @endforeach


                        <!-- ADD HOLDER -->
                        <div class="text-end mt-2">
                        <button type="button"
                        class="btn btn-outline-success btn-sm"
                        wire:click="addGovernmentDueHolder({{ $dIndex }})">

                        <i class="bi bi-plus-circle"></i> Add Holder

                        </button>
                        </div>

                        </div>
                        </div>

                        @endforeach


                        <!-- ADD DUES TYPE -->
                        <div class="text-center">
                        <button type="button" class="btn btn-outline-primary btn-sm px-4"
                        wire:click="addGovernmentDueType">

                        <i class="bi bi-plus-circle"></i> Add Dues Type

                        </button>
                    </div>

                    <div class="col-md-12">
                        <h5 class="text-primary mt-2">Profession / Occupation</h5>

                        <div class="ms-3">
                            <div class="mb-2">
                                <label class="form-label text-primary small text-muted">Self</label>
                                <input type="text"
                                    class="form-control"
                                    wire:model.defer="candidate_occupation">
                            </div>

                            <div class="mb-2">
                                <label class="form-label text-primary small text-muted">Spouse</label>
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
                                <label class="form-label text-primary small text-muted">Self</label>
                                <input type="text"
                                    class="form-control"
                                    wire:model.defer="source_of_incomes.self">
                            </div>

                            <div class="mb-2">
                                <label class="form-label text-primary small text-muted">Spouse</label>
                                <input type="text"
                                    class="form-control"
                                    wire:model.defer="source_of_incomes.spouse">
                            </div>

                            <div class="mb-2">
                                <label class="form-label text-primary small text-muted">Dependents</label>
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

                                        <!-- Degree / Course -->
                                        <div class="col-md-4">
                                            <label class="form-label text-primary small text-muted">Degree / Course</label>
                                            <input type="text"
                                                class="form-control"
                                                wire:model.defer="educational_qualifications.{{ $index }}.degree">
                                        </div>

                                        <!-- University / Institution -->
                                        <div class="col-md-5">
                                            <label class="form-label text-primary small text-muted">University / Institution</label>
                                            <input type="text"
                                                class="form-control"
                                                wire:model.defer="educational_qualifications.{{ $index }}.university">
                                        </div>

                                        <!-- Year of Passing -->
                                        <div class="col-md-3">
                                            <label class="form-label text-primary small text-muted">Year of Passing</label>
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

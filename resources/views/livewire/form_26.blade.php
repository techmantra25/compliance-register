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
                        <label class="form-label">Relation</label>
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
                        <label class="form-label">Age</label>
                        <input type="number" class="form-control" wire:model.defer="age">
                        @error('age') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Address</label>
                        <textarea class="form-control" wire:model.defer="address" rows="2"></textarea>
                        @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Enrolled Constituency Name</label>
                        <input type="text" class="form-control" wire:model.defer="enrolled_constituency_name">
                        @error('enrolled_constituency_name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Constituency Serial No</label>
                        <input type="text" class="form-control" wire:model.defer="constituency_serial_no">
                        @error('constituency_serial_no') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                     <div class="col-md-6">
                        <label class="form-label">Constituency Part No</label>
                        <input type="text" class="form-control" wire:model.defer="constituency_part_no">
                        @error('constituency_part_no') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Phone No</label>
                        <input type="number" class="form-control" wire:model.defer="phone_no" min="0">
                        @error('phone_no') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Alternative Phone No</label>
                        <input type="number" class="form-control" wire:model.defer="alternative_phone_no" min="0">
                        @error('alternative_phone_no') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
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
                                <input type="number"
                                    class="form-control"
                                    wire:model.defer="whatsapp_no"
                                    placeholder="WhatsApp Number"
                                    min="0">
                                @error('whatsapp_no') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                            <div class="col-md-4">
                                <input type="text"
                                    class="form-control"
                                    wire:model.defer="facebook_account"
                                    placeholder="Facebook Account">
                                @error('facebook_account') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-4">
                                <input type="text"
                                    class="form-control"
                                    wire:model.defer="twitter_account"
                                    placeholder="Twitter Account">
                                @error('twitter_account') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                    </div>

                    <h5 class="text-primary mt-4">PAN and ITR Details</h5>

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
                                            <label class="form-label">Holder</label>
                                            <select class="form-select"
                                                wire:model.defer="pan_details.{{ $index }}.type">
                                                <option value="">Select</option>
                                                <option value="self">Self</option>
                                                <option value="spouse">Spouse</option>
                                                <option value="huf">HUF</option>
                                                <option value="dependent">Dependent</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">Name</label>
                                            <input type="text"
                                                class="form-control"
                                                wire:model.defer="pan_details.{{ $index }}.name">
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">PAN</label>
                                            <input type="text"
                                                class="form-control text-uppercase"
                                                wire:model.defer="pan_details.{{ $index }}.pan">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">Last ITR Filed (FY)</label>
                                            <select class="form-select"
                                                wire:model.defer="pan_details.{{ $index }}.last_filed_year">
                                                <option value="">Select</option>
                                                <option value="2019-20">2019-20</option>
                                                <option value="2018-19">2018-19</option>
                                                <option value="2017-18">2017-18</option>
                                                <option value="2016-17">2016-17</option>
                                                <option value="2015-16">2015-16</option>
                                            </select>
                                        </div>
                                    </div>

                                    <label class="form-label fw-semibold">
                                        Income Declared (Last 5 Financial Years)
                                    </label>

                                    <div class="row g-2">
                                        {{-- @foreach ($row['income'] as $year => $value)
                                            <div class="col-md-2">
                                                <label class="small text-muted">{{ $year }}</label>
                                                <input type="number"
                                                    class="form-control"
                                                    wire:model.defer="pan_details.{{ $index }}.income.{{ $year }}">
                                            </div>
                                        @endforeach --}}
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

                        @foreach ($asset_holders as $hIndex => $holderBlock)
                        <div class="card mb-1 shadow-sm position-relative">
                            <div class="card-body">

                                @if($hIndex > 0)
                                    <button type="button"
                                        class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 m-2"
                                        wire:click="removeAssetHolder({{ $hIndex }})">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                @endif

                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Holder</label>
                                    <select class="form-select"
                                        wire:model.defer="asset_holders.{{ $hIndex }}.holder">
                                        <option value="">Select</option>
                                        <option value="self">Self</option>
                                        <option value="spouse">Spouse</option>
                                        <option value="huf">HUF</option>
                                        <option value="dependent">Dependent</option>
                                    </select>
                                </div>

                                @foreach ($holderBlock['assets'] as $aIndex => $asset)

                                <div class="border rounded p-3 mb-3 bg-white shadow-sm">

                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge bg-secondary">
                                            Asset {{ $aIndex + 1 }}
                                        </span>

                                        @if($aIndex > 0)
                                            <button type="button"
                                                class="btn btn-sm btn-outline-danger"
                                                wire:click="removeAssetRow({{ $hIndex }}, {{ $aIndex }})">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        @endif
                                    </div>

                                    <div class="row g-2">
                                        <div class="col-md-4">
                                            <label class="form-label">Asset Type</label>
                                            <select class="form-select"
                                                wire:model.defer="asset_holders.{{ $hIndex }}.assets.{{ $aIndex }}.type">
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

                                        <div class="col-md-5">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control"
                                                wire:model.defer="asset_holders.{{ $hIndex }}.assets.{{ $aIndex }}.description"></textarea>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">Amount (₹)</label>
                                            <input type="number" class="form-control"
                                                wire:model.defer="asset_holders.{{ $hIndex }}.assets.{{ $aIndex }}.amount">
                                        </div>
                                    </div>

                                </div>
                                @endforeach

                                <div class="text-end">
                                    <button type="button"
                                        class="btn btn-outline-success btn-sm"
                                        wire:click="addAssetRow({{ $hIndex }})">
                                        <i class="bi bi-plus-circle"></i> Add Asset
                                    </button>
                                </div>

                            </div>
                        </div>
                        @endforeach

                        <div class="text-center mb-2">
                            <button type="button"
                                class="btn btn-outline-primary btn-sm px-4"
                                wire:click="addAssetHolder">
                                <i class="bi bi-person-plus"></i> Add Holder
                            </button>
                        </div>


                   <h5 class="mt-4 text-primary">Immovable Assets</h5>

                        @foreach($immovable_assets as $hIndex => $holderBlock)
                        <div class="card mb-1 shadow-sm">
                            <div class="card-body">

                                <div class="mb-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Holder</label>
                                        <select class="form-select"
                                            wire:model.defer="immovable_assets.{{ $hIndex }}.holder">
                                            <option value="">Select</option>
                                            <option value="self">Self</option>
                                            <option value="spouse">Spouse</option>
                                            <option value="huf">HUF</option>
                                            <option value="dependent">Dependent</option>
                                        </select>
                                    </div>
                                </div>

                                    @foreach($holderBlock['groups'] as $gIndex => $group)

                                    <div class="border rounded p-3 mb-3 bg-white shadow-sm">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="badge bg-secondary">
                                                Asset {{ $gIndex + 1 }}
                                            </span>
                                        </div>

                                            <strong>Agricultural Land</strong>
                                            <div class="row g-2 mt-1 mb-3">

                                            <div class="col-md-3">
                                                <input class="form-control" placeholder="Location / Survey No."
                                                    wire:model.defer="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.agricultural.location">
                                            </div>
                                            
                                            <div class="col-md-2">
                                                <input class="form-control" placeholder="Area (Acres)"
                                                    wire:model.defer="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.agricultural.area">
                                            </div>
                                            <div class="col-md-2">
                                                <select class="form-select"
                                                    wire:model.defer="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.agricultural.inherited">
                                                    <option value="">Inherited?</option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                               <input type="date" class="form-control"
                                                     wire:model.defer="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.agricultural.purchase_date">
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" class="form-control" placeholder="Purchase Cost"
                                                    wire:model.defer="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.agricultural.purchase_cost">
                                            </div>
                                            <div class="col-md-2">
                                                <input class="form-control" placeholder="Investment Made"
                                                    wire:model.defer="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.agricultural.investment_made">
                                            </div>
                                            <div class="col-md-3">
                                                <input class="form-control" placeholder="Current Market Value"
                                                    wire:model.defer="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.agricultural.current_value">
                                            </div>
                                        </div>

                                        <strong>Non-Agricultural Land</strong>
                                        <div class="row g-2 mt-1 mb-3">

                                            <div class="col-md-3">
                                                <input class="form-control" placeholder="Location / Survey No."
                                                    wire:model.defer="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.non_agricultural.location">
                                            </div>

                                            <div class="col-md-2">
                                                <input class="form-control" placeholder="Area (Acres)"
                                                    wire:model.defer="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.non_agricultural.area">
                                            </div>

                                            <div class="col-md-2">
                                                <select class="form-select"
                                                    wire:model.defer="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.non_agricultural.inherited">
                                                    <option value="">Inherited?</option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>

                                            <div class="col-md-2">
                                                <input type="date" class="form-control"
                                                    wire:model.defer="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.non_agricultural.purchase_date">
                                            </div>

                                            <div class="col-md-2">
                                                <input type="number" class="form-control" placeholder="Purchase Cost"
                                                    wire:model.defer="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.non_agricultural.purchase_cost">
                                            </div>

                                            <div class="col-md-2">
                                                <input class="form-control" placeholder="Investment Made"
                                                    wire:model.defer="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.non_agricultural.investment_made">
                                            </div>

                                            <div class="col-md-3">
                                                <input class="form-control" placeholder="Current Market Value"
                                                    wire:model.defer="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.non_agricultural.current_value">
                                            </div>

                                        </div>


                                        {{-- COMMERCIAL --}}
                                      <strong>Commercial Buildings</strong>
                                        <div class="row g-2 mt-1 mb-3">

                                            <div class="col-md-3">
                                                <input class="form-control" placeholder="Location / Survey No."
                                                    wire:model.defer="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.commercial.location">
                                            </div>

                                            <div class="col-md-2">
                                                <input class="form-control" placeholder="Area (Sq.Ft / Acres)"
                                                    wire:model.defer="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.commercial.area">
                                            </div>

                                            <div class="col-md-2">
                                                <select class="form-select"
                                                    wire:model.defer="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.commercial.inherited">
                                                    <option value="">Inherited?</option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>

                                            <div class="col-md-2">
                                                <input type="date" class="form-control"
                                                    wire:model.defer="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.commercial.purchase_date">
                                            </div>

                                            <div class="col-md-2">
                                                <input type="number" class="form-control" placeholder="Purchase Cost"
                                                    wire:model.defer="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.commercial.purchase_cost">
                                            </div>

                                            <div class="col-md-2">
                                                <input class="form-control" placeholder="Investment Made"
                                                    wire:model.defer="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.commercial.investment_made">
                                            </div>

                                            <div class="col-md-3">
                                                <input class="form-control" placeholder="Current Market Value"
                                                    wire:model.defer="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.commercial.current_value">
                                            </div>

                                        </div>


                                        {{-- RESIDENTIAL --}}
                                        <strong>Residential Buildings</strong>
                                            <div class="row g-2 mt-1 mb-3">

                                                <div class="col-md-3">
                                                    <input class="form-control" placeholder="Location / Survey No."
                                                        wire:model.defer="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.residential.location">
                                                </div>

                                                <div class="col-md-2">
                                                    <input class="form-control" placeholder="Area (Sq.Ft)"
                                                        wire:model.defer="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.residential.area">
                                                </div>

                                                <div class="col-md-2">
                                                    <select class="form-select"
                                                        wire:model.defer="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.residential.inherited">
                                                        <option value="">Inherited?</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-2">
                                                    <input type="date" class="form-control"
                                                        wire:model.defer="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.residential.purchase_date">
                                                </div>

                                                <div class="col-md-2">
                                                    <input type="number" class="form-control" placeholder="Purchase Cost"
                                                        wire:model.defer="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.residential.purchase_cost">
                                                </div>

                                                <div class="col-md-2">
                                                    <input class="form-control" placeholder="Investment Made"
                                                        wire:model.defer="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.residential.investment_made">
                                                </div>

                                                <div class="col-md-3">
                                                    <input class="form-control" placeholder="Current Market Value"
                                                        wire:model.defer="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.residential.current_value">
                                                </div>

                                            </div>

                                         <strong>Others (such as interest in property)</strong>
                                            <div class="row g-2 mt-1 mb-3">
                                                <div class="col-md-6">
                                                   <textarea
                                                        class="form-control"
                                                        placeholder="Description"
                                                        rows="2"
                                                        wire:model.defer="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.others.desc">
                                                    </textarea>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="number"
                                                        class="form-control"
                                                        placeholder="Cost"
                                                        wire:model.defer="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.others.cost">
                                                </div>
                                                
                                            </div>

                                    </div>
                                    @endforeach

                                    <div class="text-end mt-2">
                                        <button type="button"
                                            class="btn btn-outline-success btn-sm"
                                            wire:click="addImmovableGroup({{ $hIndex }})">
                                            <i class="bi bi-plus-circle"></i> Add Asset
                                        </button>
                                    </div>
                            </div>
                        </div>

                        @endforeach
                        <div class="text-center mb-2">
                            <button type="button"
                                class="btn btn-outline-primary btn-sm px-4"
                                wire:click="addImmovableHolder">
                                <i class="bi bi-person-plus"></i> Add Holder
                            </button>
                        </div>

                        <h5 class="text-primary mt-2">Loans / Liabilities</h5>

                        @foreach($loan_holders as $hIndex => $holder)
                        <div class="card mb-1 shadow-sm position-relative">
                            <div class="card-body">

                                @if($hIndex > 0)
                                    <button class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 m-2"
                                        wire:click="removeLoanHolder({{ $hIndex }})">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                @endif

                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Holder</label>
                                    <select class="form-select"
                                        wire:model.defer="loan_holders.{{ $hIndex }}.holder">
                                        <option value="">Select</option>
                                        <option value="self">Self</option>
                                        <option value="spouse">Spouse</option>
                                        <option value="huf">HUF</option>
                                        <option value="dependent">Dependent</option>
                                    </select>
                                </div>

                                @foreach($holder['loans'] as $lIndex => $loan)
                                <div class="border rounded p-3 mb-3 shadow-sm">

                                    <div class="d-flex justify-content-between">
                                        <span class="badge bg-secondary">Loan {{ $lIndex + 1 }}</span>

                                        @if($lIndex > 0)
                                            <button class="btn btn-sm btn-outline-danger"
                                                wire:click="removeLoanRow({{ $hIndex }}, {{ $lIndex }})">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        @endif
                                    </div>

                                    <div class="row g-2 mt-2">
                                        <div class="col-md-3">
                                            <select class="form-select"
                                                wire:model.defer="loan_holders.{{ $hIndex }}.loans.{{ $lIndex }}.type">
                                                <option value="">Loan Type</option>
                                                <option value="bank">Bank</option>
                                                <option value="individual">Individual</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <input class="form-control" placeholder="Name"
                                                wire:model.defer="loan_holders.{{ $hIndex }}.loans.{{ $lIndex }}.name">
                                        </div>

                                        <div class="col-md-3">
                                            <input class="form-control" type="number" placeholder="Amount"
                                                wire:model.defer="loan_holders.{{ $hIndex }}.loans.{{ $lIndex }}.amount">
                                        </div>

                                        <div class="col-md-3">
                                            <input class="form-control" placeholder="Nature"
                                                wire:model.defer="loan_holders.{{ $hIndex }}.loans.{{ $lIndex }}.nature">
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                <div class="text-end">
                                    <button class="btn btn-outline-success btn-sm"
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

                            <div class="mb-3 col-md-4">
                                <label class="form-label">Holder</label>
                                <select class="form-select"
                                    wire:model.defer="government_dues.{{ $gIndex }}.holder">
                                    <option value="">Select</option>
                                    <option value="self">Self</option>
                                    <option value="spouse">Spouse</option>
                                    <option value="huf">HUF</option>
                                    <option value="dependent">Dependent</option>
                                </select>
                            </div>

                            <div class="row g-2">
                                <div class="col-md-3">
                                    <input class="form-control" type="number" placeholder="Income Tax"
                                        wire:model.defer="government_dues.{{ $gIndex }}.income_tax">
                                </div>
                                <div class="col-md-3">
                                    <input class="form-control" type="number" placeholder="GST"
                                        wire:model.defer="government_dues.{{ $gIndex }}.gst">
                                </div>
                                <div class="col-md-3">
                                    <input class="form-control" type="number" placeholder="Property Tax"
                                        wire:model.defer="government_dues.{{ $gIndex }}.property_tax">
                                </div>
                                <div class="col-md-3">
                                    <input class="form-control" type="number" placeholder="Other Dues"
                                        wire:model.defer="government_dues.{{ $gIndex }}.other_dues">
                                </div>
                                <div class="col-md-12">
                                    <textarea class="form-control mt-2"
                                        placeholder="Dispute Details"
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
                        <h6 class="fw-bold">Profession / Occupation:</h6>

                        <div class="ms-3">
                            <div class="mb-2">
                                <label class="form-label">Self</label>
                                <input type="text"
                                    class="form-control"
                                    wire:model.defer="candidate_occupation">
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Spouse</label>
                                <input type="text"
                                    class="form-control"
                                    wire:model.defer="spouse_occupation">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mt-3">
                        <h6 class="fw-bold">Source(s) of Income</h6>

                        <div class="ms-3">
                            <div class="mb-2">
                                <label class="form-label">Self</label>
                                <input type="text"
                                    class="form-control"
                                    wire:model.defer="source_of_incomes.self">
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Spouse</label>
                                <input type="text"
                                    class="form-control"
                                    wire:model.defer="source_of_incomes.spouse">
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Dependents</label>
                                <input type="text"
                                    class="form-control"
                                    wire:model.defer="source_of_incomes.dependents">
                            </div>
                        </div>
                    </div>


                    <div class="col-md-12 mt-3">
                        <h6 class="fw-bold">Educational Qualifications</h6>

                        @foreach($educational_qualifications as $index => $edu)
                            <div class="border rounded p-3 mb-3 bg-white shadow-sm">

                                <span class="badge bg-secondary mb-2">
                                    {{ $edu['level'] }}
                                </span>

                                <div class="row g-2 mt-2">
                                    <div class="col-md-4">
                                        <input type="text"
                                            class="form-control"
                                            placeholder="Degree / Course"
                                            wire:model.defer="educational_qualifications.{{ $index }}.degree">
                                    </div>

                                    <div class="col-md-5">
                                        <input type="text"
                                            class="form-control"
                                            placeholder="University / Institution"
                                            wire:model.defer="educational_qualifications.{{ $index }}.university">
                                    </div>

                                    <div class="col-md-3">
                                        <input type="number"
                                            class="form-control"
                                            placeholder="Year of Passing"
                                            wire:model.defer="educational_qualifications.{{ $index }}.year">
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>


                </div>

                <div class="mt-4 text-end">
                    <button class="btn btn-primary">
                        <i class="bi bi-save"></i> Save & Preview
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

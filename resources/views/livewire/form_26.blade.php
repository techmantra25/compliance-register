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
                            <select class="form-select" wire:model="relation_type" style="max-width: 120px;">
                                <option value="">--</option>
                                <option value="son">Son of</option>
                                <option value="daughter">Daughter of</option>
                                <option value="wife">Wife of</option>
                            </select>

                            <input type="text"
                                class="form-control"
                                placeholder="Enter Name"
                                wire:model="relation_name">

                        </div>
                        @error('relation_type') <small class="text-danger">{{ $message }}</small> @enderror
                        @error('relation_name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Address</label>
                        <textarea class="form-control" wire:model="address" rows="2"></textarea>
                        @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Assembly Constituency Serial No</label>
                        <input type="text" class="form-control" wire:model="assembly_constituency_serial_no">
                        @error('assembly_constituency_serial_no') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                     <div class="col-md-6">
                        <label class="form-label">Assembly Constituency Part No</label>
                        <input type="text" class="form-control" wire:model="assembly_constituency_part_no">
                        @error('assembly_constituency_part_no') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Phone No</label>
                        <input type="number" class="form-control" wire:model="phone_no" min="0">
                        @error('phone_no') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Alternative Phone No</label>
                        <input type="number" class="form-control" wire:model="alternative_phone_no" min="0">
                        @error('alternative_phone_no') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" wire:model="email_id">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Candidate EPIC No</label>
                        <input type="text" class="form-control" wire:model="candidate_epic_no">
                        @error('candidate_epic_no') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Photograph</label>
                        <input type="file" class="form-control" wire:model="photograph">
                        @error('photograph') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Caste / Tribe Details</label>
                        <textarea class="form-control" wire:model="caste_tribe_details" rows="2"></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Proposer EPIC</label>
                        <input type="text" class="form-control" wire:model="proposer_epic">
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
                                    wire:model="whatsapp_no"
                                    placeholder="WhatsApp Number"
                                    min="0">
                                @error('whatsapp_no') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                            <div class="col-md-4">
                                <input type="text"
                                    class="form-control"
                                    wire:model="facebook_account"
                                    placeholder="Facebook Account">
                                @error('facebook_account') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-4">
                                <input type="text"
                                    class="form-control"
                                    wire:model="twitter_account"
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
                                                wire:model="pan_details.{{ $index }}.type">
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
                                                wire:model="pan_details.{{ $index }}.name">
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">PAN</label>
                                            <input type="text"
                                                class="form-control text-uppercase"
                                                wire:model="pan_details.{{ $index }}.pan">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">Last ITR Filed (FY)</label>
                                            <select class="form-select"
                                                wire:model="pan_details.{{ $index }}.last_filed_year">
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
                                        @foreach ($row['income'] as $year => $value)
                                            <div class="col-md-2">
                                                <label class="small text-muted">{{ $year }}</label>
                                                <input type="number"
                                                    class="form-control"
                                                    wire:model="pan_details.{{ $index }}.income.{{ $year }}">
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
                                        wire:model="asset_holders.{{ $hIndex }}.holder">
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
                                                wire:model="asset_holders.{{ $hIndex }}.assets.{{ $aIndex }}.type">
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
                                                wire:model="asset_holders.{{ $hIndex }}.assets.{{ $aIndex }}.description"></textarea>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">Amount (₹)</label>
                                            <input type="number" class="form-control"
                                                wire:model="asset_holders.{{ $hIndex }}.assets.{{ $aIndex }}.amount">
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
                                            wire:model="immovable_assets.{{ $hIndex }}.holder">
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
                                                    wire:model="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.agricultural.location">
                                            </div>
                                            
                                            <div class="col-md-2">
                                                <input class="form-control" placeholder="Area (Acres)"
                                                    wire:model="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.agricultural.area">
                                            </div>
                                            <div class="col-md-2">
                                                <select class="form-select"
                                                    wire:model="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.agricultural.inherited">
                                                    <option value="">Inherited?</option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                               <input type="date" class="form-control"
                                                     wire:model="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.agricultural.purchase_date">
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" class="form-control" placeholder="Purchase Cost"
                                                    wire:model="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.agricultural.purchase_cost">
                                            </div>
                                            <div class="col-md-2">
                                                <input class="form-control" placeholder="Investment Made"
                                                    wire:model="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.agricultural.investment_made">
                                            </div>
                                            <div class="col-md-3">
                                                <input class="form-control" placeholder="Current Market Value"
                                                    wire:model="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.agricultural.current_value">
                                            </div>
                                        </div>

                                        <strong>Non-Agricultural Land</strong>
                                        <div class="row g-2 mt-1 mb-3">

                                            <div class="col-md-3">
                                                <input class="form-control" placeholder="Location / Survey No."
                                                    wire:model="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.non_agricultural.location">
                                            </div>

                                            <div class="col-md-2">
                                                <input class="form-control" placeholder="Area (Acres)"
                                                    wire:model="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.non_agricultural.area">
                                            </div>

                                            <div class="col-md-2">
                                                <select class="form-select"
                                                    wire:model="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.non_agricultural.inherited">
                                                    <option value="">Inherited?</option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>

                                            <div class="col-md-2">
                                                <input type="date" class="form-control"
                                                    wire:model="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.non_agricultural.purchase_date">
                                            </div>

                                            <div class="col-md-2">
                                                <input type="number" class="form-control" placeholder="Purchase Cost"
                                                    wire:model="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.non_agricultural.purchase_cost">
                                            </div>

                                            <div class="col-md-2">
                                                <input class="form-control" placeholder="Investment Made"
                                                    wire:model="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.non_agricultural.investment_made">
                                            </div>

                                            <div class="col-md-3">
                                                <input class="form-control" placeholder="Current Market Value"
                                                    wire:model="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.non_agricultural.current_value">
                                            </div>

                                        </div>


                                        {{-- COMMERCIAL --}}
                                      <strong>Commercial Buildings</strong>
                                        <div class="row g-2 mt-1 mb-3">

                                            <div class="col-md-3">
                                                <input class="form-control" placeholder="Location / Survey No."
                                                    wire:model="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.commercial.location">
                                            </div>

                                            <div class="col-md-2">
                                                <input class="form-control" placeholder="Area (Sq.Ft / Acres)"
                                                    wire:model="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.commercial.area">
                                            </div>

                                            <div class="col-md-2">
                                                <select class="form-select"
                                                    wire:model="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.commercial.inherited">
                                                    <option value="">Inherited?</option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>

                                            <div class="col-md-2">
                                                <input type="date" class="form-control"
                                                    wire:model="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.commercial.purchase_date">
                                            </div>

                                            <div class="col-md-2">
                                                <input type="number" class="form-control" placeholder="Purchase Cost"
                                                    wire:model="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.commercial.purchase_cost">
                                            </div>

                                            <div class="col-md-2">
                                                <input class="form-control" placeholder="Investment Made"
                                                    wire:model="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.commercial.investment_made">
                                            </div>

                                            <div class="col-md-3">
                                                <input class="form-control" placeholder="Current Market Value"
                                                    wire:model="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.commercial.current_value">
                                            </div>

                                        </div>


                                        {{-- RESIDENTIAL --}}
                                        <strong>Residential Buildings</strong>
                                            <div class="row g-2 mt-1 mb-3">

                                                <div class="col-md-3">
                                                    <input class="form-control" placeholder="Location / Survey No."
                                                        wire:model="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.residential.location">
                                                </div>

                                                <div class="col-md-2">
                                                    <input class="form-control" placeholder="Area (Sq.Ft)"
                                                        wire:model="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.residential.area">
                                                </div>

                                                <div class="col-md-2">
                                                    <select class="form-select"
                                                        wire:model="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.residential.inherited">
                                                        <option value="">Inherited?</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-2">
                                                    <input type="date" class="form-control"
                                                        wire:model="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.residential.purchase_date">
                                                </div>

                                                <div class="col-md-2">
                                                    <input type="number" class="form-control" placeholder="Purchase Cost"
                                                        wire:model="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.residential.purchase_cost">
                                                </div>

                                                <div class="col-md-2">
                                                    <input class="form-control" placeholder="Investment Made"
                                                        wire:model="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.residential.investment_made">
                                                </div>

                                                <div class="col-md-3">
                                                    <input class="form-control" placeholder="Current Market Value"
                                                        wire:model="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.residential.current_value">
                                                </div>

                                            </div>

                                         <strong>Others (such as interest in property)</strong>
                                            <div class="row g-2 mt-1 mb-3">
                                                <div class="col-md-6">
                                                   <textarea
                                                        class="form-control"
                                                        placeholder="Description"
                                                        rows="2"
                                                        wire:model="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.others.desc">
                                                    </textarea>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="number"
                                                        class="form-control"
                                                        placeholder="Cost"
                                                        wire:model="immovable_assets.{{ $hIndex }}.groups.{{ $gIndex }}.others.cost">
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
                                        wire:model="loan_holders.{{ $hIndex }}.holder">
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
                                                wire:model="loan_holders.{{ $hIndex }}.loans.{{ $lIndex }}.type">
                                                <option value="">Loan Type</option>
                                                <option value="bank">Bank</option>
                                                <option value="individual">Individual</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <input class="form-control" placeholder="Name"
                                                wire:model="loan_holders.{{ $hIndex }}.loans.{{ $lIndex }}.name">
                                        </div>

                                        <div class="col-md-3">
                                            <input class="form-control" type="number" placeholder="Amount"
                                                wire:model="loan_holders.{{ $hIndex }}.loans.{{ $lIndex }}.amount">
                                        </div>

                                        <div class="col-md-3">
                                            <input class="form-control" placeholder="Nature"
                                                wire:model="loan_holders.{{ $hIndex }}.loans.{{ $lIndex }}.nature">
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
                                    wire:model="government_dues.{{ $gIndex }}.holder">
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
                                        wire:model="government_dues.{{ $gIndex }}.income_tax">
                                </div>
                                <div class="col-md-3">
                                    <input class="form-control" type="number" placeholder="GST"
                                        wire:model="government_dues.{{ $gIndex }}.gst">
                                </div>
                                <div class="col-md-3">
                                    <input class="form-control" type="number" placeholder="Property Tax"
                                        wire:model="government_dues.{{ $gIndex }}.property_tax">
                                </div>
                                <div class="col-md-3">
                                    <input class="form-control" type="number" placeholder="Other Dues"
                                        wire:model="government_dues.{{ $gIndex }}.other_dues">
                                </div>
                                <div class="col-md-12">
                                    <textarea class="form-control mt-2"
                                        placeholder="Dispute Details"
                                        wire:model="government_dues.{{ $gIndex }}.dispute_details"></textarea>
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
                        <h6 class="fw-bold">Details of profession or occupation:</h6>

                        <div class="ms-3">
                            <div class="mb-2">
                                <label class="form-label">(a) Self</label>
                                <input type="text"
                                    class="form-control"
                                    placeholder="e.g. Social Work & Politics"
                                    wire:model="occupation">
                            </div>

                            <div class="mb-2">
                                <label class="form-label">(b) Spouse</label>
                                <input type="text"
                                    class="form-control"
                                    readonly>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-12 mt-3">
                        <h6 class="fw-bold">Details of source(s) of income:</h6>

                        <div class="ms-3">
                            <div class="mb-2">
                                <label class="form-label">(a) Self</label>
                                <input type="text"
                                    class="form-control"
                                    placeholder="e.g. Royalty, Bank Interest, Others"
                                    wire:model="sources_of_income">
                            </div>

                            <div class="mb-2">
                                <label class="form-label">(b) Spouse</label>
                                <input type="text"
                                    class="form-control"
                                    readonly>
                            </div>

                            <div class="mb-2">
                                <label class="form-label">(c) Dependents</label>
                                <input type="text"
                                    class="form-control"
                                    value="Not Applicable"
                                    readonly>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mt-3">
                    <h6 class="fw-bold">My educational qualification is as under:</h6>

                    <div class="ms-3">
                        <textarea
                            class="form-control"
                            rows="5"
                            placeholder="(a) Passed Secondary Examination from ...&#10;(b) Graduation (B.A.) from ...&#10;(c) M.A. from ...&#10;(d) LL.B from ..."
                            wire:model="highest_educational_qualification">
                        </textarea>

                        <small class="text-muted">
                            (Give details of highest School / University education mentioning full course name,
                            institution and year of completion)
                        </small>
                    </div>
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

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

                    <div class="col-md-12">
                    @foreach ($pan_details as $index => $row)

                        <div class="border rounded p-3 mb-3 bg-light position-relative">

                            @if ($index > 0)
                                <button type="button"
                                    class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2"
                                    wire:click="removePanRow({{ $index }})"
                                    title="Remove PAN">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            @endif

                            <div class="row g-2 mb-2">
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

                                <div class="col-md-3">
                                    <label class="form-label">
                                        Last ITR Filed (Financial Year)
                                    </label>
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

                            <label class="form-label">
                                Income Declared in ITR (Last 5 Financial Years)
                            </label>

                            <div class="row g-2">
                                @foreach ($row['income'] as $year => $value)
                                    <div class="col-md-2">
                                        <label class="fw-semibold small text-muted mb-1">
                                            {{ $year }}
                                        </label>
                                        <input type="number"
                                            class="form-control"
                                            wire:model="pan_details.{{ $index }}.income.{{ $year }}">
                                    </div>
                                @endforeach
                            </div>

                        </div>

                    @endforeach

                    <button type="button"
                        class="btn btn-sm btn-success"
                        wire:click="addPanRow">
                        + Add
                    </button>
                    </div>

                    <h5 class="text-primary mt-4">Movable Assets</h5>

                    <div class="col-md-12">
                    @foreach ($movable_assets as $index => $row)

                    <div class="border rounded p-3 mb-3 bg-light position-relative">

                        @if ($index > 0)
                            <button type="button"
                                class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2"
                                wire:click="removeMovableAsset({{ $index }})">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        @endif

                        <div class="row g-2">

                            <div class="col-md-3">
                                <label class="form-label">Asset Type</label>
                                <select class="form-select"
                                    wire:model="movable_assets.{{ $index }}.type">
                                    <option value="">Select</option>
                                    <option value="cash">Cash in Hand</option>
                                    <option value="bank">Bank Deposit</option>
                                    <option value="investment">Investment</option>
                                    <option value="jewellery">Jewellery</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Holder</label>
                                <select class="form-select"
                                    wire:model="movable_assets.{{ $index }}.holder">
                                    <option value="">Select</option>
                                    <option value="self">Self</option>
                                    <option value="spouse">Spouse</option>
                                    <option value="huf">HUF</option>
                                    <option value="dependent">Dependent</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Description</label>
                                <input type="text"
                                    class="form-control"
                                    placeholder="Bank name / Jewellery details / etc"
                                    wire:model="movable_assets.{{ $index }}.description">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Amount (₹)</label>
                                <input type="number"
                                    class="form-control"
                                    wire:model="movable_assets.{{ $index }}.amount">
                            </div>

                        </div>
                    </div>

                    @endforeach

                    <button type="button"
                        class="btn btn-sm btn-success"
                        wire:click="addMovableAsset">
                        + Add Movable Asset
                    </button>
                    </div>

                    <h5 class="text-primary mt-4">Immovable Assets – Agricultural Land</h5>

                        @foreach ($immovable_assets['agricultural_land'] as $i => $row)
                        <div class="border p-3 mb-3 bg-light position-relative">

                            @if($i > 0)
                            <button type="button"
                                class="btn btn-sm btn-danger position-absolute top-0 end-0"
                                wire:click="removeLand({{ $i }})">
                                ✕
                            </button>
                            @endif

                            <div class="row g-2">
                                <div class="col-md-2">
                                    <select class="form-select"
                                        wire:model="assets.immovable.agricultural_land.{{ $i }}.holder">
                                        <option value="self">Self</option>
                                        <option value="spouse">Spouse</option>
                                        <option value="huf">HUF</option>
                                        <option value="dependent">Dependent</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <input class="form-control" placeholder="Location"
                                        wire:model="assets.immovable.agricultural_land.{{ $i }}.location">
                                </div>

                                <div class="col-md-2">
                                    <input class="form-control" placeholder="Area"
                                        wire:model="assets.immovable.agricultural_land.{{ $i }}.area">
                                </div>

                                <div class="col-md-2">
                                    <select class="form-select"
                                        wire:model="assets.immovable.agricultural_land.{{ $i }}.inherited">
                                        <option value="">Inherited?</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <input class="form-control" placeholder="Current Value"
                                        wire:model="assets.immovable.agricultural_land.{{ $i }}.current_value">
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <button class="btn btn-sm btn-success" wire:click="addLand">
                            + Add Land
                        </button>



                    <div class="col-md-6">
                        <label class="form-label">Occupation</label>
                        <input type="text" class="form-control" wire:model="occupation">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Loans / Govt Dues</label>
                        <textarea class="form-control" wire:model="loans_govt_dues"></textarea>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Sources of Income</label>
                        <textarea class="form-control" wire:model="sources_of_income"></textarea>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Highest Educational Qualification</label>
                        <textarea class="form-control" wire:model="highest_educational_qualification"></textarea>
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

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
                            wire:model.defer="candidate_sl_no">
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
                            wire:model.defer="proposer_sl_no">
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
                                wire:model="convicted"
                                value="yes">
                            <label class="form-check-label">Yes</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="convicted"
                                wire:model="convicted"
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
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        Save & Preview
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
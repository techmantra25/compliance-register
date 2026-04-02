<div>
    <style>
        /* CORPORATE DESIGN SYSTEM */
        :root {
            --primary-dark: #0b2b4b;
            --primary: #1f6392;
            --primary-light: #eef2ff;
            --secondary: #5e7a93;
            --success: #0b5e42;
            --danger: #e53e3e;
            --border-light: #e9edf2;
            --bg-light: #f8fafc;
        }

        /* Main corporate card styling */
        .corporate-card {
            border: none;
            border-radius: 20px;
            background: #ffffff;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05), 0 1px 3px rgba(0, 0, 0, 0.02);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .corporate-card .card-header-corporate {
            background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
            border-bottom: 2px solid var(--primary);
            padding: 1.25rem 1.75rem;
        }

        .corporate-card .card-body-corporate {
            padding: 1.75rem;
        }

        /* Header banner */
        .form-header-banner {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
            border-radius: 16px;
            color: white;
            padding: 1.2rem 1.8rem;
            margin-bottom: 1.8rem;
        }

        .form-header-banner h3 {
            font-weight: 700;
            margin-bottom: 0.25rem;
            letter-spacing: -0.3px;
            font-size: 1.5rem;
        }

        .form-header-banner p {
            margin-bottom: 0;
            opacity: 0.9;
            font-size: 0.9rem;
        }

        /* Form labels */
        .form-label-corporate {
            font-weight: 600;
            font-size: 0.8rem;
            /* text-transform: uppercase; */
            letter-spacing: 0.5px;
            color: var(--secondary);
            margin-bottom: 0.5rem;
            display: block;
        }

        /* Input fields */
        .corporate-card .form-control,
        .corporate-card input:not([type="radio"]):not([type="checkbox"]),
        .corporate-card select {
            border-radius: 10px;
            border: 1px solid var(--border-light);
            padding: 0.7rem 1rem;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            background-color: #fff;
        }

        .corporate-card .form-control:focus,
        .corporate-card input:focus:not([type="radio"]):not([type="checkbox"]) {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(31, 99, 146, 0.1);
            outline: none;
        }

        .corporate-card .form-control[readonly] {
            background-color: var(--bg-light);
            cursor: not-allowed;
        }

        /* Radio group styling */
        .radio-group-corporate {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            align-items: center;
            padding-top: 0.3rem;
        }

        .radio-group-corporate .form-check {
            margin: 0;
            padding-left: 1.8rem;
        }

        .radio-group-corporate .form-check-input {
            cursor: pointer;
            width: 1.1em;
            height: 1.1em;
            margin-top: 0.1em;
        }

        .radio-group-corporate .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .radio-group-corporate .form-check-label {
            cursor: pointer;
            font-size: 0.9rem;
            color: #2c3e50;
        }

        /* Section dividers */
        .section-divider {
            display: flex;
            align-items: center;
            margin: 2rem 0 1.5rem;
        }

        .section-divider-line {
            flex: 1;
            height: 2px;
            background: linear-gradient(90deg, #e2e8f0, transparent);
        }

        .section-divider-title {
            background: var(--bg-light);
            padding: 0 1.2rem;
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--primary-dark);
            letter-spacing: -0.2px;
        }

        .section-badge {
            background: var(--primary-light);
            color: var(--primary);
            border-radius: 30px;
            padding: 0.25rem 1rem;
            font-size: 0.7rem;
            font-weight: 700;
            display: inline-block;
            margin-bottom: 0.75rem;
            letter-spacing: 0.3px;
        }

        /* Proposer cards */
        .proposer-card {
            background: var(--bg-light);
            border: 1px solid var(--border-light);
            border-radius: 16px;
            padding: 1.2rem 1.2rem 0.8rem;
            margin-bottom: 1.2rem;
            transition: all 0.2s ease;
        }

        .proposer-card:hover {
            border-color: var(--primary);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        /* Buttons */
        .btn-add-corporate {
            background: #ecfdf5;
            border: 1px solid #c6f0da;
            color: var(--success);
            border-radius: 30px;
            padding: 0.5rem 1.2rem;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.2s;
        }

        .btn-add-corporate:hover {
            background: #d1fae5;
            transform: translateY(-1px);
        }

        .btn-remove-corporate {
            border-radius: 30px;
            padding: 0.4rem 1rem;
            font-size: 0.8rem;
        }

        .btn-primary-corporate {
            background: var(--primary);
            border: none;
            border-radius: 30px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-primary-corporate:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(31, 99, 146, 0.3);
        }

        /* Error messages */
        .error-message-corporate {
            font-size: 0.75rem;
            margin-top: 0.35rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
            color: var(--danger);
        }

        /* Mobile responsive */
        @media (max-width: 768px) {
            .corporate-card .card-body-corporate {
                padding: 1.25rem;
            }
            
            .form-header-banner {
                padding: 1rem 1.2rem;
            }
            
            .form-header-banner h3 {
                font-size: 1.3rem;
            }
            
            .radio-group-corporate {
                gap: 1rem;
                flex-wrap: wrap;
            }
            
            .section-divider-title {
                font-size: 0.9rem;
                padding: 0 0.8rem;
            }
            
            .row {
                margin-bottom: 0.5rem;
            }
            
            .btn-primary-corporate {
                width: 100%;
            }
            
            .d-flex.justify-content-between {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 0.75rem;
            }
        }

        /* Helper classes */
        .text-small-muted {
            font-size: 0.7rem;
            color: var(--secondary);
        }
        
        hr.hr-soft {
            border: none;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--border-light), transparent);
            margin: 1.5rem 0;
        }
        .btn-primary-back {
            background: #d51313;
            border: none;
            color: #fff;
            border-radius: 30px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.2s;
        }
        .btn-primary-back:hover {
            background: #d51313;
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(233, 53, 40, 0.3);
        }
    </style>

    <!-- Assembly Info Card -->
    <div class="corporate-card">
        <div class="card-header-corporate">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <div>
                    <span class="section-badge">
                        <i class="fas fa-file-alt me-1"></i> Form 2B - Nomination Paper
                    </span>
                    <h5 class="mb-0 fw-semibold" style="color: var(--primary-dark);">Candidate Affidavit & Declaration</h5>
                </div>
                <div class="mt-2 mt-sm-0">
                    <div style="padding: 5px, 0px;text-align: end;">
                        <span class="badge bg-light text-dark px-3 py-2 rounded-pill border">
                            <i class="fas fa-map-marker-alt me-1 text-primary"></i> 
                            <strong>Assembly:</strong> {{ $assembly_data->assembly_number }} {{ $assembly_data->assembly_name_en }}
                        </span>
                        <a href="{{route('admin.form-2b-generate')}}" class="btn btn-primary-back">
                            <i class="fas fa-arrow-left me-1"></i> Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-body-corporate">
            <!-- Info Alert -->
            <div class="alert alert-light border rounded-3 py-3 mb-4" style="background: #f9fbfd; border-left: 4px solid var(--primary) !important;">
                <div class="d-flex">
                    <i class="fas fa-info-circle text-primary mt-1 me-2"></i>
                    <small class="text-secondary">Please fill all details accurately. Information provided will be verified as per electoral records. Fields marked with <span class="text-danger">*</span> are mandatory.</small>
                </div>
            </div>

            <form id="form2b" wire:submit.prevent="save">
                <!-- PART I: Candidate Details -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label-corporate">Candidate Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" wire:model.defer="candidate_name" placeholder="Full name as per electoral roll">
                        @error('candidate_name') <small class="error-message-corporate"><i class="fas fa-exclamation-circle"></i> {{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-corporate">Age <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" wire:model.defer="age" placeholder="Age as on nomination date">
                        @error('age') <small class="error-message-corporate"><i class="fas fa-exclamation-circle"></i> {{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label-corporate">Relation Type</label>
                        <div class="radio-group-corporate">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="relation_type" id="relation_father" wire:model.defer="relation_type" value="father">
                                <label class="form-check-label" for="relation_father">Father</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="relation_type" id="relation_mother" wire:model.defer="relation_type" value="mother">
                                <label class="form-check-label" for="relation_mother">Mother</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="relation_type" id="relation_husband" wire:model.defer="relation_type" value="husband">
                                <label class="form-check-label" for="relation_husband">Husband</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-corporate">Name of Relative (as stated above)</label>
                        <input type="text" class="form-control" wire:model.defer="relation_name" placeholder="e.g., Shri/Mrs...">
                    </div>
                </div>

                <div class="row mb-4">
                    
                    <div class="col-md-6">
                        <label class="form-label-corporate">Gender / Pronoun</label>
                        <div class="radio-group-corporate">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="pronoun" wire:model.defer="pronoun" id="pronoun_his" value="his">
                                <label class="form-check-label" for="pronoun_his">His</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="pronoun" wire:model.defer="pronoun" id="pronoun_her" value="her">
                                <label class="form-check-label" for="pronoun_her">Her</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-corporate">Political Party Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" wire:model.live.debounce.500ms="party_name" placeholder="Name of party">
                        @error('party_name') <small class="error-message-corporate"><i class="fas fa-exclamation-circle"></i> {{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <label class="form-label-corporate">Postal Address</label>
                        <input type="text" class="form-control" wire:model.defer="postal_address" placeholder="House No., Street, City, PIN Code">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-3">
                        <label class="form-label-corporate">Electoral Sl. No.</label>
                        <input type="text" class="form-control" wire:model.defer="candidate_serial_no" placeholder="Sl. No.">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label-corporate">Part No.</label>
                        <input type="text" class="form-control" wire:model.defer="candidate_part_no" placeholder="Part No.">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-corporate">Assembly Constituency</label>
                        <input type="text" class="form-control" wire:model.defer="assembly_name" readonly placeholder="Auto-filled" value="">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <label class="form-label-corporate">Enrolled Constituency Name</label>
                        <input type="text" class="form-control" wire:model.defer="constituency_where_enrolled" placeholder="Constituency where enrolled as voter">
                    </div>
                </div>

                <!-- PART II Divider -->
                <div class="section-divider">
                    <div class="section-divider-line"></div>
                    <span class="section-divider-title">PART II — PROPOSER DETAILS</span>
                    <div class="section-divider-line"></div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                    <h6 class="fw-semibold m-0">
                        <i class="fas fa-users text-primary me-2"></i>Proposers (Minimum 1 required)
                    </h6>
                </div>

                @foreach($proposers as $index => $prop)
                <div class="proposer-card">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label-corporate">Proposer Name</label>
                            <input type="text" class="form-control" wire:model.defer="proposers.{{$index}}.name" placeholder="Full name of proposer">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label-corporate">Sl. No.</label>
                            <input type="text" class="form-control" wire:model.defer="proposers.{{$index}}.sl_no" placeholder="Serial Number">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label-corporate">Part No.</label>
                            <input type="text" class="form-control" wire:model.defer="proposers.{{$index}}.part_no" placeholder="Part Number">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label-corporate">Constituency</label>
                            <input type="text" class="form-control" wire:model.defer="proposers.{{$index}}.constituency" placeholder="Assembly Constituency">
                        </div>
                        <div class="col-md-1 text-md-end text-start align-self-center">
                            @if(count($proposers) > 1)
                            <button type="button" class="btn btn-outline-danger btn-sm btn-remove-corporate mt-3 mt-md-0 " wire:click="removeProposer({{$index}})">
                                <i class="fas fa-trash-alt me-1"></i> Remove
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="d-flex justify-content-end align-items-center mb-3 flex-wrap ">
                    <button type="button" class="btn btn-add-corporate" wire:click="addProposer">
                        <i class="fas fa-plus me-1"></i> Add Proposer
                    </button>
                </div>

                <!-- PART III Divider -->
                <div class="section-divider mt-4">
                    <div class="section-divider-line"></div>
                    <span class="section-divider-title">PART III — CANDIDATE DECLARATION</span>
                    <div class="section-divider-line"></div>
                </div>

                <div class="text-small-muted mb-3">
                    <i class="fas fa-file-signature me-1"></i> Candidate Declaration Details
                </div>

                <!-- Political Party -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label-corporate">Political Party Name</label>
                        <input type="text" class="form-control" placeholder="Enter party name" value="{{$party_name}}" disabled>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label-corporate">Party Type</label>
                        <select class="form-control" wire:model.defer="party_type">
                            <option value="">Select</option>
                            <option value="state">State Party</option>
                            <option value="national">National Party</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-corporate">Name Printed In Language</label>
                        <input type="text" class="form-control" wire:model.defer="name_language" placeholder="e.g. English">
                    </div>
                </div>

                <!-- Symbols -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label-corporate">Symbol Preference 1</label>
                        <input type="text" class="form-control" wire:model.defer="symbol_1">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-corporate">Symbol Preference 2</label>
                        <input type="text" class="form-control" wire:model.defer="symbol_2">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-corporate">Symbol Preference 3</label>
                        <input type="text" class="form-control" wire:model.defer="symbol_3">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label-corporate">Do you belong to SC/ST?</label>

                        <div class="d-flex gap-3 mt-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="caste_yes"
                                    name="has_caste"  wire:click="toggleCaste(1)" {{ $has_caste == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="caste_yes">Yes</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="caste_no"
                                    name="has_caste"  wire:click="toggleCaste(0)" {{ $has_caste == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="caste_no">No</label>
                            </div>
                        </div>
                    </div>
                </div>
                @if($has_caste == 1)
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label-corporate">Caste / Tribe</label>
                            <input type="text" class="form-control" wire:model.defer="caste">
                            @error('caste') <small class="text-danger error-message">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label-corporate">State</label>
                            <input type="text" class="form-control" wire:model.defer="caste_state">
                            @error('caste_state') <small class="text-danger error-message">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label-corporate">Area</label>
                            <input type="text" class="form-control" wire:model.defer="caste_area">
                            @error('caste_area') <small class="text-danger error-message">{{ $message }}</small> @enderror
                        </div>
                    </div>
                @endif
                <!-- PART IIIA Divider -->
                <div class="section-divider mt-4">
                    <div class="section-divider-line"></div>
                    <span class="section-divider-title">PART IIIA — LEGAL DECLARATIONS</span>
                    <div class="section-divider-line"></div>
                </div>
                <div class="text-small-muted mb-3">
                    <i class="fas fa-gavel me-1"></i> As per Representation of the People Act, 1951
                </div>

                <!-- Convicted -->
                <div class="row mb-4">
                    <div class="col-md-7">
                        <label class="form-label-corporate">Whether the candidate has been convicted</label>
                    </div>
                    <div class="col-md-5">
                        <div class="radio-group-corporate">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="convicted_yes" wire:model="convicted" value="Yes" disabled>
                                <label class="form-check-label text-muted" for="convicted_yes">Yes</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="convicted_no" wire:model="convicted" value="No">
                                <label class="form-check-label" for="convicted_no">No</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Office of Profit -->
                <div class="row mb-4">
                    <div class="col-md-7">
                        <label class="form-label-corporate">Whether the candidate is holding any office of profit under the Government?</label>
                    </div>
                    <div class="col-md-5">
                        <div class="radio-group-corporate">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="office_profit_yes" name="office_of_profit" wire:click="FieldToggle('office_of_profit', 1)" {{ $office_of_profit == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="office_profit_yes">Yes</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="office_profit_no" name="office_of_profit" wire:click="FieldToggle('office_of_profit', 0)" {{ $office_of_profit == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="office_profit_no">No</label>
                            </div>
                        </div>
                    </div>
                </div>

                @if($office_of_profit == 1)
                <div class="row mb-4">
                    <div class="col-md-12">
                        <label class="form-label-corporate">Details of office held</label>
                        <input type="text" class="form-control" wire:model.defer="holding_office_of_profit" placeholder="Specify office and details">
                        @error('holding_office_of_profit') <small class="error-message-corporate">{{ $message }}</small> @enderror
                    </div>
                </div>
                @endif

                <!-- Insolvent -->
                <div class="row mb-4">
                    <div class="col-md-7">
                        <label class="form-label-corporate">Whether the candidate has been declared insolvent by any Court?</label>
                    </div>
                    <div class="col-md-5">
                        <div class="radio-group-corporate">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="insolvent_yes" name="insolvent" wire:click="FieldToggle('insolvent', 1)" {{ $insolvent == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="insolvent_yes">Yes</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="insolvent_no" name="insolvent" wire:click="FieldToggle('insolvent', 0)" {{ $insolvent == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="insolvent_no">No</label>
                            </div>
                        </div>
                    </div>
                </div>

                @if($insolvent == 1)
                <div class="row mb-4">
                    <div class="col-md-12">
                        <label class="form-label-corporate">Insolvency details</label>
                        <input type="text" class="form-control" wire:model.defer="declared_insolvent" placeholder="Provide court and case details">
                        @error('declared_insolvent') <small class="error-message-corporate">{{ $message }}</small> @enderror
                    </div>
                </div>
                @endif

                <!-- Foreign Allegiance -->
                <div class="row mb-4">
                    <div class="col-md-7">
                        <label class="form-label-corporate">Whether the candidate is under allegiance to any foreign country?</label>
                    </div>
                    <div class="col-md-5">
                        <div class="radio-group-corporate">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="foreign_yes" name="foreign_allegiance" wire:click="FieldToggle('foreign_allegiance', 1)" {{ $foreign_allegiance == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="foreign_yes">Yes</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="foreign_no" name="foreign_allegiance" wire:click="FieldToggle('foreign_allegiance', 0)" {{ $foreign_allegiance == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="foreign_no">No</label>
                            </div>
                        </div>
                    </div>
                </div>

                @if($foreign_allegiance == 1)
                <div class="row mb-4">
                    <div class="col-md-12">
                        <label class="form-label-corporate">Details of foreign allegiance</label>
                        <input type="text" class="form-control" wire:model.defer="allegiance_to_foreign_country" placeholder="Provide country and nature of allegiance">
                        @error('allegiance_to_foreign_country') <small class="error-message-corporate">{{ $message }}</small> @enderror
                    </div>
                </div>
                @endif

                <!-- Disqualified by President -->
                <div class="row mb-4">
                    <div class="col-md-7">
                        <label class="form-label-corporate">Whether the candidate has been disqualified under section 8A of the said Act by an order of the President?</label>
                    </div>
                    <div class="col-md-5">
                        <div class="radio-group-corporate">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="president_yes" name="disqualified_president" wire:click="FieldToggle('disqualified_president', 1)" {{ $disqualified_president == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="president_yes">Yes</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="president_no" name="disqualified_president" wire:click="FieldToggle('disqualified_president', 0)" {{ $disqualified_president == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="president_no">No</label>
                            </div>
                        </div>
                    </div>
                </div>

                @if($disqualified_president == 1)
                <div class="row mb-4">
                    <div class="col-md-12">
                        <label class="form-label-corporate">Period of disqualification</label>
                        <input type="text" class="form-control" wire:model.defer="disqualified_by_president" placeholder="Specify period and order details">
                        @error('disqualified_by_president') <small class="error-message-corporate">{{ $message }}</small> @enderror
                    </div>
                </div>
                @endif

                <!-- Dismissed for Corruption -->
                <div class="row mb-4">
                    <div class="col-md-7">
                        <label class="form-label-corporate">Whether the candidate was dismissed for corruption or disloyalty?</label>
                    </div>
                    <div class="col-md-5">
                        <div class="radio-group-corporate">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="dismissed_yes" name="dismissed_for_corruptions" wire:click="FieldToggle('dismissed_for_corruptions', 1)" {{ $dismissed_for_corruptions == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="dismissed_yes">Yes</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="dismissed_no" name="dismissed_for_corruptions" wire:click="FieldToggle('dismissed_for_corruptions', 0)" {{ $dismissed_for_corruptions == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="dismissed_no">No</label>
                            </div>
                        </div>
                    </div>
                </div>

                @if($dismissed_for_corruptions == 1)
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label-corporate">Date of dismissal</label>
                        <input type="date" class="form-control" wire:model.defer="dismissed_for_corruption">
                        @error('dismissed_for_corruption') <small class="error-message-corporate">{{ $message }}</small> @enderror
                    </div>
                </div>
                @endif

                <!-- Government Contract -->
                <div class="row mb-4">
                    <div class="col-md-7">
                        <label class="form-label-corporate">Whether the candidate has any subsisting contract(s) with the Government?</label>
                    </div>
                    <div class="col-md-5">
                        <div class="radio-group-corporate">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="contract_yes" name="govt_contract" wire:click="FieldToggle('govt_contract', 1)" {{ $govt_contract == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="contract_yes">Yes</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="contract_no" name="govt_contract" wire:click="FieldToggle('govt_contract', 0)" {{ $govt_contract == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="contract_no">No</label>
                            </div>
                        </div>
                    </div>
                </div>

                @if($govt_contract == 1)
                <div class="row mb-4">
                    <div class="col-md-12">
                        <label class="form-label-corporate">Government and contract details</label>
                        <input type="text" class="form-control" wire:model.defer="subsisting_govt_contract" placeholder="Specify government department and contract nature">
                        @error('subsisting_govt_contract') <small class="error-message-corporate">{{ $message }}</small> @enderror
                    </div>
                </div>
                @endif

                <!-- Company Position -->
                <div class="row mb-4">
                    <div class="col-md-7">
                        <label class="form-label-corporate">Whether the candidate is a managing agent, manager or Secretary of any company or Corporation?</label>
                    </div>
                    <div class="col-md-5">
                        <div class="radio-group-corporate">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="company_yes" name="company_position" wire:click="FieldToggle('company_position', 1)" {{ $company_position == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="company_yes">Yes</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="company_no" name="company_position" wire:click="FieldToggle('company_position', 0)" {{ $company_position == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="company_no">No</label>
                            </div>
                        </div>
                    </div>
                </div>

                @if($company_position == 1)
                <div class="row mb-4">
                    <div class="col-md-12">
                        <label class="form-label-corporate">Company position details</label>
                        <input type="text" class="form-control" wire:model.defer="managing_agent_role" placeholder="Company name and position held">
                        @error('managing_agent_role') <small class="error-message-corporate">{{ $message }}</small> @enderror
                    </div>
                </div>
                @endif

                <!-- Commission Disqualified -->
                <div class="row mb-4">
                    <div class="col-md-7">
                        <label class="form-label-corporate">Whether the candidate has been disqualified by the Commission under section 10A of the said Act?</label>
                    </div>
                    <div class="col-md-5">
                        <div class="radio-group-corporate">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="commission_yes" name="commission_disqualified" wire:click="FieldToggle('commission_disqualified', 1)" {{ $commission_disqualified == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="commission_yes">Yes</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="commission_no" name="commission_disqualified" wire:click="FieldToggle('commission_disqualified', 0)" {{ $commission_disqualified == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="commission_no">No</label>
                            </div>
                        </div>
                    </div>
                </div>

                @if($commission_disqualified == 1)
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label-corporate">Date of disqualification</label>
                        <input type="date" class="form-control" wire:model.defer="date_of_disqualification">
                        @error('date_of_disqualification') <small class="error-message-corporate">{{ $message }}</small> @enderror
                    </div>
                </div>
                @endif

                <hr class="hr-soft">

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 mt-3">

                    <div class="text-muted small">
                        <i class="fas fa-shield-alt me-1 text-primary"></i> 
                        All information provided is true and accurate to the best of my knowledge
                    </div>

                    <!-- Buttons Group -->
                    <div class="d-flex gap-2">
                        
                        <!-- Back Button -->
                        <a href="{{route('admin.form-2b-generate')}}" class="btn btn-primary-back">
                            <i class="fas fa-arrow-left me-1"></i> Back
                        </a>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary-corporate btn-primary">
                            <i class="fas fa-save me-2"></i> Save & Preview Form 2B
                        </button>

                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        window.addEventListener('toastr:success', event => toastr.success(event.detail.message));
        window.addEventListener('toastr:error', event => toastr.error(event.detail.message));
    </script>
<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('scrollTop', () => {
            scrollToFirstError();
        });
    });

    function scrollToFirstError() {
        setTimeout(() => {
            const firstError = document.querySelector('.error-message-corporate, .text-danger');
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
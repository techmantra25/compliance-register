<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FORM 2B - Nomination Paper</title>
    <style>
        * {
            font-family: 'Times New Roman', Times, serif;
            box-sizing: border-box;
            font-size: 16px;
        }
        
        body {
            margin: 20px;
            color: #000;
            line-height: 1.4;
        }
        
        .form-container {
            width: calc(210mm - 26mm) !important;
            margin: 0 auto;
            background-color: white;
        }
        
        .form-header {
            text-align: center;
            margin-bottom: 12px;
        }
        
        .form-title {
            font-size: 16px;
            line-height: 1;
        }
        
        .form-subtitle {
            font-size: 18px;
            margin-bottom: 10px;
        }
        
        .section-title {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 15px;
        }
        
        .note-box {
            background-color: #fffde7;
            border-left: 4px solid #ffc107;
            padding: 10px;
            margin: 10px 0;
            font-size: 14px;
        }
        
        .input-field {
            border: none;
            background: transparent;
            padding: 3px 0px;
            margin: 0 5px;
            font-family: 'Times New Roman', Times, serif;
            font-size: 14px;
            /* min-width: 150px; */
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100%25' height='2' viewBox='0 0 100 2'%3E%3Cline x1='0' y1='1' x2='100' y2='1' stroke='%23000' stroke-width='1' stroke-dasharray='2,2'/%3E%3C/svg%3E");
            background-repeat: repeat-x;
            background-position: bottom;
            font-size: 16px;
            text-align: center;
            width: fit-content;

        }
        .input-field:focus{
            outline: none;
        }
        
        .input-field-small {
            /* width: 80px; */
            /* min-width: 80px; */
             width: fit-content;
        }
        
        .input-field-medium {
            /* width: 200px; */
            /* min-width: 200px; */
             width: fit-content;
        }
        
        .input-field-large {
            /* width: 300px; */
             width: fit-content;
        }
        
        .strike-instruction {
            color: #000000;
            margin: 10px 0;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            border:0;
        }
        
        th, td {
            text-align: left;
            vertical-align: top;
            font-weight: normal;
        }

        td {
            padding: 0 8px;
            font-size: 16px;
        }
        
        th {
            font-size: 16px;
            text-align: center;
            padding: 0 8px;
        }
        
        .checkbox-group {
            margin: 10px 0;
        }
        
        .checkbox-group label {
            margin-right: 20px;
        }
        
        .perforation {
            border-top: 2px dashed #999;
            margin: 30px 0;
            text-align: center;
            padding-top: 10px;
            color: #666;
        }
        
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #666;
        }
        
        .photo-placeholder {
            width: 80px;
            height: 100px;
            border: 1px dashed #999;
            background-color: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            color: #666;
            margin: 10px 0;
            text-align: center;
        }
        
        .part-selector {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #e8f4fd;
            border-radius: 5px;
        }
        ::placeholder {
           font-weight: bold;
           font-size: 16px;
           line-height: 1.21;
           color:#000;
        }

        .full-strike, .full-strike2 {
            position: relative;
            z-index: 1;
        }

        .full-strike:after, .full-strike2:after {
            content: "";
            position: absolute;
            left: 50%;
            top: -29px;
            bottom: 0;
            width: 2px;
            background: #000;
            transform: rotate(40deg);
            height: 136%;
        }
        .full-strike2:after {
            top: -83px;
        }

        .strike-out{
            text-decoration: line-through;
        }
        
        @media print {
            @page {
                size: A4;
                margin: 15mm;

                @bottom-center {
                    content: "[" counter(page) "]";
                    font-size: 12pt;
                    color: #000000;
                    /* margin-top: 8mm; */
                }
            }
            .form-container {
                box-shadow: none;
                border: none;
                padding: 0;
                width: 210mm !important;
                width: 794px !important;
                min-height: 297mm !important;
                padding:0px;
                margin: 0px;
            }
            
            .input-field {
                border-bottom: 1px dotted #000;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100%25' height='2' viewBox='0 0 100 2'%3E%3Cline x1='0' y1='1' x2='100' y2='1' stroke='%23000' stroke-width='1' stroke-dasharray='2,2'/%3E%3C/svg%3E");
                background-repeat: repeat-x;
                background-position: bottom;
            }
            .keep-together {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
                -webkit-column-break-inside: avoid !important;
                height: 300mm !important;
                overflow: hidden !important;
            }

            .full-strike:after, .full-strike2:after {
               background-color: #000 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                transform: rotate(45deg);

            }

        }
    </style>
</head>
<body>
    <div class="form-container">
        <!---keep togathor start-->
        <div class="keep-together">
            <div class="form-header">
                <div class="form-title">FORM 2B</div>
                <div class=".form-title">(See rule 4)</div>
                <div class="form-title">NOMINATION PAPER</div>
                <div style="font-style: italic; font-size: 16px; line-height: 1.21;">Election to the Legislative Assembly of 
                    <input type="text" class="input-field input-field-large" placeholder="WEST BENGAL" readonly style="width:125px;">(State)
                </div>

            </div>

        <form wire:submit.prevent="save" enctype="multipart/form-data">

            <div style="text-align: right; overflow: auto; margin-bottom: 16px;">
                <div style="font-size: 12px; line-height:1.35; font-style: italic; text-align: justify; border:1px solid #000; width:114px; height: 145px; padding:5px; font-weight: bold; float: right; display: flex; align-items:center; justify-content: center;">
                    <!-- Recent stamp size
                    (2cm X 2.5cm)
                    photograph in
                    white/off white
                    background with
                    full face view. -->
                    <input type="file" wire:model="candidate_photo" accept="image/*">
                    @error('candidate_photo')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                </div>

            </div>

            <div class="strike-instruction" style="font-size: 16px; line-height: 1.21; color:#000; text-align: center;">
                STRIKE OFF PART I OR PART II BELOW WHICHEVER IS NOT APPLICABLE
            </div>


            <!-- PART I -->
            <div class="section">
                <div style="text-align: center; line-height: 1.21; font-weight: bold; font-size: 16px;" >PART I</div>
                <div class="section-title" style="text-align: center; font-weight: normal; margin-bottom: 7px;"> (To be used by candidate set up by recognised political party)</div>
                <div style="font-size: 16px; line-height: 2; text-align: justify;">
                    I nominate as a candidate for election to the Legislative Assembly from the 
                    <input type="text" class="input-field input-field-large" value="{{ $data->assembly_name }}" style="width:228px;" readonly> Assembly Constituency. 
                    
                </div>

                <div style="font-size: 16px; line-height: 2;">
                    Candidate's name <input type="text" class="input-field input-field-large" value="{{ $data->candidate_name }}" readonly style="width: 300px;">
                    <div wire:key="relation-type-1">
                        <label>
                            <input type="radio" name="relation_type_main" value="{{ $data->relation_type }}" value="father"> Father's
                        </label>
                        /
                        <label>
                            <input type="radio" name="relation_type_main" value="{{ $data->relation_type }}" value="mother"> Mother's
                        </label>
                        /
                        <label>
                            <input type="radio" name="relation_type_main" value="{{ $data->relation_type }}" value="husband"> Husband's
                        </label>
                    </div>
                    name <input type="text" class="input-field input-field-medium" value="{{ $data->relation_name }}" style="width: 400px;"> 
                    <div wire:key="pronoun-1">  
                        <label>
                            <input type="radio" name="pronoun-main" value="{{ $data->pronoun }}" value="his"> His
                        </label>
                        <label>
                            <input type="radio" name="pronoun-main" value="{{ $data->pronoun }}" value="her"> Her
                        </label>
                    </div>
                    postal address<input type="text" class="input-field input-field-large" style="width: 428px;" value="{{ $data->postal_address }}">
                    <div wire:key="pronoun-2">
                        <label>
                            <input type="radio" name="pronoun-copy" value="{{ $data->pronoun }}" value="his"> His
                        </label>
                        <label>
                            <input type="radio" name="pronoun-copy" value="{{ $data->pronoun }}" value="her"> Her
                        </label>
                    </div>
                    name is entered at Sl. No<input type="text" class="input-field input-field-small" value="{{ $data->candidate_sl_no }}"> in Part No. 
                    <input type="text" class="input-field input-field-small" value="{{ $data->candidate_part_no }}"> of the electoral roll for 
                    <input type="text" class="input-field input-field-medium" value="{{ $data->assembly_name }}" style="width: 229px;"> Assembly constituency.
                </div>
                
                <div style=" font-size: 16px; line-height: 2;">
                    My name is <input type="text" class="input-field input-field-large" value="{{ $data->proposer_name }}"> and it is entered at Sl. No. 
                    <input type="text" class="input-field input-field-small" value="{{ $data->proposer_sl_no }}"> in Part No 
                    <input type="text" class="input-field input-field-small" value="{{ $data->proposer_part_no }}"> of the electoral roll for the 
                    <input type="text" class="input-field input-field-medium" value="{{ $data->proposer_constituency }}" style="width: 227px;"> Assembly constituency.
                </div>
                
                <div style="margin-top: 37px; display: flex; justify-content: space-between;">
                    <div style=" font-size: 16px; line-height: 2;">
                        Date: <input type="text" class="input-field input-field-medium" style="width:105px;">
                    </div>
                    
                    <div style=" font-size: 16px; line-height: 2;">
                        Signature of the Proposer
                    </div>
                </div>
            </div>


            <div class="full-strike">
                <!-- PART II -->
                <div class="section" style="margin-top: 40px; line-height: 1.21;">
                    <div class="section-title" style="text-align: center; line-height: 1.21; font-weight: bold; font-size: 16px; margin-bottom: 0; ">PART II</div>
                    <div style="text-align: justify;">
                        We hereby nominate as candidate for election to the Legislative Assembly from the 
                        <input type="text" class="input-field input-field-large"> Assembly Constituency.
                    </div>
                    
                    <div style="margin-top: 15px;">
                        Candidate's name: <input type="text" class="input-field input-field-large">
                        <span>Father's</span>/<span class="strike-out">mother's</span>/ <span class="strike-out">husband's</span> name: <input type="text" class="input-field input-field-medium">
                        His postal address: <input type="text" class="input-field input-field-large" style="width: 400px;">
                        His name is entered at Sl. No. <input type="text" class="input-field input-field-small"> in Part No. 
                        <input type="text" class="input-field input-field-small"> of the electoral roll for 
                        <input type="text" class="input-field input-field-medium"> Assembly constituency.
                    </div>
                </div>
            </div>

        </div>

        <!---keep togathor start-->
        <div class="keep-together">

            <div class="full-strike2">
                <div style="margin-top: 15px; line-height:1.8; text-align: justify;" >
                    We declare that we are electors of this Assembly constituency and our names are entered in the electoral roll for this Assembly constituency as indicated below and we append our signatures below in token of subscribing to this nomination:-
                </div>
                
                <div class="section-title" style="text-align: center; font-size: 16px; font-weight: bold; margin-top: 20px; margin-bottom: 0;">Particulars of the proposers and their signatures</div>
                
                <table style="margin-top: 0;">
                    <thead>
                        <tr>
                            <th style="border-width: 1px 1px 0px 0px; border-color: #000; border-style: solid;">Sl.no.</th>
                            <th colspan="2" style="border:1px solid #000;">Elector Roll No. of Proposer</th>
                            <th style="border-width: 1px 1px 0px 1px; border-color: #000; border-style: solid;">Full Name</th>
                            <th style="border-width: 1px 1px 0px 1px; border-color: #000; border-style: solid;">Signature</th>
                            <th style="border-width: 1px 0px 0px 1px; border-color: #000; border-style: solid;">Date</th>
                        </tr>
                        <tr>
                            <th style="border-width: 0px 0px 1px 0px; border-color: #000; border-style: solid;"></th>
                            <th style="border-width: 1px 1px 1px 1px; border-color: #000; border-style: solid;">Part No. of Electoral Roll</th>
                            <th style="border-width: 1px 1px 1px 1px; border-color: #000; border-style: solid;">S.No. in that part</th>
                            <th style="border-width: 0px 1px 1px 0px; border-color: #000; border-style: solid;"></th>
                            <th style="border-width: 0px 1px 1px 0px; border-color: #000; border-style: solid;"></th>
                            <th style="border-width: 0px 0px 1px 0px; border-color: #000; border-style: solid;"></th>
                        </tr>
                        <tr>
                            <th style="border-width: 0px 0px 1px 0px; border-color: #000; border-style: solid;">1</th>
                            <th style="border-width: 1px 1px 1px 1px; border-color: #000; border-style: solid;">2</th>
                            <th style="border-width: 1px 1px 1px 1px; border-color: #000; border-style: solid;">3</th>
                            <th style="border-width: 0px 0px 1px 0px; border-color: #000; border-style: solid;">4</th>
                            <th style="border-width: 0px 0px 1px 0px; border-color: #000; border-style: solid;">5</th>
                            <th style="border-width: 0px 0px 1px 0px; border-color: #000; border-style: solid;">6</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1.</td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                        </tr>
                        <tr>
                            <td>2.</td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                        </tr>
                        <tr>
                            <td>3.</td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                        </tr>
                        <tr>
                            <td>4.</td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                        </tr>
                        <tr>
                            <td>5.</td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                        </tr>
                        <tr>
                            <td>6.</td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                        </tr>
                        <tr>
                            <td>7.</td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                        </tr>
                        <tr>
                            <td>8.</td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                        </tr>
                        <tr>
                            <td>9.</td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                        </tr>
                        <tr>
                            <td>10.</td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                            <td><input type="text" class="input-field" style="width: 100%;"></td>
                        </tr>
                    </tbody>
                </table>
                
                <div style="border-top:2px solid #000;">
                    N.B. - There should be ten electors of the constituency as proposers.
                </div>
            </div>



            <div class="section-title" style="text-align: center; margin-bottom: 0; margin-top: 40px;">PART III</div>
            <div>I, the candidate mentioned in <span>Part I</span>/<span>Part II</span> (Strike out which is not applicable) assent to this nomination and hereby declare that:</div>
            <div style="margin-top: 3px;">(a) I am a citizen of India and have not acquired the citizenship of any foreign State;</div>
            <div style="margin-top: 2px;">(b) that I have completed <input type="number" class="input-field input-field-small" value="{{ $data->candidate_age }}"> years of age;</div>
            <div class="strike-instruction" style="margin-top: 2px; text-align: center;">
                [STRIKE OUT c(i) OR c(ii) BELOW WHICHEVER IS NOT APPLICABLE]
            </div>
            <div style="margin-top: 10px;">
                (c) (i) I am set up at this election by the <input type="text" class="input-field input-field-medium" value="{{ $data->party_name }}" style="width: 283px;"> party, which is recognised     
            <label>
                <input type="radio" name="party_type" value="{{ $data->party_type }}" value="national"> National Party
            </label>/
            <label>
                <input type="radio" name="party_type" value="{{ $data->party_type }}" value="state"> State Party
            </label>
            in this State and that the symbol reserved for the above party be allotted to me.
                <div style="margin: 10px 0 0; text-align: center;">OR</div>
                <div class="full-strike">
                    (ii) I am set up at this election by the <input type="text" class="input-field input-field-medium" readonly> party, which is a registered unrecognised political party/that I am contesting this election as an independent candidate. (Strike out which is not applicable) and that the symbols I have chosen, in order of preference, are: —
                    <div style="margin-left: 20px;">
                        (i) <input type="text" class="input-field input-field-medium" readonly> 
                        (ii) <input type="text" class="input-field input-field-medium" readonly> 
                        (iii) <input type="text" class="input-field input-field-medium" readonly>
                    </div>
                </div>
            </div>
            <div style="margin-top: 3px;">
                (d) my name and my 
                <div wire:key="relation-type-2">
                    <label>
                        <input type="radio" name="relation_type_copy" value="{{ $data->relation_type }}" value="father"> Father's
                    </label>
                    /
                    <label>
                        <input type="radio" name="relation_type_copy" value="{{ $data->relation_type }}" value="mother"> Mother's
                    </label>
                    /
                    <label>
                        <input type="radio" name="relation_type_copy" value="{{ $data->relation_type }}" value="husband"> Husband's
                    </label> 
                </div>
                name have been correctly spelt out above in 
                <input type="text" class="input-field input-field-medium" value="{{ $data->language_name }}"> (name of the language); and
            </div>
            <div style="margin-top: 3px;">
                (e) That to the best of my knowledge and belief, I am qualified and not also disqualified for being chosen to fill the seat in the Legislative Assembly of this State.
            </div>

            <div class="full-strike">
                <div style="margin-top: 15px;">
                    * I further declare that I am a member of the <input type="text" class="input-field input-field-medium" readonly>**Caste/tribe which is a scheduled 
                </div>
                <div style="margin-top: 3px;">
                    **caste/tribe of the State of 
                    <input type="text" class="input-field input-field-medium" readonly> in relation to 
                    <input type="text" class="input-field input-field-medium" readonly> (area) in that State.
                </div>
            </div>

        </div>

        <!---keep togathor start-->
        <div class="keep-together">
            <div style="margin-top: 15px; ">
                I also declare that I have not been, and shall not be nominated as a candidate at the present general     <label>
                    <input type="radio" value="{{ $data->relation_type }}" value="general">
                    General Election
                </label>

                <label style="margin-left: 15px;">
                    <input type="radio" value="{{ $data->relation_type }}" value="bye">
                    Bye-Election
                </label> being held simultaneously, to the Legislative Assembly 
                <input type="text" class="input-field input-field-medium" value="{{ $data->state_name }}"> of (State) from more than two Assembly constituencies.
            </div>
            <div style="margin-top: 37px; display: flex; justify-content: space-between; ">
                <div>
                    Date: <input type="text" class="input-field input-field-medium" style="width:105px;">
                </div>
                <div>
                    Signature of Candidate
                </div>
            </div>
            <div style="border-top:1px solid #000; border-bottom:1px solid #000; padding-bottom: 30px; font-size: 10.8px; line-height: 1.8; margin-top: 20px;">
                * Score out this paragraph, if not applicable.<br>
                ** Score out the words not applicable.<br>
                N.B.—A "recognised political party" means a political party recognised by the Election Commission under the Election Symbols (Reservation and Allotment) Order, 1968 in the State concerned.
            </div>
            <!-- PART IIIA -->
            <div class="section-title" style="text-align: center; margin-bottom: 0;">PART IIIA</div>
            <div style="text-align: center; font-size: 13.3px;">(To be filled by the candidate)</div>
            <div style="line-height: 1; margin-top: 5px;">(1) Whether the candidate—</div>
            <div style="margin-left: 30px; line-height: 1.21;">
                <div class="checkbox-group" style="display: flex; align-items: center;">
                    <div style="border-radius: 12px; border-right: 2px solid #000;  padding-right: 29px;">
                        (i) has been convicted—
                        <div style="margin-left: 30px;">
                            <div style="padding-left: 20px;">
                            (a) of any offence(s) under sub-section (1); or
                            (b) for contravention of any law specified in sub-section (2) of section 8 of the Representation of the People Act, 1951 (43 of 1951); or</div>
                        </div>
                        (ii) has been convicted for any other offence(s) for which he has been sentenced to imprisonment for two years or more.
                    </div>
                    <label>
                        <input type="radio" name="convicted" value="{{ $data->convicted }}" value="yes"> Yes
                    </label>
                    <label>
                        <input type="radio" name="convicted" value="{{ $data->convicted }}" value="no"> No
                    </label>
                </div>
            </div> 
            @if($data->convicted === 'yes')
                <div style="margin-top: 25px;">
                    If the answer is "Yes", the candidate shall furnish the following information:
                </div>
                <div style="margin-left: 20px; line-height: 1.21;">(i) Case/First information report No./Nos. <input type="text" class="input-field input-field-large" value="{{ $data->case_no }}"></div>
                <div style="margin-left: 20px; line-height: 1.21;">(ii) Police station(s) <input type="text" class="input-field" style="width: 139px;" value="{{ $data->police_station }}"> District(s) <input type="text" class="input-field" style="width: 139px;" value="{{ $data->district }}"> State(s) <input type="text" class="input-field" style="width: 139px;" value="{{ $data->state }}"></div>
                <div style="margin-left: 20px; line-height: 1.21;">(iii) Section(s) of the concerned Act(s) and brief description of the offence(s) for which he has been convicted <input type="text" class="input-field input-field-large" value="{{ $data->sections }}"></div>
                <div style="margin-left: 20px; line-height: 1.21;">(iv) Date(s) of conviction(s) <input type="date" class="input-field input-field-medium" style="width: 139px;" value="{{ $data->conviction_date }}"></div>
                <div style="margin-left: 20px; line-height: 1.21;">(v) Court(s) which convicted the candidate <input type="text" class="input-field input-field-medium" style="width: 331px;" value="{{ $data->court }}"></div>
                <div style="margin-left: 20px; line-height: 1.21;">(vi) Punishment(s) imposed [indicate period of imprisonment(s) and/or quantum of fine(s)] <input type="text" class="input-field input-field-large" value="{{ $data->punishment }}"></div>
                <div style="margin-left: 20px; line-height: 1.21;">(vii) Date(s) of release from prison <input type="date" class="input-field input-field-medium" value="{{ $data->release_date }}"></div>
                <div style="margin-left: 20px; line-height: 1.21;">(viii) Was/were any appeal(s)/revision(s) filed against above conviction(s)
                <label>
                <input type="radio" name="appeal_filed" value="{{ $data->appeal_filed }}" value="yes"> Yes
                </label>
                <label>
                    <input type="radio" name="appeal_filed" value="{{ $data->appeal_filed }}" value="no"> No
                </label></div>
                <div style="margin-left: 20px; line-height: 1.21;">(ix) Date and particulars of the appeal(s)/application(s) for revision filed <input type="text" class="input-field input-field-large" style="width: 430px;" value="{{ $data->appeal_details }}"></div>
                <div style="margin-left: 20px; line-height: 1.21;">(x) Name of the court(s) before which the appeal(s)/application(s) for revision filed <input type="text" class="input-field input-field-medium"  value="{{ $data->appeal_court }}"></div>
                <div style="margin-left: 20px; line-height: 1.21;">(xi) Whether the said appeal(s)/application(s) for revision has/have been disposed of or is/are pending <input type="text" class="input-field input-field-medium" value="{{ $data->appeal_status }}"></div>
                <div style="margin-left: 20px; line-height: 1.21;">(xii) If the said appeal(s)/application(s) for revision has/have been disposed of—</div>
                <div style="margin-left: 60px;">
                    <div>(a) Date(s) of disposal <input type="date" class="input-field input-field-medium" value="{{ $data->disposal_date }}"></div>
                    <div>(b) Nature of order(s) passed <input type="text" class="input-field input-field-medium" value="{{ $data->order_nature }}"></div>
                </div>
            @endif
        </div>

        <!---keep togathor start-->
        <div class="keep-together">    
            <div style="margin-top: 20px;">
                {{-- <div>(2) Whether the candidate is holding any office of profit under the Government of India or State Government? <input type="text" class="input-field input-field-medium" style="width:90px;" wire:model="office_of_profit"> <span class="strike-out">Yes</span>/<span>No</span></div>
                <div style="margin-top: 10px;">
                    - If Yes, details of the office held <input type="text" class="input-field input-field-large" wire:model="office_details">
                </div> --}}
                <div>
                    (2) Whether the candidate is holding any office of profit under the Government of India or State Government?
                    
                    <label>
                        <input type="radio" name="office_of_profit" value="{{ $data->office_of_profit }}" value="yes"> Yes
                    </label>
                    /
                    <label>
                        <input type="radio" name="office_of_profit" value="{{ $data->office_of_profit }}" value="no"> No
                    </label>
                </div>
                <div style="margin-top: 10px;">
                    - If Yes, details of the office held
                    <input type="text"
                        class="input-field input-field-large"
                        value="{{ $data->office_details }}">
                </div>
            </div>
                
            <div style="margin-top: 15px;">
                <div>
                    (3) Whether the candidate has been declared insolvent by any Court?

                    <label>
                        <input type="radio" name="insolvent" value="{{ $data->insolvent }}" value="yes"> Yes
                    </label>
                    /
                    <label>
                        <input type="radio" name="insolvent" value="{{ $data->insolvent }}" value="no"> No
                    </label>
                </div>

                <div style="margin-top: 10px;">
                    - If Yes, has he been discharged from insolvency
                    <input type="text"
                        class="input-field input-field-medium"
                        value="{{ $data->insolvent_details }}">
                </div>
            </div>
                
            <div style="margin-top: 15px;">
               <div>
                    (4) Whether the candidate is under allegiance or adherence to any foreign country?

                    <label>
                        <input type="radio" name="foreign_allegiance" value="{{ $data->foreign_allegiance }}" value="yes"> Yes
                    </label>
                    /
                    <label>
                        <input type="radio" name="foreign_allegiance" value="{{ $data->foreign_allegiance }}" value="no"> No
                    </label>
                </div>
                <div style="margin-top: 10px;">
                    - If Yes, give details
                    <input type="text"
                        class="input-field input-field-large"
                        value="{{ $data->foreign_allegiance_details }}">
                </div>
            </div>
                
            <div style="margin-top: 15px;">
                <div>
                    (5) Whether the candidate has been disqualified under section 8A of the said Act by an order of the President?

                    <label>
                        <input type="radio" name="disqualified_president" value="{{ $data->disqualified_president }}" value="yes"> Yes
                    </label>
                    /
                    <label>
                        <input type="radio" name="disqualified_president" value="{{ $data->disqualified_president }}" value="no"> No
                    </label>
                </div>

                <div style="margin-top: 10px;">
                    - If Yes, the period for which disqualified
                    <input type="text"
                        class="input-field input-field-medium"
                        value="{{ $data->disqualified_period }}">
                </div>
            </div>

                
            <div style="margin-top: 8px;">
                <div style="line-height: 1.8;">
                    (6) Whether the candidate was dismissed for corruption or for disloyalty while holding office under the Government of India or the Government of any State?

                    <label>
                        <input type="radio" name="dismissed_for_corruption" value="{{ $data->dismissed_for_corruption }}" value="yes"> Yes
                    </label>
                    /
                    <label>
                        <input type="radio" name="dismissed_for_corruption" value="{{ $data->dismissed_for_corruption }}" value="no"> No
                    </label>
                </div>
                <div style="margin-top: 5px;">
                    - If Yes, the date of such dismissal
                    <input type="date"
                        class="input-field input-field-medium"
                        value="{{ $data->dismissed_date }}">
                </div>
            </div>

                
            <div style="margin-top: 8px;">
                <div style="line-height: 1.8;">
                    (7) Whether the candidate has any subsisting contract(s) with the Government?

                    <label>
                        <input type="radio" name="govt_contract" value="{{ $data->govt_contract }}" value="yes"> Yes
                    </label>
                    /
                    <label>
                        <input type="radio" name="govt_contract" value="{{ $data->govt_contract }}" value="no"> No
                    </label>
                </div>

                <div style="line-height: 1.8;">
                    - If Yes, with which Government and details of subsisting contract(s)
                    <input type="text"
                        class="input-field input-field-large"
                        value="{{ $data->govt_contract_details }}">
                </div>
            </div>

                
            <div style="margin-top: 8px;">
                <div style="line-height: 1.8;">
                    (8) Whether the candidate is a managing agent, manager or Secretary of any company or Corporation?

                    <label>
                        <input type="radio" name="company_position" value="{{ $data->company_position }}" value="yes"> Yes
                    </label>
                    /
                    <label>
                        <input type="radio" name="company_position" value="{{ $data->company_position }}" value="no"> No
                    </label>
                </div>

                <div style="line-height: 1.8;">
                    - If Yes, with which Government and the details thereof
                    <input type="text"
                        class="input-field input-field-large"
                        value="{{ $data->company_details }}">
                </div>
            </div>

                
            <div style="margin-top: 8px;">
                <div style="line-height: 1.8;">
                    (9) Whether the candidate has been disqualified by the Commission under section 10A of the said Act?

                    <label>
                        <input type="radio" name="commission_disqualified" value="{{ $data->commission_disqualified }}" value="yes"> Yes
                    </label>
                    /
                    <label>
                        <input type="radio" name="commission_disqualified" value="{{ $data->commission_disqualified }}" value="no"> No
                    </label>
                </div>

                <div style="line-height: 1.8;">
                    - If Yes, the date of disqualification
                    <input type="date"
                        class="input-field input-field-medium"
                        value="{{ $data->commission_disqualified_date }}">
                </div>
            </div>

                
            <div style="display: flex; justify-content: space-between; margin-top: 30px;">
                <div>
                    Place: <input type="text" class="input-field input-field-medium" readonly style="background: none;" placeholder="">
                    <br>
                    Date: <input type="text" class="input-field input-field-medium" readonly style="background: none;">
                </div>
                
                <div style="align-self: flex-end;">
                    Signature of the candidate
                </div>
            </div>
            

            <!-- PART IV -->
            
            <div class="section-title" style="text-align: center; margin-bottom: 0;">PART IV </div>
            <div style="text-align: center; font-size: 13.3px;">(To be filled by the Returning Officer)</div> 
            <div style="margin-top: 8px;">
                Serial No. of nomination paper <input type="text" class="input-field input-field-medium">
            </div>
            <div style="margin-top: 8px;">
                This nomination was delivered to me at my office at 
                <input type="text" class="input-field input-field-small">(hour) on
                <input type="text" class="input-field input-field-small">(date) by the *candidate/proposer (Name).
            </div>
            <div style="display: flex; justify-content: space-between; margin-top: 20px;">
                <div>Date <input type="text" class="input-field input-field-medium" style="width: 100px;"></div>
                
                <div>
                    Returning Officer
                </div>
            </div>
            <div style="border-top: 1px solid #000; font-size: 10.8px; line-height: 1.8; margin-top: 15px;">
                * Score out the word not applicable.
            </div>
        </div>

        <!---keep togathor start-->
        <div class="keep-together">
            <!-- PART V -->
            <div class="section">
                <div class="section-title" style="text-align: center; margin-bottom: 0;">PART V</div>
                <div class="section-title" style="text-align: center; margin-bottom: 0;">Decision of Returning Officer Accepting or Rejecting the Nomination Paper</div>
                <div style="margin-top: 0px;">
                    I have examined this nomination paper in accordance with section 36 of the Representation of the People Act, 1951 and decide as follows: —
                </div>
                
                <div style="margin-top: 8px;">
                    <input type="text" class="input-field input-field-medium" style="width: 100%;" readonly>
                    <input type="text" class="input-field input-field-medium" style="width: 100%;" readonly>
                    <input type="text" class="input-field input-field-medium" style="width: 100%;" readonly>
                </div>
                
                <div style="display: flex; justify-content: space-between; margin-top: 36px;">
                    <div>
                        Date: <input type="text" class="input-field input-field-medium" style="width: 110px;" readonly>
                    </div>
                    
                    <div >
                        Returning Officer
                    </div>
                </div>
            </div>

            <div style="border-top:2px dotted #000; margin-top:20px; position: relative; text-align: center;">
                <span style="position: absolute; top:-18px; left:0; width: 89px; right:0; background: #fff; margin: auto;">(Perforation)</span>
            </div>

            <!-- PART VI -->
            <div class="section" style="margin-top: 20px;">
                <div class="section-title" style="text-align: center; margin-bottom: 0;">PART VI</div>
                <div class="section-title" style="text-align: center; margin-bottom: 0;">Receipt for Nomination Paper and Notice of Scrutiny</div>
                <div style="text-align: center;">(To be handed over to the person presenting the Nomination Paper)</div>
                
                <div style="margin-top: 10px;">
                    Serial No. of nomination paper <input type="text" class="input-field input-field-medium">
                </div>
                
                <div style="margin-top: 10px; text-align: justify;">
                    The nomination paper of <input type="text" class="input-field input-field-medium" placeholder="MAMATA BANERJEE"> a candidate for election from the 
                    <input type="text" class="input-field input-field-medium" placeholder="210 NANDIGRAM"> Assembly constituency was delivered to me at my office at 
                    <input type="text" class="input-field input-field-small" placeholder="">(hour) on 
                    <input type="text" class="input-field input-field-medium" style="width: 136px;"> (date) by the 
                    <span>candidate</span>/<span>proposer</span>. All nomination papers will be taken up for scrutiny at 
                    <input type="text" class="input-field input-field-small">(hour) on 
                    <input type="text" class="input-field input-field-medium" style="width: 136px;">(date) at 
                    <input type="text" class="input-field input-field-medium">(place).
                </div>
                
                <div style="display: flex; justify-content: space-between; margin-top: 40px;">
                    <div>
                        Date: <input type="text" class="input-field input-field-medium" style="width: 110px;" readonly>
                    </div>
                    
                    <div >
                        Returning Officer
                    </div>
                </div>
                
                <div style="border-top: 1px solid #000; font-size: 10.8px; line-height: 1.8; margin-top: 15px;">
                * Score out the word not applicable.
                </div>
            </div>

            <!-- <div class="footer">
                <div>5</div>
            </div> -->
        </div>

        <div class="mt-4 d-flex gap-3">
            <button type="button"
                    class="btn btn-primary"
                    wire:click="save">
                Save & Generate PDF
            </button>
        </div>

    </form>
    </div>
</body>
</html>
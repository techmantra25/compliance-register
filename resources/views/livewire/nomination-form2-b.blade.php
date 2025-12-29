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

            <div style="text-align: right; overflow: auto; margin-bottom: 16px;">
                <div style="font-size: 12px; line-height:1.35; font-style: italic; text-align: justify; border:1px solid #000; width:114px; height: 145px; padding:5px; font-weight: bold; float: right; display: flex; align-items:center; justify-content: center;">
                    <!-- Recent stamp size
                    (2cm X 2.5cm)
                    photograph in
                    white/off white
                    background with
                    full face view. -->
                    <img src="data:image/png;base64,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">
                </div>

            </div>

            <div class="strike-instruction" style="font-size: 16px; line-height: 1.21; color:#000; text-align: center;">
                STRIKE OFF PART I OR PART II BELOW WHICHEVER IS NOT APPLICABLE
            </div>

            <form wire:submit.prevent="save">

                <!-- PART I -->
                <div class="section">
                    <div style="text-align: center; line-height: 1.21; font-weight: bold; font-size: 16px;" >PART I</div>
                    <div class="section-title" style="text-align: center; font-weight: normal; margin-bottom: 7px;"> (To be used by candidate set up by recognised political party)</div>
                    <div style="font-size: 16px; line-height: 2; text-align: justify;">
                        I nominate as a candidate for election to the Legislative Assembly from the 
                        <input type="text" class="input-field input-field-large" wire:model="assembly_name" style="width:228px;" readonly> Assembly Constituency. 
                        
                    </div>

                    <div style="font-size: 16px; line-height: 2;">
                        Candidate's name <input type="text" class="input-field input-field-large" wire:model="candidate_name" readonly style="width: 300px;">
                        <span>Father's</span>/<span class="strike-out">mother's</span>/<span class="strike-out">husband's </span>name <input type="text" class="input-field input-field-medium" wire:model="relation_name" style="width: 400px;">  
                        <span class="strike-out">His</span>/<span>Her</span> postal address<input type="text" class="input-field input-field-large" style="width: 428px;" wire:model="postal_address">
                        <span class="strike-out">His</span>/<span>Her</span> name is entered at Sl. No<input type="text" class="input-field input-field-small" wire:model="candidate_sl_no"> in Part No. 
                        <input type="text" class="input-field input-field-small" wire:model="candidate_part_no"> of the electoral roll for 
                        <input type="text" class="input-field input-field-medium" wire:model="assembly_name" style="width: 229px;"> Assembly constituency.
                    </div>
                    
                    <div style=" font-size: 16px; line-height: 2;">
                        My name is <input type="text" class="input-field input-field-large" wire:model="proposer_name"> and it is entered at Sl. No. 
                        <input type="text" class="input-field input-field-small" wire:model="proposer_sl_no"> in Part No 
                        <input type="text" class="input-field input-field-small" wire:model="proposer_part_no"> of the electoral roll for the 
                        <input type="text" class="input-field input-field-medium" wire:model="proposer_constituency" style="width: 227px;"> Assembly constituency.
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
            <div style="margin-top: 2px;">(b) that I have completed <input type="number" class="input-field input-field-small" wire:model="candidate_age"> years of age;</div>
            <div class="strike-instruction" style="margin-top: 2px; text-align: center;">
                [STRIKE OUT c(i) OR c(ii) BELOW WHICHEVER IS NOT APPLICABLE]
            </div>
            <div style="margin-top: 10px;">
                (c) (i) I am set up at this election by the <input type="text" class="input-field input-field-medium" wire:model="party_name" style="width: 283px;"> party, which is recognised     
            <label>
                <input type="radio" wire:model="party_type" value="national"> National Party
            </label>/
            <label>
                <input type="radio" wire:model="party_type" value="state"> State Party
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
                (d) my name and my <span>father's</span>/<span class="strike-out">mother's</span>/<span class="strike-out">husband's</span> name have been correctly spelt out above in 
                <input type="text" class="input-field input-field-medium" wire:model="language_name"> (name of the language); and
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
                    <input type="radio" wire:model="election_type" value="general">
                    General Election
                </label>

                <label style="margin-left: 15px;">
                    <input type="radio" wire:model="election_type" value="bye">
                    Bye-Election
                </label> being held simultaneously, to the Legislative Assembly 
                <input type="text" class="input-field input-field-medium" wire:model="state_name"> of (State) from more than two Assembly constituencies.
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
                            <input type="radio" wire:model="convicted" value="yes"> Yes
                        </label>
                        <label>
                            <input type="radio" wire:model="convicted" value="no"> No
                        </label>
                </div>
            </div> 
            <div style="margin-top: 25px;">
                If the answer is "Yes", the candidate shall furnish the following information:
            </div>
            @if($convicted === 'yes')
                <div style="margin-left: 20px; line-height: 1.21;">(i) Case/First information report No./Nos. <input type="text" class="input-field input-field-large" placeholder="NOT APPLICABLE" readonly></div>
                <div style="margin-left: 20px; line-height: 1.21;">(ii) Police station(s) <input type="text" class="input-field" style="width: 139px;" readonly placeholder="NOT APPLICABLE"> District(s) <input type="text" class="input-field" style="width: 139px;" readonly placeholder="NOT APPLICABLE"> State(s) <input type="text" class="input-field" style="width: 139px;" readonly placeholder="NOT APPLICABLE"></div>
                <div style="margin-left: 20px; line-height: 1.21;">(iii) Section(s) of the concerned Act(s) and brief description of the offence(s) for which he has been convicted <input type="text" class="input-field input-field-large" readonly placeholder="NOT APPLICABLE"></div>
                <div style="margin-left: 20px; line-height: 1.21;">(iv) Date(s) of conviction(s) <input type="text" class="input-field input-field-medium" style="width: 139px;" readonly placeholder="NOT APPLICABLE"></div>
                <div style="margin-left: 20px; line-height: 1.21;">(v) Court(s) which convicted the candidate <input type="text" class="input-field input-field-medium" style="width: 331px;" readonly placeholder="NOT APPLICABLE"></div>
                <div style="margin-left: 20px; line-height: 1.21;">(vi) Punishment(s) imposed [indicate period of imprisonment(s) and/or quantum of fine(s)] <input type="text" class="input-field input-field-large" readonly placeholder="NOT APPLICABLE"></div>
                <div style="margin-left: 20px; line-height: 1.21;">(vii) Date(s) of release from prison <input type="text" class="input-field input-field-medium" readonly placeholder="NOT APPLICABLE"></div>
                <div style="margin-left: 20px; line-height: 1.21;">(viii) Was/were any appeal(s)/revision(s) filed against above conviction(s) <input type="text" class="input-field input-field-medium" style="width: 100px;"> <span class="strike-out">Yes</span>/<span>No</span></div>
                <div style="margin-left: 20px; line-height: 1.21;">(ix) Date and particulars of the appeal(s)/application(s) for revision filed <input type="text" class="input-field input-field-large" style="width: 430px;" readonly placeholder="NOT APPLICABLE"></div>
                <div style="margin-left: 20px; line-height: 1.21;">(x) Name of the court(s) before which the appeal(s)/application(s) for revision filed <input type="text" class="input-field input-field-medium" readonly placeholder="NOT APPLICABLE"></div>
                <div style="margin-left: 20px; line-height: 1.21;">(xi) Whether the said appeal(s)/application(s) for revision has/have been disposed of or is/are pending <input type="text" class="input-field input-field-medium" readonly placeholder="NOT APPLICABLE"></div>
                <div style="margin-left: 20px; line-height: 1.21;">(xii) If the said appeal(s)/application(s) for revision has/have been disposed of—</div>
                <div style="margin-left: 60px;">
                    <div>(a) Date(s) of disposal <input type="text" class="input-field input-field-medium" readonly placeholder="NOT APPLICABLE"></div>
                    <div>(b) Nature of order(s) passed <input type="text" class="input-field input-field-medium" readonly placeholder="NOT APPLICABLE"></div>
                </div>
            @else
                <input type="text" readonly value="NOT APPLICABLE">
            @endif
        </div>

        <!---keep togathor start-->
        <div class="keep-together">    
            <div style="margin-top: 20px;">
                <div>(2) Whether the candidate is holding any office of profit under the Government of India or State Government? <input type="text" class="input-field input-field-medium" style="width:90px;" wire:model="office_of_profit"> <span class="strike-out">Yes</span>/<span>No</span></div>
                <div style="margin-top: 10px;">
                    - If Yes, details of the office held <input type="text" class="input-field input-field-large" wire:model="office_details">
                </div>
            </div>
                
            <div style="margin-top: 15px;">
                <div>(3) Whether the candidate has been declared insolvent by any Court?<input type="text" class="input-field input-field-medium" style="width:90px;" wire:model="insolvent"><span class="strike-out">Yes</span>/<span>No</span></div>
                <div style="margin-top: 10px;">
                    - If Yes, has he been discharged from insolvency <input type="text" class="input-field input-field-medium" style="width:160px;" wire:model="insolvent_details">
                </div>
            </div>
                
            <div style="margin-top: 15px;">
                <div>(4) Whether the candidate is under allegiance or adherence to any foreign country?<input type="text" class="input-field input-field-medium" style="width:90px;" wire:model="foreign_allegiance">(<span class="strike-out">Yes</span>/<span>No</span>)</div>
                <div style="margin-top: 10px;">
                    - If Yes, give details <input type="text" class="input-field input-field-large" wire:model="foreign_details">
                </div>
            </div>
                
            <div style="margin-top: 15px;">
                <div>(5) Whether the candidate has been disqualified under section 8A of the said Act by an order of the President?<input type="text" class="input-field input-field-medium" style="width:90px;" wire:model="disqualified_president">(<span class="strike-out">Yes</span>/<span>No</span>)</div>
                
                <div style="margin-top: 10px;">
                    - If Yes, the period for which disqualified <input type="text" class="input-field input-field-medium" wire:model="disqualified_period">
                </div>
            </div>
                
            <div style="margin-top: 8px;">
                <div style="line-height: 1.8;">(6) Whether the candidate was dismissed for corruption or for disloyalty while holding office under the Government of India or the Government of any State?<input type="text" class="input-field input-field-medium" style="width:90px;" wire:model="dismissed_for_corruption">(<span class="strike-out">Yes</span>/<span>No</span>) </div>
                <div style="margin-top: 5px;">
                    - If Yes, the date of such dismissal <input type="text" class="input-field input-field-medium" style="width: 143px;" wire:model="dismissed_date">
                </div>
            </div>
                
            <div style="margin-top: 8px;">
                <div style="line-height: 1.8;">(7) Whether the candidate has any subsisting contract(s) with the Government either in individual capacity or by trust or partnership in which the candidate has a share for supply of any goods to that Government or for execution of works undertaken by that Government?
                    <input type="text" class="input-field input-field-medium" style="width:90px;" wire:model="govt_contract">(<span class="strike-out">Yes</span>/<span>No</span>)
                </div>
                <div style="line-height: 1.8;">
                    - If Yes, with which Government and details of subsisting contract(s) <input type="text" class="input-field input-field-large" style="width: 225px;" wire:model="govt_contract_details">
                </div>
            </div>
                
            <div style="margin-top: 8px;">
                <div style="line-height: 1.8;">(8)  Whether the candidate is a managing agent, or manager or Secretary of any company or Corporation (other than a cooperative society) in the capital of which the Central Government or State Government has not less than twenty-five percent share? 
                    <input type="text" class="input-field input-field-medium" style="width:90px;" wire:model="company_position">(<span class="strike-out">Yes</span>/<span>No</span>) 
                </div>

                <div style="line-height: 1.8;">
                    - If Yes, with which Government and the details thereof <input type="text" class="input-field input-field-large" wire:model="company_details">
                </div>
            </div>
                
            <div style="margin-top: 8px;">
                <div style="line-height: 1.8;">(9) Whether the candidate has been disqualified by the Commission under section 10A of the said Act 
                    <input type="text" class="input-field input-field-medium" style="width:90px;" wire:model="commission_disqualified">(<span class="strike-out">Yes</span>/<span>No</span>)
                </div>
                <div style="line-height: 1.8;">
                    - If yes, the date of disqualification <input type="text" class="input-field input-field-medium" wire:model="commission_disqualified_date">
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

        <div style="margin-top: 40px; text-align: center;">
            <button type="submit" class="btn btn-primary px-4">
                Submit Form 2B
            </button>
        </div>
</form>
        

    </div>
</body>
</html>

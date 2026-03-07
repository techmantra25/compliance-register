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

        .input-field:focus {
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
            border: 0;
        }

        th,
        td {
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
            color: #000;
        }

        .full-strike,
        .full-strike2 {
            position: relative;
            z-index: 1;
        }

        .full-strike:after,
        .full-strike2:after {
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

        .strike-out {
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
                padding: 0px;
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

            .full-strike:after,
            .full-strike2:after {
                background-color: #000 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                transform: rotate(45deg);

            }

        }
    </style>
    <div class="form-container">
        <!---keep togathor start-->
        <form wire:submit.prevent="save" enctype="multipart/form-data">
            <div class="keep-together">
                <div class="form-header">
                    <div class="form-title">FORM 2B</div>
                    <div class=".form-title">(See rule 4)</div>
                    <div class="form-title">NOMINATION PAPER</div>
                    <div style="font-style: italic; font-size: 16px; line-height: 1.21;">Election to the Legislative
                        Assembly of
                        <span class="input-field input-field-large"
                            style="width:125px;">{{$nomination->state}}
                        </span>(state)
                    </div>
                </div>

                <div style="text-align: right; overflow: auto; margin-bottom: 16px;">
                    <div
                        style="font-size: 12px; line-height:1.35; font-style: italic; text-align: justify; border:1px solid #000; width:114px; height: 145px; padding:5px; font-weight: bold; float: right; display: flex; align-items:center; justify-content: center;">
                        Recent stamp size
                    (2cm X 2.5cm)
                    photograph in
                    white/off white
                    background with
                    full face view.
                    </div>
                </div>

                <div class="strike-instruction"
                    style="font-size: 16px; line-height: 1.21; color:#000; text-align: center;">
                    STRIKE OFF PART I OR PART II BELOW WHICHEVER IS NOT APPLICABLE
                </div>


                <!-- PART I -->
                <div class="section">
                    <div style="text-align: center; line-height: 1.21; font-weight: bold; font-size: 16px;">PART I</div>
                    <div class="section-title" style="text-align: center; font-weight: normal; margin-bottom: 7px;"> (To
                        be used by candidate set up by recognised political party)</div>
                    <div style="font-size: 16px; line-height: 2; text-align: justify;">
                        I nominate as a candidate for election to the Legislative Assembly from the
                        <span class="input-field input-field-large"
                            style="width:228px;" readonly>{{ $nomination->assembly->assembly_name_en }}-{{$nomination->assembly->assembly_number}}
                        </span>Assembly Constituency
                    </div>

                    <div style="font-size: 16px; line-height: 2;">
                        Candidate's name <span class="input-field input-field-large"
                        readonly style="width: 300px;">{{ucwords($nomination->candidate->name)}}</span>
                        <span class="input-field input-field-small">
                            {{ ucfirst($nomination->relation_type) }}'s
                        </span>
                        name <span class="input-field input-field-medium" style="width: 400px;">{{ucwords($nomination->relation_name)}}</span>
                        <div>
                            <label>
                                <input type="radio" name="pronoun-main" value="his"
                                    {{ $nomination->pronoun == 'his' ? 'checked' : '' }}>
                                His
                            </label>

                            <label>
                                <input type="radio" name="pronoun-main" value="her"
                                    {{ $nomination->pronoun == 'her' ? 'checked' : '' }}>
                                Her
                            </label>
                        </div>

                        postal address
                        <span class="input-field input-field-large" style="width: 428px;">
                            {{ ucwords($nomination->postal_address) }}
                        </span>

                        <div>
                            <label>
                                <input type="radio" name="pronoun-copy" value="his"
                                    {{ $nomination->pronoun == 'his' ? 'checked' : '' }}>
                                His
                            </label>

                            <label>
                                <input type="radio" name="pronoun-copy" value="her"
                                    {{ $nomination->pronoun == 'her' ? 'checked' : '' }}>
                                Her
                            </label>
                        </div>
                        name is entered at Sl. No<span class="input-field input-field-small">{{$nomination->candidate_serial_no}}</span>in Part No.
                        <span class="input-field input-field-small">{{$nomination->candidate_part_no}}</span>of the
                        electoral roll for
                        <span class="input-field input-field-medium"
                            style="width: 229px;">{{ucwords($nomination->constituency_where_enrolled)}}
                        </span> Assembly constituency.
                    </div>

                    <div style=" font-size: 16px; line-height: 2;">
                        My name is <span class="input-field input-field-large">{{ucwords($nomination->proposer_name)}}</span>
                        and it is entered at Sl. No.
                        <span class="input-field input-field-small">{{$nomination->proposer_part_no}}</span>in Part No
                        <span class="input-field input-field-small">{{$nomination->proposer_serial_no}}</span>of the
                        electoral roll for the
                        <span class="input-field input-field-medium" style="width: 227px;">{{ucwords($nomination->proposer_constituency)}}</span>Assembly constituency.
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
                        <div class="section-title"
                            style="text-align: center; line-height: 1.21; font-weight: bold; font-size: 16px; margin-bottom: 0; ">
                            PART II</div>
                        <div style="text-align: justify;">
                            We hereby nominate as candidate for election to the Legislative Assembly from the
                            <input type="text" class="input-field input-field-large"> Assembly Constituency.
                        </div>

                        <div style="margin-top: 15px;">
                            Candidate's name: <input type="text" class="input-field input-field-large">
                            <span>Father's</span>/<span class="strike-out">mother's</span>/ <span
                                class="strike-out">husband's</span> name: <input type="text"
                                class="input-field input-field-medium">
                            His postal address: <input type="text" class="input-field input-field-large"
                                style="width: 400px;">
                            His name is entered at Sl. No. <input type="text" class="input-field input-field-small"> in
                            Part No.
                            <input type="text" class="input-field input-field-small"> of the electoral roll for
                            <input type="text" class="input-field input-field-medium"> Assembly constituency.
                        </div>
                    </div>
                </div>
            </div>

            <!---keep togathor start-->
            <div class="keep-together"> 
                <div class="full-strike2">
                    <div style="margin-top: 15px; line-height:1.8; text-align: justify;">
                        We declare that we are electors of this Assembly constituency and our names are entered in the
                        electoral roll for this Assembly constituency as indicated below and we append our signatures
                        below in token of subscribing to this nomination:-
                    </div>

                    <div class="section-title"
                        style="text-align: center; font-size: 16px; font-weight: bold; margin-top: 20px; margin-bottom: 0;">
                        Particulars of the proposers and their signatures
                    </div>

                    <table style="margin-top: 0;">
                        <thead>
                            <tr>
                                <th style="border-width: 1px 1px 0px 0px; border-color: #000; border-style: solid;">
                                    Sl.no.</th>
                                <th colspan="2" style="border:1px solid #000;">Elector Roll No. of Proposer</th>
                                <th style="border-width: 1px 1px 0px 1px; border-color: #000; border-style: solid;">Full
                                    Name</th>
                                <th style="border-width: 1px 1px 0px 1px; border-color: #000; border-style: solid;">
                                    Signature</th>
                                <th style="border-width: 1px 0px 0px 1px; border-color: #000; border-style: solid;">Date
                                </th>
                            </tr>
                            <tr>
                                <th style="border-width: 0px 0px 1px 0px; border-color: #000; border-style: solid;">
                                </th>
                                <th style="border-width: 1px 1px 1px 1px; border-color: #000; border-style: solid;">Part
                                    No. of Electoral Roll</th>
                                <th style="border-width: 1px 1px 1px 1px; border-color: #000; border-style: solid;">
                                    S.No. in that part</th>
                                <th style="border-width: 0px 1px 1px 0px; border-color: #000; border-style: solid;">
                                </th>
                                <th style="border-width: 0px 1px 1px 0px; border-color: #000; border-style: solid;">
                                </th>
                                <th style="border-width: 0px 0px 1px 0px; border-color: #000; border-style: solid;">
                                </th>
                            </tr>
                            <tr>
                                <th style="border-width: 0px 0px 1px 0px; border-color: #000; border-style: solid;">1
                                </th>
                                <th style="border-width: 1px 1px 1px 1px; border-color: #000; border-style: solid;">2
                                </th>
                                <th style="border-width: 1px 1px 1px 1px; border-color: #000; border-style: solid;">3
                                </th>
                                <th style="border-width: 0px 0px 1px 0px; border-color: #000; border-style: solid;">4
                                </th>
                                <th style="border-width: 0px 0px 1px 0px; border-color: #000; border-style: solid;">5
                                </th>
                                <th style="border-width: 0px 0px 1px 0px; border-color: #000; border-style: solid;">6
                                </th>
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
                <div class="section-title" style="text-align: center; margin-bottom: 0; margin-top: 40px;">PART III
                </div>
                <div>I, the candidate mentioned in <span>Part I</span>/<span>Part II</span> (Strike out which is not
                    applicable) assent to this nomination and hereby declare that:</div>
                <div style="margin-top: 3px;">(a) I am a citizen of India and have not acquired the citizenship of any
                    foreign State;</div>
                <div style="margin-top: 2px;">(b) that I have completed <span
                        class="input-field input-field-small">{{$nomination->age}}</span>years of age;</div>
                <div class="strike-instruction" style="margin-top: 2px; text-align: center;">
                    [STRIKE OUT c(i) OR c(ii) BELOW WHICHEVER IS NOT APPLICABLE]
                </div>
                <div style="margin-top: 10px;">
                    (c) (i) I am set up at this election by the <span
                        class="input-field input-field-medium" style="width: 283px;">{{$nomination->political_party_name}}</span> party,
                    which is recognised
                    <span class="input-field input-field-small">{{$nomination->recognized_political_party}}</span>
                    in this State and that the symbol reserved for the above party be allotted to me.
                    <div style="margin: 10px 0 0; text-align: center;">OR</div>
                    <div class="full-strike">
                        (ii) I am set up at this election by the <input type="text"
                            class="input-field input-field-medium" readonly> party, which is a registered unrecognised
                        political party/that I am contesting this election as an independent candidate. (Strike out
                        which is not applicable) and that the symbols I have chosen, in order of preference, are: —
                        <div style="margin-left: 20px;">
                            (i) <input type="text" class="input-field input-field-medium" readonly>
                            (ii) <input type="text" class="input-field input-field-medium" readonly>
                            (iii) <input type="text" class="input-field input-field-medium" readonly>
                        </div>
                    </div>
                </div>
                <div style="margin-top: 3px;">
                    (d) my name and my
                        <span class="input-field input-field-small">
                            {{ ucfirst($nomination->relation_type) }}'s
                        </span>

                    name have been correctly spelt out above in
                    <span class="input-field input-field-medium" >{{$nomination->language_of_name}}</span>(name of the
                    language); and
                </div>
                <div style="margin-top: 3px;">
                    (e) That to the best of my knowledge and belief, I am qualified and not also disqualified for being
                    chosen to fill the seat in the Legislative Assembly of this State.
                </div>

                <div class="full-strike">
                    <div style="margin-top: 15px;">
                        * I further declare that I am a member of the <input type="text"
                            class="input-field input-field-medium" readonly>**Caste/tribe which is a scheduled
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
                    I also declare that I have not been, and shall not be nominated as a candidate at the present
                    general
                    <label>
                        <input type="radio" name="election_type" wire:model="election_type" value="general">
                        General Election
                    </label>

                    <label style="margin-left: 15px;">
                        <input type="radio" name="election_type" wire:model="election_type" value="bye">
                        Bye-Election
                    </label> 
                    being held simultaneously, to the Legislative Assembly
                    <input type="text" class="input-field input-field-medium" wire:model="state_name"> of {{$nomination->state}}(State) from
                    more than two Assembly constituencies.
                </div>
                <div style="margin-top: 37px; display: flex; justify-content: space-between; ">
                    <div>
                        Date: <input type="text" class="input-field input-field-medium" style="width:105px;">
                    </div>
                    <div>
                        Signature of Candidate
                    </div>
                </div>
                <div
                    style="border-top:1px solid #000; border-bottom:1px solid #000; padding-bottom: 30px; font-size: 10.8px; line-height: 1.8; margin-top: 20px;">
                    * Score out this paragraph, if not applicable.<br>
                    ** Score out the words not applicable.<br>
                    N.B.—A "recognised political party" means a political party recognised by the Election Commission
                    under the Election Symbols (Reservation and Allotment) Order, 1968 in the State concerned.
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
                                    (b) for contravention of any law specified in sub-section (2) of section 8 of the
                                    Representation of the People Act, 1951 (43 of 1951); or</div>
                            </div>
                            (ii) has been convicted for any other offence(s) for which he has been sentenced to
                            imprisonment for two years or more.
                        </div>
                        <div style="margin-left: 15px;">
                            <strong>{{ strtoupper($nomination->convicted ?? 'N/A') }}</strong>
                        </div>
                    </div>
                </div>
                @if(strtolower($nomination->convicted) === 'yes')
                    <div style="margin-top: 25px;">
                        If the answer is "Yes", the candidate shall furnish the following information:
                    </div>

                    <div style="margin-left: 20px; line-height: 1.21;">
                        (i) Case / First information report No./Nos.
                        <span class="input-field input-field-large">
                            {{ $nomination->convicted_details['case_no'] ?? 'Not Applicable' }}
                        </span>
                    </div>

                    <div style="margin-left: 20px; line-height: 1.21;">
                        (ii) Police station(s)
                        <span class="input-field" style="width: 139px;">
                            {{ $nomination->convicted_details['police_station'] ?? 'Not Applicable' }}
                        </span>
                        District(s)
                        <span class="input-field" style="width: 139px;">
                            {{ $nomination->convicted_details['district'] ?? 'Not Applicable' }}
                        </span>
                        State(s)
                        <span class="input-field" style="width: 139px;">
                            {{ $nomination->convicted_details['state'] ?? 'Not Applicable' }}
                        </span>
                    </div>

                    <div style="margin-left: 20px; line-height: 1.21;">
                        (iii) Section(s) of the concerned Act(s) and brief description of the offence(s)
                        <span class="input-field input-field-large">
                            {{ $nomination->convicted_details['sections'] ?? 'Not Applicable' }}
                        </span>
                    </div>

                    <div style="margin-left: 20px; line-height: 1.21;">
                        (iv) Date(s) of conviction(s)
                        <span class="input-field input-field-medium" style="width: 139px;">
                            {{ $nomination->convicted_details['conviction_date'] ?? 'Not Applicable' }}
                        </span>
                    </div>

                    <div style="margin-left: 20px; line-height: 1.21;">
                        (v) Court(s) which convicted the candidate
                        <span class="input-field input-field-medium" style="width: 331px;">
                            {{ $nomination->convicted_details['court'] ?? 'Not Applicable' }}
                        </span>
                    </div>

                    <div style="margin-left: 20px; line-height: 1.21;">
                        (vi) Punishment(s) imposed (imprisonment / fine)
                        <span class="input-field input-field-large">
                            {{ $nomination->convicted_details['punishment'] ?? 'Not Applicable' }}
                        </span>
                    </div>

                    <div style="margin-left: 20px; line-height: 1.21;">
                        (vii) Date(s) of release from prison
                        <span class="input-field input-field-medium">
                            {{ $nomination->convicted_details['release_date'] ?? 'Not Applicable' }}
                        </span>
                    </div>

                    <div style="margin-left: 20px; line-height: 1.21;">
                        (viii) Whether any appeal(s)/revision(s) filed
                        <strong>
                            {{ ucfirst($nomination->convicted_details['appeal_filed'] ?? 'Not Applicable') }}
                        </strong>
                    </div>

                    <div style="margin-left: 20px; line-height: 1.21;">
                        (ix) Date and particulars of appeal(s)/revision(s)
                        <span class="input-field input-field-large">
                            {{ $nomination->convicted_details['appeal_details'] ?? 'Not Applicable' }}
                        </span>
                    </div>

                    <div style="margin-left: 20px; line-height: 1.21;">
                        (x) Name of the court(s) where appeal(s) filed
                        <span class="input-field input-field-medium">
                            {{ $nomination->convicted_details['appeal_court'] ?? 'Not Applicable' }}
                        </span>
                    </div>

                    <div style="margin-left: 20px; line-height: 1.21;">
                        (xi) Whether appeal(s) disposed of or pending
                        <span class="input-field input-field-medium">
                            {{ $nomination->convicted_details['appeal_status'] ?? 'Not Applicable' }}
                        </span>
                    </div>

                    <div style="margin-left: 20px; line-height: 1.21;">
                        (xii) If disposed of:
                    </div>

                    <div style="margin-left: 60px; line-height: 1.21;">
                        (a) Date(s) of disposal
                        <span class="input-field input-field-medium">
                            {{ $nomination->convicted_details['disposal_date'] ?? 'Not Applicable' }}
                        </span>
                    </div>

                    <div style="margin-left: 60px; line-height: 1.21;">
                        (b) Nature of order(s) passed
                        <span class="input-field input-field-medium">
                            {{ $nomination->convicted_details['order_nature'] ?? 'Not Applicable' }}
                        </span>
                    </div>
                @else
                    <div style="margin-top: 25px;">
                        If the answer is "Yes", the candidate shall furnish the following information:
                    </div>

                    @php
                        $na = 'Not Applicable';
                    @endphp

                    <div style="margin-left: 20px; line-height: 1.21;">
                        (i) Case / First information report No./Nos.
                        <span class="input-field input-field-large">{{ $na }}</span>
                    </div>

                    <div style="margin-left: 20px; line-height: 1.21;">
                        (ii) Police station(s)
                        <span class="input-field" style="width: 139px;">{{ $na }}</span>
                        District(s)
                        <span class="input-field" style="width: 139px;">{{ $na }}</span>
                        State(s)
                        <span class="input-field" style="width: 139px;">{{ $na }}</span>
                    </div>

                    <div style="margin-left: 20px; line-height: 1.21;">
                        (iii) Section(s) of the concerned Act(s) and brief description of the offence(s)
                        <span class="input-field input-field-large">{{ $na }}</span>
                    </div>

                    <div style="margin-left: 20px; line-height: 1.21;">
                        (iv) Date(s) of conviction(s)
                        <span class="input-field input-field-medium" style="width: 139px;">{{ $na }}</span>
                    </div>

                    <div style="margin-left: 20px; line-height: 1.21;">
                        (v) Court(s) which convicted the candidate
                        <span class="input-field input-field-medium" style="width: 331px;">{{ $na }}</span>
                    </div>

                    <div style="margin-left: 20px; line-height: 1.21;">
                        (vi) Punishment(s) imposed
                        <span class="input-field input-field-large">{{ $na }}</span>
                    </div>

                    <div style="margin-left: 20px; line-height: 1.21;">
                        (vii) Date(s) of release from prison
                        <span class="input-field input-field-medium">{{ $na }}</span>
                    </div>

                    <div style="margin-left: 20px; line-height: 1.21;">
                        (viii) Whether any appeal(s)/revision(s) filed
                        <span class="input-field input-field-medium">{{ $na }}</span>
                    </div>

                    <div style="margin-left: 20px; line-height: 1.21;">
                        (ix) Date and particulars of appeal(s)/revision(s)
                        <span class="input-field input-field-large">{{ $na }}</span>
                    </div>

                    <div style="margin-left: 20px; line-height: 1.21;">
                        (x) Name of the court(s) where appeal(s) filed
                        <span class="input-field input-field-medium">{{ $na }}</span>
                    </div>

                    <div style="margin-left: 20px; line-height: 1.21;">
                        (xi) Whether appeal(s) disposed of or pending
                        <span class="input-field input-field-medium">{{ $na }}</span>
                    </div>

                    <div style="margin-left: 20px; line-height: 1.21;">
                        (xii) If disposed of:
                    </div>

                    <div style="margin-left: 60px; line-height: 1.21;">
                        (a) Date(s) of disposal
                        <span class="input-field input-field-medium">{{ $na }}</span>
                    </div>

                    <div style="margin-left: 60px; line-height: 1.21;">
                        (b) Nature of order(s) passed
                        <span class="input-field input-field-medium">{{ $na }}</span>
                    </div>
                @endif

            </div>

            <!---keep togathor start-->
            <div class="keep-together">
                <div style="margin-top: 20px;">
                    <div>
                        (2) Whether the candidate is holding any office of profit under the Government of India or State Government?
                        <strong>{{ strtoupper($nomination->holding_office_of_profit ? 'YES' : 'NO' ) }}</strong>
                    </div>

                    <div style="margin-top: 10px;">
                        - If Yes, details of the office held
                        <span class="input-field input-field-large">
                            {{ $nomination->holding_office_of_profit ?? 'Not Applicable' }}
                        </span>
                    </div>
                </div>


                <div style="margin-top: 15px;">
                    <div>
                        (3) Whether the candidate has been declared insolvent by any Court?
                        <strong>{{ strtoupper($nomination->declared_insolvent ? 'YES' : 'NO' ) }}</strong>
                    </div>

                    <div style="margin-top: 10px;">
                        - If Yes, has he been discharged from insolvency
                        <span class="input-field input-field-medium">
                            {{ $nomination->declared_insolvent ?? 'Not Applicable' }}
                        </span>
                    </div>
                </div>

                <div style="margin-top: 15px;">
                    <div>
                        (4) Whether the candidate is under allegiance or adherence to any foreign country?
                        <strong>{{ strtoupper($nomination->allegiance_to_foreign_country ? 'YES' : 'NO' ) }}</strong>
                    </div>

                    <div style="margin-top: 10px;">
                        - If Yes, give details
                        <span class="input-field input-field-large">
                            {{ $nomination->allegiance_to_foreign_country ?? 'Not Applicable' }}
                        </span>
                    </div>
                </div>

                <div style="margin-top: 15px;">
                    <div>
                        (5) Whether the candidate has been disqualified under section 8A of the said Act by an order of the President?
                        <strong>{{ strtoupper($nomination->disqualified_by_president ? 'YES' : 'NO' ) }}</strong>
                    </div>

                    <div style="margin-top: 10px;">
                        - If Yes, the period for which disqualified
                        <span class="input-field input-field-medium">
                            {{ $nomination->disqualified_by_president ?? 'Not Applicable' }}
                        </span>
                    </div>
                </div>

                <div style="margin-top: 8px;">
                    <div style="line-height: 1.8;">
                        (6) Whether the candidate was dismissed for corruption or disloyalty while holding office under Government?
                        <strong>{{ strtoupper($nomination->dismissed_for_corruption ? 'YES' : 'NO' ) }}</strong>
                    </div>

                    <div style="margin-top: 5px;">
                        - If Yes, the date of such dismissal
                        <span class="input-field input-field-medium">
                            {{ $nomination->dismissed_for_corruption ?? 'Not Applicable' }}
                        </span>
                    </div>
                </div>

                <div style="margin-top: 8px;">
                    <div style="line-height: 1.8;">
                        (7) Whether the candidate has any subsisting contract(s) with the Government?
                        <strong>{{ strtoupper($nomination->subsisting_govt_contract ? 'YES' : 'NO' ) }}</strong>
                    </div>

                    <div style="line-height: 1.8;">
                        - If Yes, details
                        <span class="input-field input-field-large">
                            {{ $nomination->subsisting_govt_contract ?? 'Not Applicable' }}
                        </span>
                    </div>
                </div>

                <div style="margin-top: 8px;">
                    <div style="line-height: 1.8;">
                        (8) Whether the candidate is a managing agent / manager / secretary of any company or corporation?
                        <strong>{{ strtoupper($nomination->managing_agent_role ? 'YES' : 'NO' ) }}</strong>
                    </div>

                    <div style="line-height: 1.8;">
                        - If Yes, details thereof
                        <span class="input-field input-field-large">
                            {{ $nomination->managing_agent_role ?? 'Not Applicable' }}
                        </span>
                    </div>
                </div>


                <div style="margin-top: 8px;">
                    <div style="line-height: 1.8;">
                        (9) Whether the candidate has been disqualified by the Commission under section 10A?
                        <strong>{{ strtoupper($nomination->disqualified_by_commission ?? 'NO') }}</strong>
                    </div>

                    <div style="line-height: 1.8;">
                        - If Yes, the date of disqualification
                        <span class="input-field input-field-medium">
                            {{ $nomination->date_of_disqualification ?? 'Not Applicable' }}
                        </span>
                    </div>
                </div>

                <div style="display: flex; justify-content: space-between; margin-top: 30px;">
                    <div>
                        Place: <input type="text" class="input-field input-field-medium" readonly
                            style="background: none;" placeholder="">
                        <br>
                        Date: <input type="text" class="input-field input-field-medium" readonly
                            style="background: none;">
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
                    <div class="section-title" style="text-align: center; margin-bottom: 0;">Decision of Returning
                        Officer Accepting or Rejecting the Nomination Paper</div>
                    <div style="margin-top: 0px;">
                        I have examined this nomination paper in accordance with section 36 of the Representation of the
                        People Act, 1951 and decide as follows: —
                    </div>

                    <div style="margin-top: 8px;">
                        <input type="text" class="input-field input-field-medium" style="width: 100%;" readonly>
                        <input type="text" class="input-field input-field-medium" style="width: 100%;" readonly>
                        <input type="text" class="input-field input-field-medium" style="width: 100%;" readonly>
                    </div>

                    <div style="display: flex; justify-content: space-between; margin-top: 36px;">
                        <div>
                            Date: <input type="text" class="input-field input-field-medium" style="width: 110px;"
                                readonly>
                        </div>

                        <div>
                            Returning Officer
                        </div>
                    </div>
                </div>

                <div style="border-top:2px dotted #000; margin-top:20px; position: relative; text-align: center;">
                    <span
                        style="position: absolute; top:-18px; left:0; width: 89px; right:0; background: #fff; margin: auto;">(Perforation)</span>
                </div>

                <!-- PART VI -->
                <div class="section" style="margin-top: 20px;">
                    <div class="section-title" style="text-align: center; margin-bottom: 0;">PART VI</div>
                    <div class="section-title" style="text-align: center; margin-bottom: 0;">Receipt for Nomination
                        Paper and Notice of Scrutiny</div>
                    <div style="text-align: center;">(To be handed over to the person presenting the Nomination Paper)
                    </div>

                    <div style="margin-top: 10px;">
                        Serial No. of nomination paper <input type="text" class="input-field input-field-medium">
                    </div>

                    <div style="margin-top: 10px; text-align: justify;">
                        The nomination paper of <input type="text" class="input-field input-field-medium"
                            placeholder="MAMATA BANERJEE"> a candidate for election from the
                        <input type="text" class="input-field input-field-medium" placeholder="210 NANDIGRAM"> Assembly
                        constituency was delivered to me at my office at
                        <input type="text" class="input-field input-field-small" placeholder="">(hour) on
                        <input type="text" class="input-field input-field-medium" style="width: 136px;"> (date) by the
                        <span>candidate</span>/<span>proposer</span>. All nomination papers will be taken up for
                        scrutiny at
                        <input type="text" class="input-field input-field-small">(hour) on
                        <input type="text" class="input-field input-field-medium" style="width: 136px;">(date) at
                        <input type="text" class="input-field input-field-medium">(place).
                    </div>

                    <div style="display: flex; justify-content: space-between; margin-top: 40px;">
                        <div>
                            Date: <input type="text" class="input-field input-field-medium" style="width: 110px;"
                                readonly>
                        </div>

                        <div>
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

        </form>
    </div>
</body>
</html>
<div>
<style>

    * {
        font-family: 'Times New Roman', Times, serif;
        box-sizing: border-box;
        font-size: 14px;
        line-height: 2;
    }

    .form-container {
        width: calc(210mm - 26mm) !important;
        margin: 0 auto;
        background-color: white;
        /* margin-top: 140mm; */
    }


    .center {
        text-align: center;
    }

    .right {
        text-align: right;
    }

    .photo-box {
        width: 120px;
        height: 150px;
        border: 1px solid #000;
        float: right;
        text-align: center;
        font-size: 12px;
        padding: 5px;
        display: flex;
        align-items: center;
    }

    .input-line {
        border: none;
        /* border-bottom: 1px dotted #000; */
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100%25' height='2' viewBox='0 0 100 2'%3E%3Cline x1='0' y1='1' x2='100' y2='1' stroke='%23000' stroke-width='1' stroke-dasharray='2,2'/%3E%3C/svg%3E");
        background-repeat: repeat-x;
        background-position: bottom;
        width: 250px;
        outline: none;
        font-size: 16px;
        line-height: 1.21;
        color:#000;
    }

    .input-small {
        width: 120px;
    }

    .input-large {
        width: 400px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        border-collapse: collapse;
        /* table-layout: fixed; */
    }

    table, th, td {
        border: 1px solid #000;
    }

    th {
        font-weight: normal;
    }

    th, td {
        padding: 6px;
        vertical-align: top;
        /* word-wrap: break-word;
        overflow-wrap: break-word; */
        white-space: normal;
        line-height: 1.21;
    }

    .no-border, .no-border td {
        border: none;
    }

    /* .page-break {
        page-break-before: always;
    } */

    textarea {
        width: 100%;
        border: none;
        border-bottom: 1px dotted #000;
        resize: none;
        font-family: "Times New Roman", serif;
        font-size: 14px;
    }

    .checkbox {
        margin-right: 5px;
    }

    ::placeholder {
        font-weight: bold;
        font-size: 16px;
        line-height: 1.21;
        color:#000;
    }
    .flex-input {
        display: inline;
        min-width: 80px;
        max-width: 100%;
        white-space: normal;
        outline: none;
        padding: 0 4px;
        font-size: 16px;
        line-height: 1.21;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100%25' height='2' viewBox='0 0 100 2'%3E%3Cline x1='0' y1='1' x2='100' y2='1' stroke='%23000' stroke-width='1' stroke-dasharray='2,2'/%3E%3C/svg%3E");
        background-repeat: repeat-x;
        background-position: bottom;
        font-weight: bold;
        word-break: break-word;
        overflow-wrap: anywhere;
        /* box-decoration-break: clone;
        -webkit-box-decoration-break: clone; */
    }

    .strike-out{
        text-decoration: line-through;
        font-weight: normal;
    }

    .list-group {
        display: flex;
        align-items: center;
    }

    .list-group div:first-child {
        border-right: 1px solid #000;
    }

    .list-group div:last-child {
        border-bottom: 1px solid #000;
        flex:1;
    }

    .indent-para {
        display: flex;
    }
    .indent-para span {
        white-space: nowrap;
        margin-right: 6px;
    }

    .check {
        position: relative;
        font-weight: bold;
    }
    .check:before {
        content:"\2713";
    }
    /* .page-break {
    page-break-before: always;
} */

 @media print {

    @page {
        size: A4;
        margin: 8mm;
        margin-top: 20mm;

        @top-center {
            content: "[" counter(page) "]";
            font-size: 12pt;
            color: #000000;
            margin-top: 8mm;
        }
    }

    @page :first {
        @top-center {
            content: "";
        }
        margin-top: 20px;
    }


    .input-line {
        border: none;
        border-bottom: 1px dotted #000;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100%25' height='2' viewBox='0 0 100 2'%3E%3Cline x1='0' y1='1' x2='100' y2='1' stroke='%23000' stroke-width='1' stroke-dasharray='2,2'/%3E%3C/svg%3E");
        background-repeat: repeat-x;
        background-position: bottom;
    }
    .flex-input {
        /* border-bottom: 1px dotted #000; */
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
        white-space: normal;
        background-repeat: repeat-x;
        background-position: bottom;
        display: inline !important;
    }
    /* .keep-together {
        page-break-inside: avoid !important;
        break-inside: avoid !important;
        -webkit-column-break-inside: avoid !important;
        height: 300mm !important;
        overflow: hidden !important;
    } */
 }
</style>

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1 text-dark">
                Preview
            </h4>
        </div>
    </div>

    <div class="card shadow-sm border-0 p-3">
        <div id="printArea" class="form-container">
            <form>
                    <div class="keep-together">
                        <div class="pagenumber">
                            <div style="text-align: center; font-weight:bold;">Form 26</div>
                            <div class="center" style="font-weight:bold;">(See rule 4A)</div>

                            <div style="text-align: right; overflow: auto; margin-bottom: 1px;">
                                <div class="photo-box">
                                    Please affix your
                                    recent passport
                                    size photograph
                                    here
                                </div>
                            </div>
                            <div style="text-align: center; font-weight:bold; margin-top: 20px; text-decoration: underline;">AFFIDAVIT</div>
                            <div style="text-align: justify; font-weight: bold;">
                                AFFIDAVIT TO BE FILED BY THE CANDIDATE ALONGWITH NOMINATION PAPER BEFORE THE RETURNING OFFICER FOR ELECTION TO 
                                <span class="flex-input"  contenteditable="true" style="min-width:250px; text-transform: uppercase;">THE LEGISLATIVE ASSEMBLY</span>
                                (NAME OF THE HOUSE) FORM <span class="flex-input"  contenteditable="true" style="min-width:250px; text-transform: uppercase;">{{ optional($form->assembly)->assembly_number }} - {{ optional($form->assembly)->assembly_name_en }}</span>
                                CONSTITUENCY (NAME OF THE CONSTITUENCY)
                            </div>

                            <div style="text-align: center; font-weight:bold; margin-top: 20px; text-decoration: underline;">PART A</div>

                            <p>
                                I<span class="flex-input"  contenteditable="true" style="padding: 0 30px;">{{ucwords($form->candidate->name)}}</span> 
                                **<span>{{ucwords($form->relation_type)}}</span> of 
                                <span class="flex-input"  contenteditable="true" style="padding: 0 30px;">{{ucwords($form->relation_name)}}</span>,
                                Aged <span class="flex-input"  contenteditable="true" style="padding: 0 30px;">{{$form->age}}</span> years,
                                resident of <span class="flex-input"  contenteditable="true" style="padding: 0 30px;"> {{ucwords($form->postal_address)}}</span> 
                                (mention full postal address), a candidate at the above election, do hereby solemnly affirm and state on oath as under:-
                            </p>

                        </div>

                        <div style=" page-break-before: always;"></div>

                        <p>
                            <strong>(1)</strong> I am a candidate set up by 
                            <span class="flex-input"  contenteditable="true" style="padding: 0 30px;">{{$form->political_party_name}}</span> 
                        </p>
                        <p>
                            <span>(**name of the political party)</span> / <span class="strike-out">**am contesting as an Independent candidate.</span>
                        </p>
                        <p>
                            (**strike out whichever is Not Applicable)
                        </p>

                        <p>
                            <strong>(2)</strong> My name is enrolled in 
                            <span class="flex-input"  contenteditable="true" style="padding: 0 30px;"> {{$form->constituency_where_enrolled}} and State {{$form->state}}</span> 
                            (Name of the Constituency and the state) at Serial No <span class="flex-input"  contenteditable="true" style="padding: 0 30px;">{{$form->candidate_serial_no}}</span>
                            in Part No. <span class="flex-input"  contenteditable="true" style="padding: 0 30px;">{{$form->candidate_part_no}}</span>
                        </p>

                        <p>
                            <strong>(3)</strong> My contact telephone number(s) <span>is</span>/<span>are</span>
                            <span class="flex-input" contenteditable="true" style="padding: 0 30px;">
                                {{ $phones['primary'] ?? '' }}/{{ $phones['alternate'] ?? '' }}
                            </span>

                            and my e-mail id (if any) is <span class="flex-input"  contenteditable="true" style="padding: 0 30px;">{{ $form->email_id }}</span>
                            and my social media account(s) (if any) <span>is</span>/<span>are</span>
                        </p>
                        <p>(i)<span class="flex-input"  contenteditable="true" style="padding: 0 30px;">WhatsApp No:- {{ $social['whatsapp_no'] ?? '' }} </span></p>
                        <p>(ii)<span class="flex-input"  contenteditable="true" style="padding: 0 30px;">Facebook A/c - {{ $social['facebook_account'] ?? '' }}</span></p>
                        <p>(iii)<span class="flex-input"  contenteditable="true" style="padding: 0 30px;">Twitter A/c - {{ $social['twitter_account'] ?? '' }}</span></p>

                    </div>

                    <div style="page-break-before: always;"></div>

                    <div style="font-weight: bold;">(4) Details of Permanent Account Number (PAN) and status of filing of Income tax return:</div>
                    @php
                        // Define the order of persons
                        $persons = [
                            'self' => 'Self',
                            'spouse' => 'Spouse',
                            'huf' => 'HUF (If Candidate is Karta/Coparcener)',
                            'dependent_1' => 'Dependent 1',
                            'dependent_2' => 'Dependent 2',
                            'dependent_3' => 'Dependent 3',
                        ];

                        $roman = ['i','ii','iii','iv','v'];
                    @endphp

                    <table>
                        <tr>
                            <th style="width: 80px;">Sl. No.</th>
                            <th style="text-align: center;">Name</th>
                            <th style="text-align: center;">PAN</th>
                            <th style="text-align: justify; width:120px;">The financial year for which the last Incometax return has been filed</th>
                            <th style="text-align: justify; width: 250px;">Total income shown in Income Tax Return(in Rupees) <span style="color: #e31111;">for the last five Financial Years completed (as on 31st March)</span></th>
                        </tr>

                        @foreach($persons as $key => $label)
                            @php
                            $panIndex = collect($panDetails)->search(fn($p) => $p['type'] === $key);

                                $panData = $panIndex !== false ? $panDetails[$panIndex] : null;
                                $incomeData = $panIndex !== false ? ($incomes[$panIndex] ?? null) : null;

                                $yearlyIncome = $incomeData['income'] ?? [];
                            @endphp

                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td style="text-align: center;">
                                    {{ $label }} 
                                    @if($key === 'self' && isset($panData['name']))
                                        - <strong>{{ $panData['name'] }}</strong>
                                    @endif
                                </td>
                                <td style="text-align: center;">{{ $panData['pan'] ?? 'Not Applicable' }}</td>
                                <td style="text-align: center;">{{ $panData['last_filed_year'] ?? 'Not Applicable' }}</td>
                                <td style="padding:0;">
                                    <table style="border:none; margin:0;">
                                        @for($i=0; $i<5; $i++)
                                            @php
                                                $year = array_keys($yearlyIncome)[$i] ?? null;
                                                $amount = $yearlyIncome[$year] ?? null;
                                            @endphp
                                            <tr>
                                                <td style="width: 16px; border-top:0; border-left:0;">({{ $roman[$i] }})</td>
                                                <td style="border-top:0; border-left:0; border-right:0; padding:0;">
                                                    @if($year && $amount)
                                                        <table style="border:none; margin:0;">
                                                            <tr>
                                                                <td style="border:none; border-right:1px solid #000; width:90px; text-align:center;">({{ $year }})</td>
                                                                <td style="border:none;">
                                                                    Rs. {{ is_numeric(str_replace(',', '', $amount)) ? number_format((float) str_replace(',', '', $amount), 2) : 'Not Applicable' }}
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    @else
                                                        <span style="text-align:center; display:block;">Not Applicable</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endfor
                                    </table>
                                </td>
                            </tr>
                        @endforeach
                    </table>

                    <p style="color: #e31111;">
                        Note: It is mandatory for PAN holder to mention PAN and in case of no PAN, it should be clearly stated “No PAN allotted”. 
                    </p>

                    <h5 style="font-weight: bold;">(5) Pending Criminal Cases</h5>

                    <p style="font-weight: bold;">
                        (i) I declare that there is no pending criminal case against me. (Tick this alternative if
                        there is no criminal case pending against the Candidate and write Not Applicable
                        against alternative (ii) below)
                    </p>

                    <p style="text-align: center; font-weight: bold;">OR</p>

                    <p style="font-weight: bold;">
                    (ii) The following criminal cases are pending against me: <span class="flex-input" contenteditable="true" style="padding: 0 30px;">Not Applicable</span>
                    </p>

                    <p style="font-weight: bold;">
                        (If there are pending criminal cases against the candidate, then tick this alternative and
                        score off alternative (i) above, and give details of all pending cases in the Table below)
                    </p>

                    <p style="font-weight: bold; text-align: center;">
                        Table
                    </p>

                    <table style="table-layout: fixed;">
                        <tr>
                            <td style="width: 60px; font-weight: bold;">(a)</td>
                            <td style="text-align: justify; font-weight: bold;">
                                FIR No. with name
                                and address of
                                Police Station
                                concerned
                            </td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                        </tr>
                        <tr class="page-break">
                            <td style="width: 60px; font-weight: bold;">(b)</td>
                            <td style="text-align: justify; font-weight: bold;">
                                Case No. with Name
                                of the Court
                            </td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                        </tr>
                        <tr>
                            <td style="width: 60px; font-weight: bold;">(c)</td>
                            <td style="text-align: justify; font-weight: bold;">
                                Section(s) of
                                concerned
                                Acts/Codes involved
                                (give no. of the
                                Section, e.g.
                                Section…….of IPC,
                                etc.).
                            </td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                        </tr>
                        <tr>
                            <td style="width: 60px; font-weight: bold;">(d)</td>
                            <td style="text-align: justify; font-weight: bold;">
                                Brief description of
                                offence
                            </td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                        </tr>
                        <tr>
                            <td style="width: 60px; font-weight: bold;">(e)</td>
                            <td style="text-align: justify; font-weight: bold;">
                                Whether charges
                                have been framed
                                (mention YES or
                                NO)
                            </td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                        </tr>
                        <tr>
                            <td style="width: 60px; font-weight: bold;">(f)</td>
                            <td style="text-align: justify; font-weight: bold;">
                                If answer against (e)
                                above is YES, then
                                give the date on
                                which charges were
                                framed
                            </td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                        </tr>
                        <tr>
                            <td style="width: 60px; font-weight: bold;">(g)</td>
                            <td style="text-align: justify; font-weight: bold;">
                                Whether any
                                Appeal/Application
                                for revision has been
                                filed against the
                                proceedings
                                (Mention YES or
                                NO)
                            </td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                        </tr>
                    </table>

                    <div class="page-break"></div>

                    <p style="font-weight: bold;">(6) Cases of conviction</p>
                    <p style="font-weight: bold;">
                        (i) I declare that I have not been convicted for any criminal offence. (Tick this
                        alternative, if the candidate has not been convicted and write Not Applicable
                        against alternative (ii) below)
                    </p>

                    <p style="text-align: center; font-weight: bold;">OR</p>

                    <p style="font-weight: bold;">
                        (ii) I have been convicted for the offences mentioned below:<span class="flex-input" contenteditable="true" style="padding: 0 30px;">Not Applicable</span>
                    </p>

                    <p style="font-weight: bold;">
                        (If the candidate has been convicted, then tick this alternative and score off alternative
                        (i) above, and give details in the Table below)
                    </p>


                    <p style="font-weight: bold; text-align: center;">
                        Table
                    </p>

                    <table style="table-layout: fixed;">
                        <tr>
                            <td style="width: 60px; font-weight: bold;">(a)</td>
                            <td style="text-align: justify; font-weight: bold;">
                                Case No.
                            </td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                        </tr>
                        <tr>
                            <td style="width: 60px; font-weight: bold;">(b)</td>
                            <td style="text-align: justify; font-weight: bold;">
                                Name of the Court
                            </td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                        </tr>
                        <tr>
                            <td style="width: 60px; font-weight: bold;">(c)</td>
                            <td style="text-align: justify; font-weight: bold;">
                                Sections of
                                Acts/Codes involved
                                (give no. of the
                                Section, e.g.
                                Section……. of IPC,
                                etc.).
                            </td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                        </tr>
                        <tr>
                            <td style="width: 60px; font-weight: bold;">(d)</td>
                            <td style="text-align: justify; font-weight: bold;">
                                Brief description of
                                offence for which
                                convicted
                            </td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                        </tr>
                        <tr>
                            <td style="width: 60px; font-weight: bold;">(e)</td>
                            <td style="text-align: justify; font-weight: bold;">
                                Dates of orders of
                                conviction
                            </td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                        </tr>
                        <tr>
                            <td style="width: 60px; font-weight: bold;">(f)</td>
                            <td style="text-align: justify; font-weight: bold;">
                                Punishment imposed
                            </td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                        </tr>
                        <tr>
                            <td style="width: 60px; font-weight: bold;">(g)</td>
                            <td style="text-align: justify; font-weight: bold;">
                                Whether any Appeal
                                has been filed
                                against conviction
                                order (Mention YES
                                6
                                or No)
                            </td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                        </tr>
                        <tr >
                            <td style="width: 60px; font-weight: bold;">(h)</td>
                            <td style="text-align: justify; font-weight: bold;">
                                If answer to (g)
                                above is YES, give
                                details and present
                                status of appeal
                            </td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                        </tr>
                    </table>
                    <div class="page-break" style="page-break-before: always;"></div>
                        <p>
                            <strong>(6A)</strong> I have given full and up-to-date information to my political party about all pending
                            criminal cases against me and about all cases of conviction as given in paragraphs (5) and
                            (6).
                        </p>

                        <p style="font-weight: bold;">
                            [candidates to whom this Item is Not Applicable should clearly write NOT
                            APPLICABLE IN VIEW OF ENTRIES IN 5(i) and 6(i), above]
                        </p>
                        <p style="font-weight: bold;">
                            Note:<br>
                            1. Details should be entered clearly and legibly in BOLD letters.<br>
                            2. Details to be given separately for each case under different columns against each
                            item. <br>
                            3. Details should be given in reverse chronological order, i.e., the latest case to be
                            mentioned first and backwards in the order of dates for the other cases.<br>
                            4. Additional sheet may be added if required.<br>
                            5. Candidate is responsible for supplying all information in compliance of Hon’ble
                            Supreme Court’s judgment in W. P (C) No. 536 of 2011.
                        </p>

                        <p>
                            <strong>(7)</strong> That I give herein below the details of the assets (movable and immovable etc.) of myself,
                            my spouse and all dependents:
                        </p>

                        <p style="font-weight: bold; text-decoration: underline;">
                            A. Details of movable assets :
                        </p>
                        <p class="indent-para">
                            <span>Note: 1.</span> Assets in joint name indicating the extent of joint ownership will also have to be
                                given.
                        </p>
                        <p class="indent-para">
                        <span> Note: 2.</span> In case of deposit/Investment, the details including Serial Number, Amount, date of
                            deposit, the scheme, Name of Bank/Institution and Branch are to be given.
                        </p>
                        <p class="indent-para">
                            <span>Note: 3.</span> of Bonds/Share Debentures as per the current market value in Stock Exchange
                            in respect of listed companies and as per books in case of non-listed companies
                            should be given.
                        </p>
                        <p class="indent-para">
                            <span>Note: 4.</span> ‘Dependent’ means parents, son(s), daughter(s) of the candidate or spouse and any
                            other person related to the candidate whether by blood or marriage, who have no
                            separate means of income and who are dependent on the candidate for their
                            livelihood.
                        </p>

                        <div class="page-break"></div>

                        <p class="indent-para">
                            <span>Note: 5.</span> Details including amount is to be given separately in respect of each investment
                        </p>

                        <p class="indent-para" style="color: #e31111;">
                        <span>Note: 6.</span> Details should include the interest in or ownership of offshore assets.
                        </p>

                        <p class="indent-para" style="font-weight: bold;">
                            <span>Explanation,-</span> For the purpose of this Form, the expression “offshore assets” includes,
                            details of all deposits or investments in Foreign banks and any other body or
                            institution abroad, and details of all assets and liabilities in foreign
                            countries’;
                        </p>


                        @php
                            $holders = [
                                'self' => 'Self',
                                'spouse' => 'Spouse',
                                'huf' => 'HUF',
                                'dependent_1' => 'Dependent-1',
                                'dependent_2' => 'Dependent-2',
                                'dependent_3' => 'Dependent-3',
                            ];

                            $assetRows = [
                                'cash' => 'Cash in hand (As on Date)',
                                'bank_deposit' => 'Details of deposit in Bank accounts (FDRs, Term Deposits and all other types of deposits including saving accounts), Deposits with Financial Institutions, Non-Banking Financial Companies and Cooperative societies and the amount in each such deposit',
                                'securities' => 'Details of investment in Bonds, Debentures /shares land units in companies /Mutual funds and others and the amount',
                                'postal_investment' => 'Details of investment in NSS, Postal Saving, Insurance policies and investment in any Financial instruments in Post office or Insurance Company and the amount',
                                'loan_given' => 'Personal loans/ advance given to any person or entity including firm, company, Trust etc., and other receivables from debtors and the amoun',
                                'vehicle' => 'Motor Vehicles/ Aircrafts/Yachts /Ships (Details of Make, registration number etc. year of purchase and amount)',
                                'jewellery' => 'Jewellery, bullion and valuable thing(s) (give Details of weight value)',
                                'other' => 'Any other assets such as value of claims/interest',
                            ];

                            $roman = ['i','ii','iii','iv','v','vi','vii','viii'];
                            $grossTotal = [];
                        @endphp

                        <table style="table-layout: fixed; margin-top: 25px;">
                            <tr>
                                <th style="width:50px;">S. No.</th>
                                <th style="width:100px;">Description</th>
                                @foreach($holders as $label)
                                    <th>{{ $label }}</th>
                                @endforeach
                            </tr>

                            @foreach($assetRows as $assetType => $label)
                            <tr>
                                <td>({{ $roman[$loop->index] }})</td>
                                <td>{{ $label }}</td>

                                @foreach($holders as $holderKey => $holderLabel)
                                    @php
                                        $assetRow = collect($movableAssets)
                                            ->firstWhere('type', $assetType);

                                        $holderEntry = $assetRow
                                            ? collect($assetRow['holders'] ?? [])
                                                ->firstWhere('holder', $holderKey)
                                            : null;

                                        $amount = $holderEntry['amount'] ?? null;

                                        if (is_numeric($amount)) {
                                            $grossTotal[$holderKey] =
                                                ($grossTotal[$holderKey] ?? 0) + (float) $amount;
                                        }

                                        if (is_numeric($amount)) {
                                            $grossTotal[$holderKey] =
                                                ($grossTotal[$holderKey] ?? 0) + (float)$amount;
                                        }
                                    @endphp

                                    <td>
                                        @if($amount !== null && $amount !== '')
                                            @php
                                                $description = $holderEntry['description'] ?? null;
                                            @endphp

                                            @if($description)
                                                <div>{{ $description }}</div>
                                            @endif

                                        @else
                                            Not Applicable
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                            @endforeach


                            {{-- Gross Total --}}
                            <tr>
                                <td style="font-weight:bold;">(ix)</td>
                                <td style="font-weight:bold;">Gross Total Value</td>

                                @foreach($holders as $holderKey => $label)
                                    <td style="font-weight:bold;">
                                        {{ isset($grossTotal[$holderKey])
                                            ? number_format($grossTotal[$holderKey], 2)
                                            : 'Not Applicable'
                                        }}
                                    </td>
                                @endforeach
                            </tr>
                        </table>

                        <p style="font-weight: bold; text-decoration: underline; margin-top: 35px;">
                        B. Details of Immovable assets:
                        </p>

                        <p class="indent-para">
                            <span>Note: 1.</span> Properties in joint ownership indicating the extent of joint ownership will also have
                                to be indicated
                        </p>
                        <p class="indent-para">
                        <span> Note: 2.</span> Each land or building or apartment should be mentioned separately in this format
                        </p>

                    <p class="indent-para" style="color: #e31111;">
                            <span> Note: 3.</span> Details should include the interest in or ownership of offshore assets.
                        </p>

                            @php

                            $holders = ['self','spouse','huf','dependent_1','dependent_2','dependent_3'];

                            $types = [
                                'agricultural' => [
                                    'label' => 'Agricultural Land',
                                    'rows' => [
                                        'location' => 'Location(s) Survey number(s)',
                                        'area' => 'Area (total measurement in acres)',
                                        'inherited' => 'Whether inherited property (Yes or No)',
                                        'purchase_date' => 'Date of purchase in case of self-acquired property',
                                        'cost' => 'Cost of Land (in case of purchase) at the time of purchase',
                                        'investment' => 'Any Investment on the land by way of development, construction etc.',
                                        'market_value' => 'Approximate Current market value'
                                    ]
                                ],

                                'non_agricultural' => [
                                    'label' => 'Non-Agricultural Land',
                                    'rows' => [
                                        'location' => 'Location(s) Survey number(s)',
                                        'area' => 'Area (total measurement in sq. ft.)',
                                        'inherited' => 'Whether inherited property (Yes or No)',
                                        'purchase_date' => 'Date of purchase in case of self-acquired property',
                                        'cost' => 'Cost of Land (in case of purchase) at the time of purchase',
                                        'investment' => 'Any Investment on the land by way of development, construction etc.',
                                        'market_value' => 'Approximate current market value'
                                    ]
                                ],

                                'commercial' => [
                                    'label' => 'Commercial Buildings (including apartments)',
                                    'rows' => [
                                        'location' => 'Location(s) Survey number(s)',
                                        'area' => 'Area (total measurement in sq. ft.)',
                                        'builtup' => 'Built-up Area (total measurement in sq.ft.)',
                                        'inherited' => 'Whether inherited property (Yes or No)',
                                        'purchase_date' => 'Date of purchase in case of self-acquired property',
                                        'cost' => 'Cost of property (in case of purchase)',
                                        'investment' => 'Any Investment on the property by way of development, construction etc.',
                                        'market_value' => 'Approximate current market value'
                                    ]
                                ],

                                'residential' => [
                                    'label' => 'Residential Buildings (including apartments)',
                                    'rows' => [
                                        'location' => 'Location(s) Survey number(s)',
                                        'area' => 'Area (Total measurement in sq. ft)',
                                        'builtup' => 'Built up Area (Total measurement in sq. ft.)',
                                        'inherited' => 'Whether inherited property (Yes or No)',
                                        'purchase_date' => 'Date of purchase in case of self–acquired property',
                                        'cost' => 'Cost of property (in case of purchase)',
                                        'investment' => 'Any Investment on the land by way of development, construction etc.',
                                        'market_value' => 'Approximate current market value'
                                    ]
                                ]
                            ];

                            $roman = ['i','ii','iii','iv'];
                            $grossTotal = [];

                            $descriptionMap = [
                                'location' => 'location_survey_number',
                                'area' => 'area_acres',
                                'inherited' => 'inherited',
                                'purchase_date' => 'purchase_date',
                                'cost' => 'purchase_cost',
                                'investment' => 'investment',
                                'market_value' => 'market_value',
                                'builtup' => 'builtup_area'
                            ];

                            @endphp


                            <table style="table-layout: fixed; margin-top: 35px;">
                            <tr>
                            <th style="width: 50px;">S. No.</th>
                            <th>Description</th>
                            <th>Self</th>
                            <th>Spouse</th>
                            <th>HUF</th>
                            <th>Dependent-1</th>
                            <th>Dependent-2</th>
                            <th>Dependent-3</th>
                            </tr>


                            @foreach($types as $typeKey => $type)

                            @php
                            $assetRow = collect($immovableAssets)->firstWhere('type',$typeKey);
                            @endphp

                            @foreach($type['rows'] as $field => $label)

                            <tr>

                            <td>
                            @if($loop->first)
                            ({{ $roman[$loop->parent->index] ?? '' }})
                            @endif
                            </td>

                            <td>

                            @if($loop->first)
                            <strong style="text-decoration: underline;">
                            {{ $type['label'] }}
                            </strong>
                            <br>
                            @endif

                            {{ $label }}

                            </td>


                        @foreach($holders as $holder)

                                @php
                                $holderRow = collect($immovableAssets)
                                    ->where('type',$typeKey)
                                    ->where('description', $descriptionMap[$field] ?? $field)
                                    ->first();

                                $details = null;
                                $amount = null;

                                if($holderRow){
                                    $holderData = collect($holderRow['holders'])
                                        ->where('holder',$holder)
                                        ->first();

                                    if($holderData){
                                        $details = $holderData['details'] ?? null;
                                        $amount = $holderData['amount'] ?? null;
                                    }
                                }

                                if(is_numeric($amount)){
                                    $grossTotal[$holder] = ($grossTotal[$holder] ?? 0) + (float)$amount;
                                }
                                @endphp

                                <td>

                                @if($details)
                                {{ $details }}
                                @endif

                                @if(!$details && !$amount)
                                Not Applicable
                                @endif

                                </td>

                                @endforeach

                            </tr>

                            @endforeach

                            @endforeach

                            <tr>
                            <td>(vi)</td>
                            <td>Total of current market value of (i) to (v) above</td>

                            @foreach($holders as $holder)

                            <td>
                            {{ isset($grossTotal[$holder]) 
                                ? 'Rs. '.number_format($grossTotal[$holder],2) 
                                : 'Not Applicable' }}
                            </td>

                            @endforeach

                            </tr>
                            </table>
                        <div style="page-break-before: always;"></div>
                        <p>
                            <strong>(8)</strong> I give herein below the details of liabilities/dues to public financial institutions and government:-
                        </p>

                        <p>
                            (Note: Please give separate details of name of bank, institution, entity or individual and amount before each item)
                        </p>


                        <table style="table-layout: fixed; margin-top: 25px;">
                            <tr>
                                <th style="width: 50px; font-weight: bold;">S. No.</th>
                                <th style="font-weight: bold; width: 150px;">Description</th>
                                <th style="font-weight: bold;">Self</th>
                                <th style="font-weight: bold;">Spouse</th>
                                <th style="font-weight: bold;">HUF</th>
                                <th style="font-weight: bold;">Dependent-1</th>
                                <th style="font-weight: bold;">Dependent-2</th>
                                <th style="font-weight: bold;">Dependent-3</th>
                            </tr>
                        @php
                                $holders = ['self','spouse','huf','dependent_1','dependent_2','dependent_3'];
                                $loanTotals = [];

                                function getHolderLoans($loans,$holder,$type){

                                    return collect($loans)
                                        ->where('type',$type)
                                        ->flatMap(function($loan) use ($holder){

                                            return collect($loan['holders'] ?? [])
                                                ->where('holder',$holder)
                                                ->map(function($h){

                                                    return [
                                                        'description' => $h['description'] ?? '',
                                                        'amount' => $h['amount'] ?? 0
                                                    ];

                                                });

                                        });
                                }

                                function getGovDue($dues,$holder,$type){

                                    return collect($dues)
                                        ->where('type',$type)
                                        ->flatMap(function($item) use ($holder){

                                            return collect($item['holders'] ?? [])
                                                ->where('holder',$holder)
                                                ->map(function($h){

                                                    return [
                                                        'description' => $h['description'] ?? '',
                                                        'amount' => $h['amount'] ?? 0
                                                    ];

                                                });

                                        });
                                }

                            @endphp

                        <tr>

                                <td>(i)</td>

                                <td>
                                <strong>Loan or dues to Bank/Financial Institution(s)</strong><br>
                                Name of Bank / Financial Institution,<br>
                                Amount outstanding, Nature of loan
                                </td>

                                @foreach($holders as $holder)

                                @php
                                $holderLoans = getHolderLoans($loans,$holder,'bank');

                                $total = 0;
                                @endphp

                                <td>

                                @if($holderLoans->count())

                                @foreach($holderLoans as $loan)

                                <div>
                                <strong>{{ $loan['description'] }}</strong><br>
                                <br>
                                {{-- Amount: Rs. {{ number_format($loan['amount'],2) }} --}}
                                </div>

                                @php
                                $total += (float)$loan['amount'];
                                @endphp

                                @endforeach

                                @php
                                $loanTotals[$holder] = ($loanTotals[$holder] ?? 0) + $total;
                                @endphp

                                @else
                                Not Applicable
                                @endif

                                </td>

                                @endforeach

                                </tr>
                        <tr>

                                <td></td>

                                <td>
                                <strong>Loan or dues to any other individuals/entity</strong><br>
                                Name(s), Amount outstanding, nature of loan
                                </td>

                                @foreach($holders as $holder)

                                @php
                                $holderLoans = getHolderLoans($loans,$holder,'individual');

                                $total = 0;
                                @endphp

                                <td>

                                @if($holderLoans->count())

                                @foreach($holderLoans as $loan)

                                <div>
                                <strong>{{ $loan['description'] }}</strong><br>
                                <br>
                                {{-- Amount: Rs. {{ number_format($loan['amount'],2) }} --}}
                                </div>

                                @php
                                $total += (float)$loan['amount'];
                                @endphp

                                @endforeach

                                @php
                                $loanTotals[$holder] = ($loanTotals[$holder] ?? 0) + $total;
                                @endphp

                                @else
                                Not Applicable
                                @endif

                                </td>

                                @endforeach

                                </tr>
                            <tr>
                                <td style="border-bottom: 1px solid #fff;"></td>
                                <td>
                                    <strong>Any other liability</strong>
                                </td>
                                <td>Not Applicable</td>
                                <td>Not Applicable</td>
                                <td>Not Applicable</td>
                                <td>Not Applicable</td>
                                <td>Not Applicable</td>
                                <td>Not Applicable</td>
                            </tr>
                        <tr>
                            <td></td>

                            <td><strong>Grand total of liabilities</strong></td>

                            @foreach($holders as $holder)

                            <td>

                            @if(isset($loanTotals[$holder]))
                            Rs. {{ number_format($loanTotals[$holder],2) }}
                            @else
                            Not Applicable
                            @endif

                            </td>

                            @endforeach

                            </tr>

                            <tr class="page-break" >
                                <td style="border-bottom: 1px solid #fff;">(ii)</td>
                                <td>
                                    <strong style="text-decoration: underline;">Government Dues:-</strong>
                                    Dues to departments dealing with
                                    Government accommodation
                                </td>
                                <td colspan="5">
                                    <p class="indent-para">
                                        <span>(A)</span>Has the Deponent been in occupation of
                                        accommodation provided by the Government at
                                        any time during the last ten years before the
                                        date of notification of the current election ?
                                    </p>

                                    <p class="indent-para">
                                        <span>(B)</span>If answer to (A) above is YES, the following
                                        declaration may be furnished namely:-
                                    </p>
                                    <div style="padding: 0 20px;" >
                                        <p class="indent-para">
                                            <span>(i)</span>The address of the Government accommodation:
                                        </p>
                                        <span class="flex-input" contenteditable="true" style="min-width:100%; text-align: center;">Not Applicable</span>
                                        <span class="flex-input" contenteditable="true" style="min-width:100%; text-align: center;"></span>
                                        <span class="flex-input" contenteditable="true" style="min-width:100%; text-align: center;"></span>
                                        <p class="indent-para">
                                            <span>(ii)</span> There is no dues payable in respect of
                                            above Government accommodation, towards-

                                            <p style="padding:0 23px;">(a) rent;</p>
                                            <p style="padding:0 23px;">(b) electricity charges;</p>
                                            <p style="padding:0 23px;">(c) water charges; and</p>
                                            <p style="padding:0 23px;">(d) telephone charges as on<span class="flex-input" contenteditable="true" style="min-width:40px; text-align: center;"></span>(date)</p>
                                            <p style="padding:0 23px;">
                                                [the date should be the last date of the
                                                third month prior to the month in which
                                                the election is notified or any date
                                                thereafter].
                                            </p>
                                            <p style="padding:0 23px;">
                                                Note- ‘No Dues Certificate’ from the
                                                agencies concerned in respect of rent,
                                                electricity charges, water charges and
                                                telephone charges for the above
                                                Government accommodation should be
                                                submitted
                                            </p>
                                        </p>
                                    </div>
                                </td>
                                <td>
                                    <span>YES</span>/<span class="check">NO</span>
                                    (Pl. tick the
                                    appropriate
                                    alternative)
                                </td>
                            </tr>

                            <tr >
                                <td>(iii)</td>
                                <td>
                                    Dues to department dealing with Government transport
                                    (including aircrafts and helicopters)
                                </td>
                                <td colspan="5" style="text-align: center; vertical-align: middle;" >
                                    Not Applicable
                                </td>
                                <td style="text-align: center; vertical-align: middle;">
                                    Not Applicable
                                </td>
                            </tr>

                        <tr>

                            <td>(iv)</td>
                            <td>Income Tax dues</td>

                            @foreach($holders as $holder)

                            @php
                            $dues = getGovDue($governmentDues,$holder,'income_tax');
                            @endphp

                            <td style="text-align:center">

                            @if($dues->count())

                            @foreach($dues as $due)

                            <div>
                            <strong>{{ $due['description'] }}</strong><br>
                            Rs. {{ number_format($due['amount'],2) }}
                            </div>

                            @endforeach

                            @else
                            Not Applicable
                            @endif

                            </td>

                            @endforeach

                            </tr>

                        <tr>

                            <td>(v)</td>
                            <td>GST dues</td>

                            @foreach($holders as $holder)

                            @php
                            $dues = getGovDue($governmentDues,$holder,'gst');
                            @endphp

                            <td style="text-align:center">

                            @if($dues->count())

                            @foreach($dues as $due)

                            <div>
                            <strong>{{ $due['description'] }}</strong><br>
                            Rs. {{ number_format($due['amount'],2) }}
                            </div>

                            @endforeach

                            @else
                            Not Applicable
                            @endif

                            </td>

                            @endforeach

                        </tr>

                        <tr>
                            <td>(vi)</td>
                            <td>Municipal/Property tax dues</td>

                            @foreach($holders as $holder)

                            @php
                            $dues = getGovDue($governmentDues,$holder,'property_tax');
                            @endphp

                            <td style="text-align:center">

                            @if($dues->count())

                            @foreach($dues as $due)

                            <div>
                            <strong>{{ $due['description'] }}</strong><br>
                            Rs. {{ number_format($due['amount'],2) }}
                            </div>

                            @endforeach

                            @else
                            Not Applicable
                            @endif

                            </td>

                            @endforeach

                        </tr>

                        <tr>
                            <td>(vii)</td>
                            <td>Any other dues</td>

                            @foreach($holders as $holder)

                            @php
                            $dues = getGovDue($governmentDues,$holder,'other_dues');
                            @endphp

                            <td style="text-align:center">

                            @if($dues->count())

                            @foreach($dues as $due)

                            <div>
                            <strong>{{ $due['description'] }}</strong><br>
                            Rs. {{ number_format($due['amount'],2) }}
                            </div>

                            @endforeach

                            @else
                            Not Applicable
                            @endif

                            </td>

                            @endforeach

                        </tr>
                        <tr>
                                <td>(viii)</td>
                                <td>Grand total of all Government dues</td>

                                @foreach($holders as $holder)

                                @php

                                $total = 0;

                                $types = ['income_tax','gst','property_tax','other_dues'];

                                foreach($types as $type){

                                    $dues = getGovDue($governmentDues,$holder,$type);

                                    foreach($dues as $d){
                                        $total += (float)$d['amount'];
                                    }

                                }

                                @endphp

                                <td style="text-align:center">

                                @if($total)
                                Rs. {{ number_format($total,2) }}
                                @else
                                Not Applicable
                                @endif

                                </td>

                                @endforeach

                            </tr>

                        <td>(ix)</td>
                        <td>
                        Whether any other liabilities are in dispute,
                        if so, mention the amount involved and the
                        authority before which it is pending.
                        </td>

                        @foreach($holders as $holder)

                        <td style="text-align:center">

                        Not Applicable

                        </td>

                        @endforeach

                        </tr>
                        </table>

                        <p class="indent-para">
                            <span style="font-weight: bold;">(9)</span>
                            <strong> Details of profession or occupation:</strong>

                            <p style="padding: 0 23px;">
                                (a) Self
                                <span class="flex-input" contenteditable="true" style="min-width:200px; text-align:center;">
                                    {{ ucwords($form->candidate_occupation ?? 'Not Applicable') }}
                                </span>
                            </p>

                            <p style="padding: 0 23px;">
                                (b) Spouse
                                <span class="flex-input" contenteditable="true" style="min-width:200px; text-align:center;">
                                    {{ ucwords($form->spouse_occupation ?? 'Not Applicable') }}
                                </span>
                            </p>
                        </p>

                        <p class="indent-para">
                            <span>(9A)</span> Details of source(s) of income:

                            <p style="padding: 0 23px;">
                                (a) Self
                                <span class="flex-input" contenteditable="true" style="min-width:200px; text-align:center;">
                                    {{ $source_of_incomes['self'] ?? 'Not Applicable' }}
                                </span>
                            </p>

                            <p style="padding: 0 23px;">
                                (b) Spouse
                                <span class="flex-input" contenteditable="true" style="min-width:200px; text-align:center;">
                                    {{ $source_of_incomes['spouse'] ?? 'Not Applicable' }}
                                </span>
                            </p>

                            <p style="padding: 0 23px;">
                                (c) Source of income, if any, of dependents,
                                <span class="flex-input" contenteditable="true" style="min-width:200px; text-align:center;">
                                    {{ $source_of_incomes['dependents'] ?? 'Not Applicable' }}
                                </span>
                            </p>
                        </p>

                        <p class="indent-para">
                            <span>(9B)</span> Contracts with appropriate Government and any public company or companies

                            @php
                                $na = 'Not Applicable';
                            @endphp

                            <p style="padding: 0 23px;">(a) details of contracts entered by the candidate
                                <span class="flex-input" contenteditable="true" style="min-width:200px; text-align:center;">{{ $na }}</span>
                            </p>

                            <p style="padding: 0 23px;">(b) details of contracts entered into by spouse
                                <span class="flex-input" contenteditable="true" style="min-width:200px; text-align:center;">{{ $na }}</span>
                            </p>

                            <p style="padding: 0 23px;">(c) details of contracts entered into by dependents
                                <span class="flex-input" contenteditable="true" style="min-width:200px; text-align:center;">{{ $na }}</span>
                            </p>

                            <p style="padding: 0 23px;">(d) details of contracts entered into by HUF / trust
                                <span class="flex-input" contenteditable="true" style="min-width:200px; text-align:center;">{{ $na }}</span>
                            </p>

                            <div class="page-break"></div>

                            <p style="padding: 0 23px;">(e) details of contracts entered into by Partnership Firms
                                <span class="flex-input" contenteditable="true" style="min-width:200px; text-align:center;">{{ $na }}</span>
                            </p>

                            <p style="padding: 0 23px;">(f) details of contracts entered into by private companies
                                <span class="flex-input" contenteditable="true" style="min-width:200px; text-align:center;">{{ $na }}</span>
                            </p>
                        </p>

                        <p class="indent-para">
                            <span style="font-weight: bold;">(10)</span>
                            <strong> My educational qualification is as under:</strong>

                            @foreach($education as $index => $edu)
                                <p style="padding: 0 23px;">
                                    <span class="flex-input"
                                        contenteditable="true"
                                        style="min-width:400px; text-align:center;">
                                        ({{ chr(97 + $index) }})
                                        {{ strtoupper($edu['degree'] ?? '') }}
                                        from {{ $edu['university'] ?? '' }}
                                        in the year {{ $edu['year'] ?? '' }}
                                    </span>
                                </p>
                            @endforeach
                        </p>

                        <p>
                            (Give details of highest School / University education mentioning the full form of the
                            certificate/ diploma/ degree course, name of the School /College/ University and the year
                            in which the course was completed.)
                        </p>

                        <div class="page-break"></div>

                        <div style="text-align: center; font-weight:bold; margin-top: 15px; text-decoration: underline;">PART B</div>


                        <p class="indent-para">
                            <span style="font-weight: bold;">(11)</span><strong>ABSTRACT OF THE DETAILS GIVEN IN (1) TO (10) OF PART - A:</strong>
                        </p>

                        <table style="table-layout: fixed;">
                            <tr>
                                <td style="width: 60px;">1.</td>
                                <td style="text-align: justify; width:200px;">
                                    Name of the candidate
                                </td>
                                <td style="text-align: center; font-weight: bold; vertical-align: middle;">
                                    <span>Sh</span>/<span>Smt.</span>/<span>Kum</span>
                                    {{ strtoupper($candidate->name) }}
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 60px;">2.</td>
                                <td style="text-align: justify; width:200px;">
                                    Full postal address
                                </td>
                                <td style="text-align: center; font-weight: bold; vertical-align: middle;">
                                    {{ strtoupper($form->postal_address ?? 'Not Applicable') }}
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 60px;">3.</td>
                                <td style="text-align: justify; width:200px;">
                                    Number and name the constituency and State
                                    of
                                </td>
                                <td style="text-align: center; font-weight: bold; vertical-align: middle;">
                                    {{ strtoupper($form->assembly->assembly_number ?? '') }} -
                                    {{ strtoupper($form->assembly->assembly_name_en ?? '') }}
                                    ASSEMBLY CONSTITUENCY {{ strtoupper($form->state ?? '') }}
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 60px;">4.</td>
                                <td style="text-align: justify; width:200px;">
                                    Name of the political party which set up the candidate (otherwise write' Independent')
                                </td>
                                <td style="text-align: center; font-weight: bold; vertical-align: middle;">
                                    {{ strtoupper($form->political_party_name ?? 'Independent') }}
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 60px;">5.</td>
                                <td style="text-align: justify; width:200px;">
                                    Total Numbers of pending Criminal cases
                                </td>
                                <td style="text-align: center; font-weight: bold; vertical-align: middle;">
                                    Not Applicable
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 60px;">6.</td>
                                <td style="text-align: justify; width:200px;">
                                    Total Number of cases in which convicted
                                </td>
                                <td style="text-align: center; font-weight: bold; vertical-align: middle;">
                                    Not Applicable
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="padding: 0;">
                                    <table style="padding: 0; border: none; border:1px solid transparent; margin: 0; table-layout: fixed; width: auto;">
                                        <tr>
                                            <th style="width: 60px; text-align: left; border: none; border-right:1px solid #000;">7.</th>
                                            <th style="text-align: left; border: none; border-right:1px solid #000; font-weight: bold; width:130px;"></th>
                                            <th style="text-align: left; border: none; border-right:1px solid #000; width:130px; text-align: center;">
                                                PAN of
                                            </th>
                                            <th style="text-align: left; border: none; border-right:1px solid #000; width:200px;">
                                                Year for which last
                                                Income Tax Return filed
                                                
                                            </th>
                                            <th style="text-align: left; border: none; width:200px;">
                                                Total Income Shown
                                            </th>
                                        </tr>
                                    @php
                                            $persons = ['self','spouse','huf','dependent_1','dependent_2','dependent_3'];

                                            $getPan = function($type) use ($panDetails){
                                                return collect($panDetails)->firstWhere('type',$type) ?? [];
                                            };

                                            $getIncome = function($type) use ($incomes){
                                                return collect($incomes)->firstWhere('type',$type) ?? [];
                                            };
                                            @endphp

                                        @php
                                            $selfPan = $getPan('self');
                                            $selfIncome = $getIncome('self');
                                        @endphp

                                        <tr>
                                            <td style="border:1px solid #fff; width:60px; border-right-color: #000;"></td>
                                            <td>(a) Candidate</td>
                                            <td style="text-align: center; font-weight: bold; vertical-align: middle;">
                                            {{ $selfPan['pan'] ?? 'Not Applicable' }}
                                            </td>

                                            <td style="text-align: center; font-weight: bold; vertical-align: middle;">
                                            {{ $selfPan['last_filed_year'] ?? 'Not Applicable' }}
                                            </td>

                                            <td style="text-align: center; font-weight: bold; vertical-align: middle; border-right: 0;">
                                            {{ isset($selfIncome['income']) ? number_format(array_sum($selfIncome['income']),2) : 'Not Applicable' }}
                                            </td>
                                        </tr>
                                        @php
                                            $spousePan = $getPan('spouse');
                                            $spouseIncome = $getIncome('spouse');
                                        @endphp

                                        <tr>
                                            <td style="border:1px solid #fff; width:60px; border-right-color: #000;"></td>
                                            <td>(b) Spouse</td>

                                            <td style="text-align: center; font-weight: bold; vertical-align: middle;">
                                            {{ $spousePan['pan'] ?? 'Not Applicable' }}
                                            </td>

                                            <td style="text-align: center; font-weight: bold; vertical-align: middle;">
                                            {{ $spousePan['last_filed_year'] ?? 'Not Applicable' }}
                                            </td>

                                            <td style="text-align: center; font-weight: bold; vertical-align: middle; border-right: 0;">
                                            {{ isset($spouseIncome['income']) ? number_format(array_sum($spouseIncome['income']),2) : 'Not Applicable' }}
                                            </td>
                                        </tr>

                                        @php
                                            $hufPan = $getPan('huf');
                                            $hufIncome = $getIncome('huf');
                                        @endphp

                                        <tr>
                                            <td style="border:1px solid #fff; width:60px; border-right-color: #000;"></td>
                                            <td style="color: #e31111;">(c) HUF</td>

                                            <td style="text-align: center; font-weight: bold; vertical-align: middle;">
                                            {{ $hufPan['pan'] ?? 'Not Applicable' }}
                                            </td>

                                            <td style="text-align: center; font-weight: bold; vertical-align: middle;">
                                            {{ $hufPan['last_filed_year'] ?? 'Not Applicable' }}
                                            </td>

                                            <td style="text-align: center; font-weight: bold; vertical-align: middle; border-right: 0;">
                                            {{ isset($hufIncome['income']) ? number_format(array_sum($hufIncome['income']),2) : 'Not Applicable' }}
                                            </td>
                                        </tr>
                                        @php
                                            $depPan = $getPan('dependent_1');
                                            $depIncome = $getIncome('dependent_1');
                                        @endphp

                                        <tr>
                                            <td style="border:1px solid #fff; width:60px; border-right-color: #000; border-bottom-color: #000;"></td>
                                            <td>(d) Dependent</td>

                                            <td style="text-align: center; font-weight: bold; vertical-align: middle;">
                                            {{ $depPan['pan'] ?? 'Not Applicable' }}
                                            </td>

                                            <td style="text-align: center; font-weight: bold; vertical-align: middle;">
                                            {{ $depPan['last_filed_year'] ?? 'Not Applicable' }}
                                            </td>

                                            <td style="text-align: center; font-weight: bold; vertical-align: middle; border-right: 0;">
                                            {{ isset($depIncome['income']) ? number_format(array_sum($depIncome['income']),2) : 'Not Applicable' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="border:1px solid #fff; width:60px; border-right-color: #000; border-bottom-color: #000;">8</td>
                                            <td colspan="4" style="font-weight: bold; border-right: 0;">Details of Assets and Liabilities (including offshore assets) in rupees</td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" style="border-color: transparent; padding:0; border-width: 0;">
                                                <table style="padding: 0; border: none; border:1px solid transparent; margin: 0; table-layout: fixed; border-width: 0;">
                                                    <tr>
                                                        <th style="width: 55px; text-align: left; border: none; border-right:1px solid #000;"></th>
                                                        <th style=" text-align: left; border: none; border-right:1px solid #000; width: 200px; font-weight: bold;">Description</th>
                                                        <th style=" text-align: left; border: none; border-right:1px solid #000; font-weight: bold;">Self</th>
                                                        <th style=" text-align: left; border: none; border-right:1px solid #000; font-weight: bold;">Spouse</th>
                                                        <th style=" text-align: left; border: none; border-right:1px solid #000; font-weight: bold;">Dependent-1</th>
                                                        <th style=" text-align: left; border: none; border-right:1px solid #000; font-weight: bold;">Dependent-2</th>
                                                        <th style=" text-align: left; border: none; font-weight: bold;">Dependent-3</th>
                                                    </tr>

                                                    @php

                                                    function movableTotal($assets, $holder){
                                                            $total = collect($assets)->sum(function($asset) use ($holder){
                                                                return collect($asset['holders'] ?? [])
                                                                    ->where('holder', $holder)
                                                                    ->sum(function($h){
                                                                        return is_numeric($h['amount'] ?? null) ? $h['amount'] : 0;
                                                                    });
                                                            });

                                                            return $total > 0 ? number_format($total,2) : 'Not Applicable';
                                                        }

                                                    @endphp

                                                <tr>
                                                        <td style="vertical-align: middle; border-left: 0;">A</td>
                                                        <td style="vertical-align: middle;"><strong>Moveable Assets(Total value)</strong></td>
                                                        <td>{{ movableTotal($movableAssets,'self') }}</td>
                                                        <td>{{ movableTotal($movableAssets,'spouse') }}</td>
                                                        <td>{{ movableTotal($movableAssets,'dependent_1') }}</td>
                                                        <td>{{ movableTotal($movableAssets,'dependent_2') }}</td>
                                                        <td style="border-right:0;">{{ movableTotal($movableAssets,'dependent_3') }}</td>
                                                    </tr>

                                                    @php

                                                        function immovableTotal($assets,$holder){
                                                            $total = collect($assets)->sum(function($asset) use ($holder){
                                                                return collect($asset['holders'] ?? [])
                                                                    ->where('holder',$holder)
                                                                    ->sum(function($h){
                                                                        return is_numeric($h['amount'] ?? null) ? $h['amount'] : 0;
                                                                    });
                                                            });

                                                            return $total > 0 ? $total : null;
                                                        }

                                                    @endphp

                                                    <tr>
                                                        <td style="text-align: center; font-weight: bold; padding: 0; border-left: 0; position: relative;">
                                                            <!-- <table style="padding: 0; border: none; border:1px solid transparent; margin: 0; table-layout: fixed; border-width: 0;">
                                                                <tr>
                                                                    <td style="text-align: center; border-top: 0; border-left:0; border-bottom: 0;">B</td>
                                                                    <td style="text-align: center; font-weight: bold; border-top: 0; border-right:0; border-bottom: 0"></td>
                                                                </tr>
                                                            </table> -->
                                                            <div style="display: flex; justify-content: center; align-items: center; height: 100%; position: absolute; left:0; top:0; width:100%;">
                                                                <div style="border-right:1px solid #000; flex:1 0 0; font-weight: bold; height:100%;">B</div>
                                                                <div style="flex:1 0 0; height: 100%;"></div>
                                                            </div>
                                                        </td>
                                                        <td> <strong>Immovable Assets</strong></td>
                                                        <td>{{ immovableTotal($immovableAssets,'self') ? number_format(immovableTotal($immovableAssets,'self'),2) : 'Not Applicable' }}</td>
                                                        <td>{{ immovableTotal($immovableAssets,'spouse') ? number_format(immovableTotal($immovableAssets,'spouse'),2) : 'Not Applicable' }}</td>
                                                        <td>{{ immovableTotal($immovableAssets,'dependent_1') ? number_format(immovableTotal($immovableAssets,'dependent_1'),2) : 'Not Applicable' }}</td>
                                                        <td>{{ immovableTotal($immovableAssets,'dependent_2') ? number_format(immovableTotal($immovableAssets,'dependent_2'),2) : 'Not Applicable' }}</td>
                                                        <td style="border-right:0;">{{ immovableTotal($immovableAssets,'dependent_3') ? number_format(immovableTotal($immovableAssets,'dependent_3'),2) : 'Not Applicable' }}</td>
                                                    </tr>

                                                    <tr>
                                                        <td style="text-align: center; font-weight: bold; padding: 0; border-left: 0; position: relative;">
                                                            <!-- <table style="padding: 0; border: none; border:1px solid transparent; margin: 0; table-layout: fixed; border-width: 0;">
                                                                <tr>
                                                                    <td style="text-align: center; font-weight: bold; border-top: 0; border-left:0; border-bottom: 0;"></td>
                                                                    <td style="text-align: center; border-top: 0; border-right:0; border-bottom: 0;">i</td>
                                                                </tr>
                                                            </table> -->
                                                            <div style="display: flex; justify-content: center; align-items: center; height: 100%; position: absolute; left:0; top:0; width:100%;">
                                                                <div style="border-right:1px solid #000; flex:1 0 0; font-weight: bold; height:100%;"></div>
                                                                <div style="flex:1 0 0; height: 100%;">i</div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            Purchase Price of
                                                            self-acquired
                                                            immovable
                                                            property

                                                        </td>
                                                        <td>Not Applicable</td>
                                                        <td>Not Applicable</td>
                                                        <td>Not Applicable</td>
                                                        <td>Not Applicable</td>
                                                        <td style="border-right: 0;">Not Applicable</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: center; font-weight: bold; padding: 0; border-left: 0; position: relative;">
                                                            <!-- <table style="padding: 0; border: none; border:1px solid transparent; margin: 0; table-layout: fixed; border-width: 0;">
                                                                <tr>
                                                                    <td style="text-align: center; font-weight: bold; border-top: 0; border-left:0; border-bottom: 0;"></td>
                                                                    <td style="text-align: center; font-weight: bold; border-top: 0; border-right:0; border-bottom: 0;">ii</td>
                                                                </tr>
                                                            </table> -->
                                                            <div style="display: flex; justify-content: center; align-items: center; height: 100%; position: absolute; left:0; top:0; width:100%;">
                                                                <div style="border-right:1px solid #000; flex:1 0 0; font-weight: bold; height:100%;"></div>
                                                                <div style="flex:1 0 0; height: 100%;">ii</div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            Development/const
                                                            ruction cost of
                                                            immovable
                                                            property after
                                                            purchase (if
                                                            applicable)
                                                        </td>
                                                        <td>Not Applicable</td>
                                                        <td>Not Applicable</td>
                                                        <td>Not Applicable</td>
                                                        <td>Not Applicable</td>
                                                        <td style=" border-right: 0;">Not Applicable</td>
                                                    </tr>

                                                    <tr >
                                                        <td style="text-align: center; font-weight: bold; padding: 0; border-left: 0; position: relative;">
                                                            <!-- <table style="padding: 0; border: none; border:1px solid transparent; margin: 0; table-layout: fixed; border-width: 0; ">
                                                                <tr>
                                                                    <td style="text-align: center; font-weight: bold; border-top: 0; border-left:0; border-bottom: 0;"></td>
                                                                    <td style="text-align: center; font-weight: bold; border-top: 0; border-right:0; border-bottom: 0;">iii</td>
                                                                </tr>
                                                            </table> -->
                                                            <div style="display: flex; justify-content: center; align-items: center; height: 100%; position: absolute; left:0; top:0; width:100%;">
                                                                <div style="border-right:1px solid #000; flex:1 0 0; font-weight: bold; height:100%;"></div>
                                                                <div style="flex:1 0 0; height: 100%;">iii</div>
                                                            </div>
                                                        </td>
                                                        <td style="padding:0;">
                                                            <table style="padding: 0; margin-top: 0; table-layout: fixed; border-top: 0; border-left:0; border-bottom: 0; border-right: 0;">
                                                                <tr>
                                                                    <td style="border-top: 0; border-left: 0; border-right:0;">Approximate Current Market Price -</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="border-top: 0; border-left: 0; border-right:0;">(a) Self-acquired assets (Total Value)</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="border-top: 0; border-left: 0; border-right:0; border-bottom: 0;">(b) Inherited assets (Total Value) </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td style="padding:0;">
                                                            <table style="padding: 0; margin-top: 0; table-layout: fixed; border-top: 0; border-left:0; border-bottom: 0; border-right: 0;">
                                                                <tr>
                                                                    <td style="border-top: 0; border-left: 0; border-right:0;">Not Applicable</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="border-top: 0; border-left: 0; border-right:0;">Not Applicable</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="border-top: 0; border-left: 0; border-right:0; border-bottom: 0;">Not Applicable</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td style="padding:0;">
                                                            <table style="padding: 0; margin-top: 0; table-layout: fixed; border-top: 0; border-left:0; border-bottom: 0;     border-right: 0;">
                                                                <tr>
                                                                    <td style="border-top: 0; border-left: 0; border-right:0;">Not Applicable</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="border-top: 0; border-left: 0; border-right:0;">Not Applicable</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="border-top: 0; border-left: 0; border-right:0; border-bottom: 0;">Not Applicable</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td style="padding:0;">
                                                            <table style="padding: 0; margin-top: 0; table-layout: fixed; border-top: 0; border-left:0; border-bottom: 0;     border-right: 0;">
                                                                <tr>
                                                                    <td style="border-top: 0; border-left: 0; border-right:0;">Not Applicable</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="border-top: 0; border-left: 0; border-right:0;">Not Applicable</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="border-top: 0; border-left: 0; border-right:0; border-bottom: 0;">Not Applicable</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td style="padding:0;">
                                                            <table style="padding: 0; margin-top: 0; table-layout: fixed; border-top: 0; border-left:0; border-bottom: 0;     border-right: 0;">
                                                                <tr>
                                                                    <td style="border-top: 0; border-left: 0; border-right:0;">Not Applicable</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="border-top: 0; border-left: 0; border-right:0;">Not Applicable</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="border-top: 0; border-left: 0; border-right:0; border-bottom: 0;">Not Applicable</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td style="padding:0; border-right: 0;">
                                                            <table style="padding: 0; margin-top: 0; table-layout: fixed; border-top: 0; border-left:0; border-bottom: 0; border-right: 0;">
                                                                <tr>
                                                                    <td style="border-top: 0; border-left: 0; border-right:0;">Not Applicable</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="border-top: 0; border-left: 0; border-right:0;">Not Applicable</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="border-top: 0; border-left: 0; border-right:0; border-bottom: 0;">Not Applicable</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>

                                                </table>
                                            </td>
                                        </tr>
                                    
                                        <tr>
                                            <td style="border-right-color: #000; border-bottom-color: #000; border-bottom: 0; padding: 0; border-left:0; border-top:0; border-right: 0;" colspan="7">
                                                <table style="padding: 0; border: none; border:1px solid transparent; margin: 0; table-layout: fixed; border-width: 0;">
                                                    <tr>
                                                        <td style="border-right-color: #000; border-bottom-color: #000; border-bottom: 0; padding: 0; border-left:0; border-top:0; border-right: 0; width:55px; position: relative;">
                                                            <!-- <table style="padding: 0; border: none; margin: 0; table-layout: fixed; border-width: 0; border-top: 0; border-left: 0; border-right: 0; border-bottom: 0;">
                                                                <tr>
                                                                    <td style="text-align: center; font-weight: bold; border-top: 0; border-right:0; border-bottom: 0;  border-left: 0;">9</td>
                                                                    <td style="text-align: center; font-weight: bold; border-top: 0; border-right:0; border-bottom: 0"></td>
                                                                </tr>
                                                            </table> -->
                                                            <div style="display: flex; justify-content: center; align-items: center; height: 100%; position: absolute; left:0; top:0; width:100%;">
                                                                <div style="border-right:1px solid #000; flex:1 0 0; font-weight: bold; height:100%; text-align: center;">9</div>
                                                                <div style="flex:1 0 0; height: 100%;"></div>
                                                            </div>
                                                        </td>
                                                        <td style=" font-weight: bold; border-top: 0; border-right:0; border-bottom: 0; width:200px;">
                                                            Liabilities
                                                        </td>
                                                        <td style="text-align: center; font-weight: bold; border-top: 0; border-right:0; border-bottom: 0"></td>
                                                        <td style="text-align: center; font-weight: bold; border-top: 0; border-right:0; border-bottom: 0"></td>
                                                        <td style="text-align: center; font-weight: bold; border-top: 0; border-right:0; border-bottom: 0"></td>
                                                        <td style="text-align: center; font-weight: bold; border-top: 0; border-right:0; border-bottom: 0"></td>
                                                        <td style="text-align: center; font-weight: bold; border-top: 0; border-right:0; border-bottom: 0"></td>
                                                        <td style="text-align: center; font-weight: bold; border-top: 0; border-right:0; border-bottom: 0"></td>
                                                    </tr>
                                                    @php
                                                        function govtDueTotal($dues, $holder)
                                                        {
                                                            $total = collect($dues)
                                                                ->where('holder', $holder)
                                                                ->sum(function ($row) {
                                                        
                                                                    return
                                                                        (float) ($row['income_tax'] ?? 0) +
                                                                        (float) ($row['gst'] ?? 0) +
                                                                        (float) ($row['property_tax'] ?? 0) +
                                                                        (float) ($row['other_dues'] ?? 0);
                                                        
                                                                });
                                                        
                                                            // Return null if total is 0 so Blade shows 'Not Applicable'
                                                            return $total > 0 ? $total : null;
                                                        }
                                                        @endphp
                                                    
                                                    <tr>
                                                        <td style="text-align: center; font-weight: bold; padding: 0; border-left: 0; position: relative;">
                                                            <!-- <table style="padding: 0; border: none; border:1px solid transparent; margin: 0; table-layout: fixed; border-width: 0;">
                                                                <tr>
                                                                    <td style="text-align: center; font-weight: bold; border-top: 0; border-left:0; border-bottom: 0;"></td>
                                                                    <td style="text-align: center; border-top: 0; border-right:0; border-bottom: 0;">i</td>
                                                                </tr>
                                                            </table> -->
                                                            <div style="display: flex; justify-content: center; align-items: center; height: 100%; position: absolute; left:0; top:0; width:100%;">
                                                                <div style="border-right:1px solid #000; flex:1 0 0; font-weight: bold; height:100%;"></div>
                                                                <div style="flex:1 0 0; height: 100%;">(i)</div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            Government dues
                                                            (Total)
                                                        </td>
                                                            <td>{{ govtDueTotal($governmentDues,'self') ? number_format(govtDueTotal($governmentDues,'self'),2) : 'Not Applicable' }}</td>
                                                            <td>{{ govtDueTotal($governmentDues,'spouse') ? number_format(govtDueTotal($governmentDues,'spouse'),2) : 'Not Applicable' }}</td>
                                                            <td>{{ govtDueTotal($governmentDues,'huf') ? number_format(govtDueTotal($governmentDues,'huf'),2) : 'Not Applicable' }}</td>
                                                            <td>{{ govtDueTotal($governmentDues,'dependent_1') ? number_format(govtDueTotal($governmentDues,'dependent_1'),2) : 'Not Applicable' }}</td>
                                                            <td>{{ govtDueTotal($governmentDues,'dependent_2') ? number_format(govtDueTotal($governmentDues,'dependent_2'),2) : 'Not Applicable' }}</td>
                                                            <td style="border-right: 0;">{{ govtDueTotal($governmentDues,'dependent_3') ? number_format(govtDueTotal($governmentDues,'dependent_3'),2) : 'Not Applicable' }}</td>
                                                    </tr>
                                                    @php
                                                        function loanTotal($loans, $holder){
                                                            $total = collect($loans)
                                                                ->where('holder', $holder)
                                                                ->sum(function($loanHolder){
                                                                    return collect($loanHolder['loans'] ?? [])
                                                                        ->sum('amount');
                                                                });

                                                            // Return null if total is 0 so Blade can show 'Not Applicable'
                                                            return $total > 0 ? $total : null;
                                                        }
                                                        @endphp
                                                    <tr>
                                                        <td style="text-align: center; font-weight: bold; padding: 0; border-left: 0; position: relative;">
                                                            <!-- <table style="padding: 0; border: none; border:1px solid transparent; margin: 0; table-layout: fixed; border-width: 0;">
                                                                <tr>
                                                                    <td style="text-align: center; font-weight: bold; border-top: 0; border-left:0; border-bottom: 0;"></td>
                                                                    <td style="text-align: center; border-top: 0; border-right:0; border-bottom: 0;">ii</td>
                                                                </tr>
                                                            </table> -->
                                                            <div style="display: flex; justify-content: center; align-items: center; height: 100%; position: absolute; left:0; top:0; width:100%;">
                                                                <div style="border-right:1px solid #000; flex:1 0 0; font-weight: bold; height:100%;"></div>
                                                                <div style="flex:1 0 0; height: 100%;">(ii)</div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            Loans from Bank,
                                                            Financial Institutions
                                                            and others (Total)
                                                        </td>
                                                        <td>{{ loanTotal($loans,'self') ? number_format(loanTotal($loans,'self'),2) : 'Not Applicable' }}</td>
                                                        <td>{{ loanTotal($loans,'spouse') ? number_format(loanTotal($loans,'spouse'),2) : 'Not Applicable' }}</td>
                                                        <td>{{ loanTotal($loans,'huf') ? number_format(loanTotal($loans,'huf'),2) : 'Not Applicable' }}</td>
                                                        <td>{{ loanTotal($loans,'dependent_1') ? number_format(loanTotal($loans,'dependent_1'),2) : 'Not Applicable' }}</td>
                                                        <td>{{ loanTotal($loans,'dependent_2') ? number_format(loanTotal($loans,'dependent_2'),2) : 'Not Applicable' }}</td>
                                                        <td style="border-right: 0;">{{ loanTotal($loans,'dependent_3') ? number_format(loanTotal($loans,'dependent_3'),2) : 'Not Applicable' }}</td>
                                                    </tr>
                                                    
                                                </table>
                                            </td>
                                        </tr>

                                        <tr >
                                            <td style="border-right-color: #000; border-bottom-color: #000; border-bottom: 0; padding: 0; border-left:0; border-top:0; border-right: 0;" colspan="7">
                                                <table style="padding: 0; border: none; border:1px solid transparent; margin: 0; table-layout: fixed; border-width: 0;">
                                                    <tr>
                                                        <td style="border-right-color: #000; border-bottom-color: #000; border-bottom: 0; padding: 0; border-left:0; border-top:0; border-right: 0; width:55px; position: relative;">
                                                            <!-- <table style="padding: 0; border: none; margin: 0; table-layout: fixed; border-width: 0; border-top: 0; border-left: 0; border-right: 0; border-bottom: 0;">
                                                                <tr>
                                                                    <td style="text-align: center; font-weight: bold; border-top: 0; border-right:0; border-bottom: 0;  border-left: 0;">10</td>
                                                                    <td style="text-align: center; font-weight: bold; border-top: 0; border-right:0; border-bottom: 0"></td>
                                                                </tr>
                                                            </table> -->
                                                            <div style="display: flex; justify-content: center; align-items: center; height: 100%; position: absolute; left:0; top:0; width:100%;">
                                                                <div style="border-right:1px solid #000; flex:1 0 0; font-weight: bold; height:100%; text-align: center;">10</div>
                                                                <div style="flex:1 0 0; height: 100%;"></div>
                                                            </div>
                                                        </td>
                                                        <td colspan="6" style="font-weight: bold; border-top: 0; border-right:0; border-bottom: 0;">
                                                            Liabilities that are under dispute
                                                        </td>
                                                        
                                                    </tr>
                                                    

                                                    <tr>
                                                        <td style="text-align: center; font-weight: bold; padding: 0; border-left: 0; position: relative;">
                                                            <!-- <table style="padding: 0; border: none; border:1px solid transparent; margin: 0; table-layout: fixed; border-width: 0;">
                                                                <tr>
                                                                    <td style="text-align: center; font-weight: bold; border-top: 0; border-left:0; border-bottom: 0;"></td>
                                                                    <td style="text-align: center; border-top: 0; border-right:0;">i</td>
                                                                </tr>
                                                            </table> -->
                                                            <div style="display: flex; justify-content: center; align-items: center; height: 100%; position: absolute; left:0; top:0; width:100%;">
                                                                <div style="border-right:1px solid #000; flex:1 0 0; font-weight: bold; height:100%;"></div>
                                                                <div style="flex:1 0 0; height: 100%;">(i)</div>
                                                            </div>
                                                        </td>
                                                        <td style="width: 200px;">
                                                            Government dues
                                                            (Total)
                                                        </td>
                                                        <td>Not Applicable</td>
                                                        <td>Not Applicable</td>
                                                        <td>Not Applicable</td>
                                                        <td>Not Applicable</td>
                                                        <td>Not Applicable</td>
                                                        <td style="border-right: 0;">Not Applicable</td>
                                                    </tr>
                                                    <tr style="page-break-before: always;">
                                                        <td style="text-align: center; font-weight: bold; padding: 0; border-left: 0; position: relative;">
                                                            <!-- <table style="padding: 0; border: none; border:1px solid transparent; margin: 0; table-layout: fixed; border-width: 0;">
                                                                <tr>
                                                                    <td style="text-align: center; font-weight: bold; border-top: 0; border-left:0; border-bottom: 0;"></td>
                                                                    <td style="text-align: center; border-top: 0; border-right:0; border-bottom: 0;">ii</td>
                                                                </tr>
                                                            </table> -->
                                                            <div style="display: flex; justify-content: center; align-items: center; height: 100%; position: absolute; left:0; top:0; width:100%;">
                                                                <div style="border-right:1px solid #000; flex:1 0 0; font-weight: bold; height:100%;"></div>
                                                                <div style="flex:1 0 0; height: 100%;">(ii)</div>
                                                            </div>

                                                        </td>
                                                        <td style="width: 200px;">
                                                            Loans from Bank,
                                                            Financial Institutions
                                                            and others (Total)
                                                        </td>
                                                        <td>Not Applicable</td>
                                                        <td>Not Applicable</td>
                                                        <td>Not Applicable</td>
                                                        <td>Not Applicable</td>
                                                        <td>Not Applicable</td>
                                                        <td style="border-right: 0;">Not Applicable</td>
                                                    </tr>
                                                    
                                                </table>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td style="border-right-color: #000; border-bottom-color: #000; border-bottom: 0; padding: 0; border-left:0; border-top:0; border-right: 0;" colspan="7">
                                                <table style="padding: 0; border: none; border:1px solid transparent; margin: 0; table-layout: fixed; border-width: 0;">
                                                    <tr>
                                                        <td style="border-right-color: #000; border-bottom-color: #000; border-bottom: 0; padding: 0; border-left:0; border-top:0; border-right: 0; width:55px;">
                                                            <table style="padding: 0; border: none; margin: 0; table-layout: fixed; border-width: 0; border-top: 0; border-left: 0; border-right: 0; border-bottom: 0;">
                                                                <tr>
                                                                    <td style="text-align: center; font-weight: bold; border-top: 0; border-right:0; border-bottom: 0;  border-left: 0;">11</td>
                                                                    <td style="text-align: center; font-weight: bold; border-top: 0; border-right:0; border-bottom: 0; border-left: 0;"></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td colspan="6" style=" border-top: 0; border-right:0; border-bottom: 0;">
                                                            <div style="margin-bottom: 20px; font-weight: bold;">Highest educational qualification:</div>

                                                        <div>
                                                                @if(!empty($education))

                                                                    @foreach($education as $index => $edu)

                                                                        <p>
                                                                        ({{ chr(97 + $index) }}) 
                                                                        {{ $edu['degree'] ?? '' }} 
                                                                        ({{ $edu['level'] ?? '' }}) 
                                                                        from {{ $edu['university'] ?? '' }} 
                                                                        in the year {{ $edu['year'] ?? '' }}
                                                                        </p>

                                                                    @endforeach

                                                                @endif
                                                                </div>

                                                            (Give details of highest School /University education mentioning the full form of the certificate/
                                                            diploma/ degree course, name of the School /College/ University and the year in which the course
                                                            was completed.)
                                                        </td>
                                                        
                                                    </tr>
                                                    
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        <div class="page-break" style="page-break-before: always;"></div>

                        <div style="text-align: center; font-weight:bold; margin-top: 15px;">VERIFICATION</div>

                        <p>
                            I, the deponent, above named, do hereby verify and declare that the contents of this
                            affidavit are true and correct to the best of my knowledge and belief and no part of it is false and
                            nothing material has been concealed there from. I further declare that:-
                        </p>

                        <p>
                            (a) there is no case of conviction or pending case against me other than those mentioned in items
                            5 and 6 of Part A and B above;
                        </p>

                        <p>
                            (b) I, my spouse, or my dependents do not have any asset or liability, other than those mentioned
                        in items 7 and 8 of Part A and items 8, 9 and 10 of Part B above.

                        </p>

                        <p style="text-align: justify;">Verified at <span class="flex-input" contenteditable="true" style="min-width:200px; text-align: center; padding:0 55px;"></span> this the <span class="flex-input" contenteditable="true" style="min-width:200px; text-align: center; padding:0 55px;"></span>day
                        of <span class="flex-input" contenteditable="true" style="min-width:200px; text-align: center; padding:0 55px;"></span>
                        </p>

                        <div style="text-align: right; font-weight:bold; margin-top: 15px; border-bottom: 1px solid #000; padding: 0 40px;">DEPONENT</div>

                        <p class="indent-para">
                            <span>Note: 1.</span> Affidavit should be filed latest by 3.00 PM on the last day of filing nominations.
                        </p>
                        <p class="indent-para">
                            <span>Note: 2.</span> Affidavit should be sworn before an Oath Commissioner or Magistrate of the First
                            Class or before a Notary Public.
                        </p>

                        <p class="indent-para">
                            <span>Note: 3.</span> All columns should be filled up and no column to be left blank. If there is no
                    information to furnish in respect of any item, either “Nil” or “Not Applicable”, as the case may be, should be mentioned
                        </p>

                    <p class="indent-para">
                        <span>Note: 4.</span> The affidavit should be either typed or written legibly and neatly.
                    </p>

                    <p class="indent-para" style="color: #e31111;">
                        <span>Note: 5.</span>Each page of the Affidavit should be signed by the deponent and the Affidavit
                should bear on each page the stamp of the Notary or Oath Commissioner or
                Magistrate before whom the Affidavit is sworn. 
                    </p>
                </div>

                <div class="text-end mt-4 no-print">
                {{-- <button
                        type="button"
                        wire:click="downloadPdf"
                        class="btn btn-success"
                    >
                        <span wire:loading.remove>Download PDF</span>
                        <span wire:loading>Generating PDF...</span>
                    </button>
                    --}}
                    {{-- <a 
                        href="{{ route('admin.candidates.form26.pdf', $form->id) }}" 
                        target="_blank"
                        class="btn btn-success"
                    >
                        Generate PDF
                    </a> --}}

                    <button type="button" onclick="printForm()" class="btn btn-success">
                        Generate PDF
                    </button>

                    <a href="{{ url()->previous() }}" class="btn btn-secondary">
                        Modify Details
                    </a>
                </div>

            </form>
        </div>
    </div>
@push('scripts')
    <script>
    function printForm() {

        var content = document.getElementById('printArea').innerHTML;

        var printWindow = window.open('', '', 'width=900,height=650');

        printWindow.document.write(`
            <html>
            <head>
                <title>Form 26</title>
                <style>
                    body{
                        font-family:'Times New Roman', Times, serif;
                        margin:20px;
                    }

                    @page{
                        size:A4;
                        margin:8mm;
                    }

                    table{
                        width:100%;
                        border-collapse:collapse;
                    }

                    table,th,td{
                        border:1px solid #000;
                    }

                    th,td{
                        padding:6px;
                    }

                    .no-print{
                        display:none;
                    }
                </style>
            </head>
            <body>
                ${content}
            </body>
            </html>
        `);

        printWindow.document.close();

        setTimeout(function(){
            printWindow.print();
            printWindow.close();
        },500);
    }
    </script>
@endpush


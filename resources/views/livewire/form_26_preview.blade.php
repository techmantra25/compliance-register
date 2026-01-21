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
        margin-top: 140mm;
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
    <div class="form-container">
        <div class="keep-together">
            <div class="pagenumber">
                <div style="text-align: center; font-weight:bold;">Form 26</div>
                <div class="center" style="font-weight:bold;">(See rule 4A)</div>

                <div style="text-align: right; overflow: auto; margin-bottom: 1px;">
                    <div class="photo-box">
                        <!-- Please affix your
                        recent passport
                        size photograph
                        here -->
                        <img src="data:image/png;base64,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">
                    </div>
                </div>
                <div style="text-align: center; font-weight:bold; margin-top: 20px; text-decoration: underline;">AFFIDAVIT</div>
                <div style="text-align: justify; font-weight: bold;">
                    AFFIDAVIT TO BE FILED BY THE CANDIDATE ALONGWITH NOMINATION PAPER BEFORE THE RETURNING OFFICER FOR ELECTION TO 
                    <span class="flex-input"  contenteditable="true" style="min-width:250px; text-transform: uppercase;">THE LEGISLATIVE ASSEMBLY</span>
                    (NAME OF THE HOUSE) FORM <span class="flex-input"  contenteditable="true" style="min-width:250px; text-transform: uppercase;">210 -NANDIGRAM ASSEMBLY</span>
                    CONSTITUENCY (NAME OF THE CONSTITUENCY)
                </div>

                <div style="text-align: center; font-weight:bold; margin-top: 20px; text-decoration: underline;">PART A</div>

                <p>
                    I<span class="flex-input"  contenteditable="true" style="padding: 0 30px;">MAMATA BANERJEE</span> 
                    **<span>son</span>/<span>daughter</span>/<span>wife</span> of 
                    <span class="flex-input"  contenteditable="true" style="padding: 0 30px;">Late PROMILESWAR BANERJEE</span>,
                    Aged <span class="flex-input"  contenteditable="true" style="padding: 0 30px;">66</span> years,
                    resident of <span class="flex-input"  contenteditable="true" style="padding: 0 30px;"> 30B, Harish Chatterjee Street, P.S-Kalighat, Kolkata 700026</span> 
                    (mention full postal address), a candidate at the above election, do hereby solemnly affirm and state on oath as under:-
                </p>

            </div>

            <div style=" page-break-before: always;"></div>

            <p>
                <strong>(1)</strong> I am a candidate set up by 
                <span class="flex-input"  contenteditable="true" style="padding: 0 30px;">ALL INDIA TRINAMOOL CONGRESS</span> 
            </p>
            <p>
                <span>(**name of the political party)</span> / <span class="strike-out">**am contesting as an Independent candidate.</span>
            </p>
            <p>
                (**strike out whichever is Not Applicable)
            </p>

            <p>
                <strong>(2)</strong> My name is enrolled in 
                <span class="flex-input"  contenteditable="true" style="padding: 0 30px;"> 159-BHABANIPUR ASSEMBLY CONSTITUENCY and State WEST BENGAL</span> 
                (Name of the Constituency and the state) at Serial No <span class="flex-input"  contenteditable="true" style="padding: 0 30px;">367</span>
                in Part No. <span class="flex-input"  contenteditable="true" style="padding: 0 30px;">209</span>
            </p>

            <p>
                <strong>(3)</strong> My contact telephone number(s) <span>is</span>/<span>are</span>
                <span class="flex-input"  contenteditable="true" style="padding: 0 30px;">033-2454-0881/62922-35555</span>
                and my e-mail id (if any) is <span class="flex-input"  contenteditable="true" style="padding: 0 30px;">210nandigram@gmail.com</span>
                and my social media account(s) (if any) <span>is</span>/<span>are</span>
            </p>
            <p>(i)<span class="flex-input"  contenteditable="true" style="padding: 0 30px;">WhatsApp No:- 62922-35555 </span></p>
            <p>(ii)<span class="flex-input"  contenteditable="true" style="padding: 0 30px;">Facebook A/c - @MamataBanerjeeOfficial</span></p>
            <p>(iii)<span class="flex-input"  contenteditable="true" style="padding: 0 30px;">Twitter A/c -  @MamataOfficial</span></p>

        </div>

        <div style="page-break-before: always;"></div>

        <div style="font-weight: bold;">(4) Details of Permanent Account Number (PAN) and status of filing of Income tax return:</div>
        <table>
            <tr>
                <th style="width: 80px;">Sl. No.</th>
                <th style="text-align: center;">Name</th>
                <th style="text-align: center;">PAN</th>
                <th style="text-align: justify; width:120px;">The financial year for which the last Incometax return has been filed</th>
                <th style="text-align: justify; width: 250px;">Total income shown in Income Tax Return(in Rupees) <span style="color: #e31111;">for the last five Financial Years completed (as on 31st March)</span></th>
            </tr>
            <tr>
                <td></td>
                <td style="text-align: center;">Self - <strong>Mamata Banerjee</strong></td>
                <td style="text-align: center;">AHCPB8207F</td>
                <td style="text-align: center;">2019-2020</td>
                <td style="padding: 0;">
                    <table style="border: none; margin: 0;">
                        <tr>
                            <td style="width: 16px; border-top:0; border-left:0;">(i)</td>
                            <td style="border-top:0; border-left:0; border-right:0; padding: 0;">
                            <table style="border: none; margin: 0;">
                                    <tr>
                                        <td style="border: none; border-right: 1px solid #000; width:90px; text-align: center;">(2019-20)</td>
                                        <td style="border: none;">Rs.10,34,370.00</td>
                                    </tr>
                            </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 16px; border-top:0; border-left:0;">(ii)</td>
                            <td style="border-top:0; border-left:0; border-right: 0; padding: 0;">
                                <table style="border: none; margin: 0;">
                                    <tr>
                                        <td style="border: none; border-right: 1px solid #000; width: 90px; text-align: center;">(2018-19)</td>
                                        <td style="border: none;">Rs.20,71,010.00</td>
                                    </tr>
                            </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 16px; border-top:0; border-left:0;">(iii)</td>
                            <td style="border-top:0; border-left:0; border-right: 0; padding: 0;">
                                <table style="border: none; margin: 0;">
                                    <tr>
                                        <td style="border: none; border-right: 1px solid #000; width: 90px; text-align: center;">(2017-18)</td>
                                        <td style="border: none;">Rs.835,300.00</td>
                                    </tr>
                            </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 16px; border-top:0; border-left:0;">(iv)</td>
                            <td style="border-top:0; border-left:0; border-right: 0; padding: 0;">
                                <table style="border: none; margin: 0;">
                                    <tr>
                                        <td style="border: none; border-right: 1px solid #000; width: 90px; text-align: center;">(2016-17)</td>
                                        <td style="border: none;">Rs.918,300.00</td>
                                    </tr>
                            </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 16px; border-top:0; border-left:0; border-bottom: 0;">(v)</td>
                            <td style="border-top:0; border-left:0; border-right: 0; border-bottom: 0; padding: 0;">
                                <table style="border: none; margin: 0;">
                                    <tr>
                                        <td style="border: none; border-right: 1px solid #000; width: 90px; text-align: center;">(2015-16)</td>
                                        <td style="border: none;">Rs.172,910.00</td>
                                    </tr>
                            </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td>2</td>
                <td style="text-align: center;">Spouse</td>
                <td style="text-align: center;">Not Applicable</td>
                <td style="text-align: center;">Not Applicable</td>
                <td style="padding: 0;">
                    <table style="border: none; margin: 0;">
                        <tr>
                            <td style="width: 16px; border-top:0; border-left:0;">(i)</td>
                            <td style="border-top:0; border-left:0; border-right: 0; text-align: center;">Not Applicable</td>
                        </tr>
                        <tr>
                            <td style="width: 16px; border-top:0; border-left:0;">(ii)</td>
                            <td style="border-top:0; border-left:0; border-right: 0; text-align: center;">Not Applicable</td>
                        </tr>
                        <tr>
                            <td style="width: 16px; border-top:0; border-left:0;">(iii)</td>
                            <td style="border-top:0; border-left:0; border-right: 0; text-align: center;">Not Applicable</td>
                        </tr>
                        <tr>
                            <td style="width: 16px; border-top:0; border-left:0;">(iv)</td>
                            <td style="border-top:0; border-left:0; border-right: 0; text-align: center;">Not Applicable</td>
                        </tr>
                        <tr>
                            <td style="width: 16px; border-top:0; border-left:0; border-bottom: 0;">(v)</td>
                            <td style="border-top:0; border-left:0; border-right: 0; border-bottom: 0; text-align: center;">Not Applicable</td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td>3</td>
                <td style="text-align: center;">HUF (If Candidate is Karta/Coparcener) </td>
                <td style="text-align: center;">Not Applicable</td>
                <td style="text-align: center;">Not Applicable</td>
                <td style="padding: 0;">
                    <table style="border: none; margin: 0;">
                        <tr>
                            <td style="width: 16px; border-top:0; border-left:0;">(i)</td>
                            <td style="border-top:0; border-left:0; border-right: 0; text-align: center;">Not Applicable</td>
                        </tr>
                        <tr>
                            <td style="width: 16px; border-top:0; border-left:0;">(ii)</td>
                            <td style="border-top:0; border-left:0; border-right: 0; text-align: center;">Not Applicable</td>
                        </tr>
                        <tr>
                            <td style="width: 16px; border-top:0; border-left:0;">(iii)</td>
                            <td style="border-top:0; border-left:0; border-right: 0; text-align: center;">Not Applicable</td>
                        </tr>
                        <tr>
                            <td style="width: 16px; border-top:0; border-left:0;">(iv)</td>
                            <td style="border-top:0; border-left:0; border-right: 0; text-align: center;">Not Applicable</td>
                        </tr>
                        <tr>
                            <td style="width: 16px; border-top:0; border-left:0; border-bottom: 0;">(v)</td>
                            <td style="border-top:0; border-left:0; border-right: 0; border-bottom: 0; text-align: center;">Not Applicable</td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr >
                <td>4</td>
                <td style="text-align: center;">Dependent 1</td>
                <td style="text-align: center;">Not Applicable</td>
                <td style="text-align: center;">Not Applicable</td>
                <td style="padding: 0;">
                    <table style="border: none; margin: 0;">
                        <tr>
                            <td style="width: 16px; border-top:0; border-left:0;">(i)</td>
                            <td style="border-top:0; border-left:0; border-right: 0; text-align: center;">Not Applicable</td>
                        </tr>
                        <tr>
                            <td style="width: 16px; border-top:0; border-left:0;">(ii)</td>
                            <td style="border-top:0; border-left:0; border-right: 0; text-align: center;">Not Applicable</td>
                        </tr>
                        <tr>
                            <td style="width: 16px; border-top:0; border-left:0;">(iii)</td>
                            <td style="border-top:0; border-left:0; border-right: 0; text-align: center;">Not Applicable</td>
                        </tr>
                        <tr>
                            <td style="width: 16px; border-top:0; border-left:0;">(iv)</td>
                            <td style="border-top:0; border-left:0; border-right: 0; text-align: center;">Not Applicable</td>
                        </tr>
                        <tr>
                            <td style="width: 16px; border-top:0; border-left:0; border-bottom: 0;">(v)</td>
                            <td style="border-top:0; border-left:0; border-right: 0; border-bottom: 0; text-align: center;">Not Applicable</td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="page-break" style="page-break-before: always;">
                <td>5</td>
                <td style="text-align: center;">Dependent 2</td>
                <td style="text-align: center;">Not Applicable</td>
                <td style="text-align: center;">Not Applicable</td>
                <td style="padding: 0;">
                    <table style="border: none; margin: 0;">
                        <tr>
                            <td style="width: 16px; border-top:0; border-left:0;">(i)</td>
                            <td style="border-top:0; border-left:0; border-right: 0; text-align: center;">Not Applicable</td>
                        </tr>
                        <tr>
                            <td style="width: 16px; border-top:0; border-left:0;">(ii)</td>
                            <td style="border-top:0; border-left:0; border-right: 0; text-align: center;">Not Applicable</td>
                        </tr>
                        <tr>
                            <td style="width: 16px; border-top:0; border-left:0;">(iii)</td>
                            <td style="border-top:0; border-left:0; border-right: 0; text-align: center;">Not Applicable</td>
                        </tr>
                        <tr>
                            <td style="width: 16px; border-top:0; border-left:0;">(iv)</td>
                            <td style="border-top:0; border-left:0; border-right: 0; text-align: center;">Not Applicable</td>
                        </tr>
                        <tr>
                            <td style="width: 16px; border-top:0; border-left:0; border-bottom: 0;">(v)</td>
                            <td style="border-top:0; border-left:0; border-right: 0; border-bottom: 0; text-align: center;">Not Applicable</td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td>6</td>
                <td style="text-align: center;">Dependent 3</td>
                <td style="text-align: center;">Not Applicable</td>
                <td style="text-align: center;">Not Applicable</td>
                <td style="padding: 0;">
                    <table style="border: none; margin: 0;">
                        <tr>
                            <td style="width: 16px; border-top:0; border-left:0;">(i)</td>
                            <td style="border-top:0; border-left:0; border-right: 0; text-align: center;">Not Applicable</td>
                        </tr>
                        <tr>
                            <td style="width: 16px; border-top:0; border-left:0;">(ii)</td>
                            <td style="border-top:0; border-left:0; border-right: 0; text-align: center;">Not Applicable</td>
                        </tr>
                        <tr>
                            <td style="width: 16px; border-top:0; border-left:0;">(iii)</td>
                            <td style="border-top:0; border-left:0; border-right: 0; text-align: center;">Not Applicable</td>
                        </tr>
                        <tr>
                            <td style="width: 16px; border-top:0; border-left:0;">(iv)</td>
                            <td style="border-top:0; border-left:0; border-right: 0; text-align: center;">Not Applicable</td>
                        </tr>
                        <tr>
                            <td style="width: 16px; border-top:0; border-left:0; border-bottom: 0;">(v)</td>
                            <td style="border-top:0; border-left:0; border-right: 0; border-bottom: 0; text-align: center;">Not Applicable</td>
                        </tr>
                    </table>
                </td>
            </tr>

        </table>

        <p style="color: #e31111;">
            Note: It is mandatory for PAN holder to mention PAN and in case of no PAN, it should be clearly stated “No PAN allotted”. 
        </p>

        <h3>(5) Pending Criminal Cases</h3>

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


        <table style="table-layout: fixed; margin-top: 25px;">
            <tr>
                <th style="width: 50px; font-weight: bold;">S. No.</th>
                <th style="font-weight: bold; width:100px;">Description</th>
                <th style="font-weight: bold; width:150px;">Self</th>
                <th style="font-weight: bold;">Spouse</th>
                <th style="font-weight: bold;">HUF</th>
                <th style="font-weight: bold;">Dependent-1</th>
                <th style="font-weight: bold;">Dependent-2</th>
                <th style="font-weight: bold;">Dependent-3</th>
            </tr>
            <tr>
                <td>(i)</td>
                <td>
                    Cash in hand
                    (As on Date)
                </td>
                <td>69,255.00</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
            </tr>

            <tr>
                <td >(ii)</td>
                <td>
                    Details of deposit in Bank
                    accounts (FDRs, Term
                    Deposits and all other types
                    of deposits including
                    saving accounts), Deposits
                    with Financial Institutions,
                    Non-Banking Financial
                    Companies and
                    Cooperative societies and
                    the amount in each such
                    deposit
                </td>
                <td>
                    Indian Bank (Previously Allahabad Bank) <br> Br. H.M.Road Saving A/с No.20790470930 Rs. 12,02,356.71 <br> Election Expenses
                    Acccount INDIAN BANK <br> Br. H.M.ROAD Account No. 6992897574 <br> Rs. 151,000.00 Total Balance Bank (As on Date)
                    Rs. 13,53,356.71
                </td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>

            </tr>

            <tr>
                <td >(iii)</td>
                <td>
                    Details of investment in
                    Bonds, Debentures /shares land units in companies /Mutual
                    funds and others and the amount
                </td>
                <td>
                    Not Applicable
                </td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>

            </tr>

            <tr>
                <td >(iv)</td>
                <td>
                    Details of
                    investment in NSS,
                    Postal Saving,
                    Insurance policies
                    and investment in
                    any Financial
                    instruments in Post office or Insurance
                    Company and the
                    amount
                </td>
                <td>
                    National Saving Certificate
                    Rs.18,490.00
                </td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>

            </tr>

            <tr class="page-break" style="page-break-before: always;">
                <td >(v)</td>
                <td>
                    Personal loans/
                    advance given to
                    any person or
                    entity including
                    firm, company,
                    Trust etc., and
                    other receivables
                    from debtors and
                    the amount
                </td>
                <td>
                    Security Deposit
                    (BSNL)
                    Rs. 500
                    Royalty Receivable
                    Rs. 930.00
                    TDS Receivable
                    (F.Y-2019-20)
                    RS. 1,85,984.00
                </td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>

            </tr>

            <tr>
                <td >(vi)</td>
                <td>
                    Motor Vehicles/
                    Aircrafts/Yachts
                    /Ships (Details of
                    Make, registration
                    number etc. year of
                    purchase and
                    amount)
                </td>
                <td>
                    Not Applicable
                </td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
            </tr>

            <tr>
                <td >(vii)</td>
                <td>
                    Jewellery, bullion
                    and valuable
                    thing(s) (give
                    Details
                    of weight
                    value)
                </td>
                <td>
                    9gm. 750 mg.
                    <strong>Rs. 43,837.00</strong>
                    (As per Mkt. Value
                    Approx)
                </td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
            </tr>

            <tr>
                <td >(viii)</td>
                <td>
                    Any other assets
                    such as value of
                    claims/interest
                </td>
                <td>
                    Not Applicable
                </td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
            </tr>

            <tr>
                <td style="font-weight: bold;" >(ix)</td>
                <td style="font-weight: bold;">
                    Gross Total Value
                </td>
                <td style="font-weight: bold;">
                    16,72,352.71
                </td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
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


        <table style="table-layout: fixed; margin-top: 35px;">
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
            <tr>
                <td style="border-bottom: 1px solid #fff;">(i)</td>
                <td>
                    <strong style="text-decoration: underline;">Agricultural Land</strong> <br>
                    Location(s)
                    Survey number(s)

                </td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #fff;"></td>
                <td >
                    Area (total measurement in acres)
                </td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
            </tr>
            <tr class="page-break">
                <td style="border-bottom: 1px solid #fff;"></td>
                <td >
                    Whether inherited
                    property (Yes or No)
                </td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
            </tr> 
            <tr>
                <td style="border-bottom: 1px solid #fff;"></td>
                <td>
                    Date of purchase in case
                    of self - acquired property
                </td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #fff;"></td>
                <td>
                    Cost of Land (in case of
                    purchase) at the time of purchase
                </td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #fff;"></td>
                <td>
                    Any Invest ment on the
                    land by way of develop
                    ment, construction
                    etc.
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
                <td>
                    Approxi mate Current
                    market value
                </td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #fff;">(ii)</td>
                <td>
                    <strong style="text-decoration: underline;">Non-Agricultural Land</strong> <br>
                    Location(s)
                    Survey number(s)

                </td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #fff;"></td>
                <td>
                    Area (total measurement in sq. ft.)
                </td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #fff;"></td>
                <td>
                    Whether inherited
                    property
                    (Yes or No)
                </td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #fff;"></td>
                <td>
                    Date of purchase in case
                    of self-acquired property
                </td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #fff;"></td>
                <td>
                    Cost of Land (in case of
                    purchase) at the time of
                    purchase
                </td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #fff;"></td>
                <td>
                    Any Investment on the
                    land by way of develop
                    ment, construction
                    etc.
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
                <td>
                    Approximate
                    current market value
                </td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #fff;">(iii)</td>
                <td>
                    <strong style="text-decoration: underline;">Commercial Buildings</strong> <br>
                    (including apartments)
                    -Location(s)<br>
                    -Survey number(s)<br>
                    10 Area (total
                    measurement in sq. ft.)
                </td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #fff;"></td>
                <td>
                    Built-up Area (total
                    measurement in sq.ft.)

                </td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #fff;"></td>
                <td>
                    Whether inherited
                    property (Yes or No)
                </td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #fff;"></td>
                <td>
                    Date of purchase in case of self-acquired property
                </td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #fff;"></td>
                <td>
                    Cost of property (in case of purchase) at the time of purchase
                </td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #fff;"></td>
                <td>
                    Any Investment on the property by way of
                    development, construction
                    etc.
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
                <td>
                    Approximate current market value
                </td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #fff;">(iv)</td>
                <td>
                    <strong style="text-decoration: underline;">Residential Buildings</strong> <br>
                    (including apartments): -Location (s) -Survey number(s)
                </td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #fff;"></td>
                <td>
                    Area (Total measurement in sq. ft) 
                </td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #fff;"></td>
                <td>
                    Built up Area (Total measurement in sq. ft.)
                </td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #fff;"></td>
                <td>
                    Whether inherited property (Yes or No)
                </td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #fff;"></td>
                <td>
                    Date of purchase in case of self–acquired property
                </td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #fff;"></td>
                <td>
                    Cost of property (in case of purchase) at the time of purchase
                </td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #fff;"></td>
                <td>
                    Any Investment on the
                    land by way of develop
                    ment, construction etc.
                </td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
            </tr>
            <tr>
                <td ></td>
                <td>
                    Approximate current market value
                </td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
            </tr>
            <tr class="page-break">
                <td>(v)</td>
                <td>
                    Others (such as interest in property)
                </td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
            </tr>
            <tr>
                <td>(vi)</td>
                <td>
                    Total of current market value of (i) to (v) above
                </td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
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
            <tr>
                <td style="border-bottom: 1px solid #fff;">(i)</td>
                <td>
                    <strong>Loan or dues to Bank/Financial Institution(s) </strong> <br>
                    Name of Bank or
                    Financial Institution,
                    Amount outstanding,
                    Nature of loan

                </td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid #fff;"></td>
                <td>
                    <strong>Loan or dues to any other individuals/
                    entity other than mentioned above.</strong> <br>
                    Name(s), Amount outstanding, nature of loan
                </td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
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
            <tr >
                <td style="border-bottom: 1px solid #fff;"></td>
                <td>
                    <strong>Grand total of liabilities</strong>
                </td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
                <td>Not Applicable</td>
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

            <tr class="page-break">
                <td>(iv)</td>
                <td>
                Income Tax dues
                </td>
                <td  style="text-align: center; vertical-align: middle;" >
                    NIL
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    Not Applicable
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    Not Applicable
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    Not Applicable
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    Not Applicable
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    Not Applicable
                </td>
            </tr>

            <tr>
                <td>(v)</td>
                <td>
                GST dues
                </td>
                <td  style="text-align: center; vertical-align: middle;" >
                    NIL
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    Not Applicable
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    Not Applicable
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    Not Applicable
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    Not Applicable
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    Not Applicable
                </td>
            </tr>

            <tr>
                <td>(vi)</td>
                <td>
                Municipal/Property tax dues
                </td>
                <td  style="text-align: center; vertical-align: middle;" >
                    NIL
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    Not Applicable
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    Not Applicable
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    Not Applicable
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    Not Applicable
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    Not Applicable
                </td>
            </tr>

            <tr>
                <td>(vii)</td>
                <td>
                Any other dues
                </td>
                <td  style="text-align: center; vertical-align: middle;" >
                    NIL
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    Not Applicable
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    Not Applicable
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    Not Applicable
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    Not Applicable
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    Not Applicable
                </td>
            </tr>

            <tr>
                <td>(viii)</td>
                <td>
                Grand total of all Government dues
                </td>
                <td  style="text-align: center; vertical-align: middle;" >
                    NIL
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    Not Applicable
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    Not Applicable
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    Not Applicable
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    Not Applicable
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    Not Applicable
                </td>
            </tr>
            <tr>
                <td>(ix)</td>
                <td>
                    Whether any other liabilities are in dispute,
                    if so, mention the amount involved and the
                    authority before which it is pending.
                </td>
                <td  style="text-align: center; vertical-align: middle;" >
                    Not Applicable
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    Not Applicable
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    Not Applicable
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    Not Applicable
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    Not Applicable
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    Not Applicable
                </td>
            </tr>
        </table>


        <p class="indent-para">
            <span style="font-weight: bold;">(9)</span><strong> Details of profession or occupation:</strong>
            <p style="padding: 0 23px;">
            (a) Self <span class="flex-input" contenteditable="true" style="min-width:200px; text-align: center;">Social Work & Politics</span>
            </p>
            <p style="padding: 0 23px;">
            (b) Spouse <span class="flex-input" contenteditable="true" style="min-width:200px; text-align: center;">Not Applicable</span>
            </p>
        </p>

        <p class="indent-para">
            <span>(9A)</span> Details of source(s) of income:
            <p style="padding: 0 23px;">
            (a) Self <span class="flex-input" contenteditable="true" style="min-width:200px; text-align: center;">Royalty and Bank Interst and others.</span>
            </p>
            <p style="padding: 0 23px;">
            (b) Spouse <span class="flex-input" contenteditable="true" style="min-width:200px; text-align: center;">Not Applicable</span>
            </p>
            <p style="padding: 0 23px;">
            (c) Source of income, if any, of dependents, <span class="flex-input" contenteditable="true" style="min-width:200px; text-align: center;">Not Applicable</span>
            </p>
        </p>

        <p class="indent-para">
            <span>(9B)</span> Contracts with appropriate Government and any public company or companies
            <p style="padding: 0 23px;">
            (a) details of contracts entered by the candidate <span class="flex-input" contenteditable="true" style="min-width:200px; text-align: center;">Not Applicable</span>
            </p>
            <p style="padding: 0 23px;">
            (b) details of contracts entered into by spouse <span class="flex-input" contenteditable="true" style="min-width:200px; text-align: center;">Not Applicable</span>
            </p>
            <p style="padding: 0 23px;">
            (c) details of contracts entered into by dependents <span class="flex-input" contenteditable="true" style="min-width:200px; text-align: center;">Not Applicable</span>
            </p>
            
            <p style="padding: 0 23px;">
            (d) details of contracts entered into by Hindu Undivided Family or trust in which the
            
            candidate or spouse or dependents have interest <span class="flex-input" contenteditable="true" style="min-width:200px; text-align: center;">Not Applicable</span>
            </p>
            <div class="page-break"></div>
            <p style="padding: 0 23px;">
            (e) details of contracts, entered into by Partnership Firms in which candidate or
                spouse or dependents are partners <span class="flex-input" contenteditable="true" style="min-width:200px; text-align: center;">Not Applicable</span>
            </p>
            <p style="padding: 0 23px;">
            (f) details of contracts, entered into by private companies in which candidate or
                spouse or dependents have share <span class="flex-input" contenteditable="true" style="min-width:200px; text-align: center;">Not Applicable</span>
            </p>
        </p>
        <p class="indent-para">
            <span style="font-weight: bold;">(10)</span><strong> My educational qualification is as under:</strong>
            <p style="padding: 0 23px;">
            <span class="flex-input" contenteditable="true" style="min-width:400px; text-align: center;">(a) Passed Secondary Examination from Deshbandhu Sishu Sikshlaya in the year 1970</span>
            </p>
            <p style="padding: 0 23px;">
            <span class="flex-input" contenteditable="true" style="min-width:400px; text-align: center;">(b) Graduation (B.A.) from Jogamaya Devi College (Calcutta University) In the year 1974</span>
            </p>
            <p style="padding: 0 23px;">
            <span class="flex-input" contenteditable="true" style="min-width:400px; text-align: center;"> (c) M.A. from Calcutta University in the year 1977 (Examination held in the year 1979).</span>
            </p>
            <p style="padding: 0 23px;">
            <span class="flex-input" contenteditable="true" style="min-width:400px; text-align: center;"> (d) LLB from Jogesh Chandra Chaudhury College of Law under the Calcutta University in the year 1982</span>
            </p>
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
                    <span class="strike-out">Sh</span>/<span>Smt.</span>/<span class="strike-out">Kum</span>
                    MAMATA BANERJEE
                </td>
            </tr>
            <tr>
                <td style="width: 60px;">2.</td>
                <td style="text-align: justify; width:200px;">
                    Full postal address
                </td>
                <td style="text-align: center; font-weight: bold; vertical-align: middle;">
                    30B, HARISH CHATTERJEE STREET,P.S-KALIGHAT, KOLKATA 700 026
                </td>
            </tr>
            <tr>
                <td style="width: 60px;">3.</td>
                <td style="text-align: justify; width:200px;">
                    Number and name the constituency and State
                    of
                </td>
                <td style="text-align: center; font-weight: bold; vertical-align: middle;">
                    159-BHABANIPUR ASSEMBLY
                        CONSTITUENCY WEST BENGAL
                </td>
            </tr>
            <tr>
                <td style="width: 60px;">4.</td>
                <td style="text-align: justify; width:200px;">
                    Name of the political party which set up the candidate (otherwise write' Independent')
                </td>
                <td style="text-align: center; font-weight: bold; vertical-align: middle;">
                    ALL INDIA TRINAMOOL CONGRESS
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

                        <tr>
                            <td style="border:1px solid #fff; width:60px; border-right-color: #000;"></td>
                            <td>(a) Candidate</td>
                            <td style="text-align: center; font-weight: bold; vertical-align: middle;">AHCPB8207F</td>
                            <td style="text-align: center; font-weight: bold; vertical-align: middle;">F.Y-19-20</td>
                            <td style="text-align: center; font-weight: bold; vertical-align: middle; border-right: 0;">RS. 10,34,370.00</td>
                        </tr>

                        <tr>
                            <td style="border:1px solid #fff; width:60px; border-right-color: #000;"></td>
                            <td>(b) Spouse</td>
                            <td style="text-align: center; font-weight: bold; vertical-align: middle;">Not Applicable</td>
                            <td style="text-align: center; font-weight: bold; vertical-align: middle;">Not Applicable</td>
                            <td style="text-align: center; font-weight: bold; vertical-align: middle; border-right: 0;">Not Applicable</td>
                        </tr>
                        <tr>
                            <td style="border:1px solid #fff; width:60px; border-right-color: #000;"></td>
                            <td style="color: #e31111;">(c) HUF</td>
                            <td style="text-align: center; font-weight: bold; vertical-align: middle;">Not Applicable</td>
                            <td style="text-align: center; font-weight: bold; vertical-align: middle;">Not Applicable</td>
                            <td style="text-align: center; font-weight: bold; vertical-align: middle; border-right: 0;">Not Applicable</td>
                        </tr>
                        <tr>
                            <td style="border:1px solid #fff; width:60px; border-right-color: #000; border-bottom-color: #000;"></td>
                            <td>(d) Dependent</td>
                            <td style="text-align: center; font-weight: bold; vertical-align: middle;">Not Applicable</td>
                            <td style="text-align: center; font-weight: bold; vertical-align: middle;">Not Applicable</td>
                            <td style="text-align: center; font-weight: bold; vertical-align: middle; border-right: 0;">Not Applicable</td>
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

                                    <tr>
                                        <td style="vertical-align: middle; border-left: 0;">A</td>
                                        <td style="vertical-align: middle;"><strong>Moveable Assets(Total value)</strong></td>
                                        <td style="vertical-align: middle;">16,72,352.71</td>
                                        <td style="vertical-align: middle;">Not Applicable</td>
                                        <td style="vertical-align: middle;">Not Applicable</td>
                                        <td style="vertical-align: middle;">Not Applicable</td>
                                        <td style="vertical-align: middle; border-right: 0;">Not Applicable</td>
                                    </tr>

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
                                        <td>Not Applicable</td>
                                        <td>Not Applicable</td>
                                        <td>Not Applicable</td>
                                        <td>Not Applicable</td>
                                        <td style=" border-right: 0;">Not Applicable</td>
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
                                        <td>Not Applicable</td>
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
                                                <p>(a) Passed Secondary Examination from Deshbandhu Sishu Sikshlaya in the year 1970</p>
                                                <p>(b) Graduation (B.A.) from Jogamaya Devi College (Calcutta University) In the year 1974</p>
                                                <p>(c) M.A. from Calcutta University in the year 1977 (Examination held in the year 1979).</p>
                                                <p>(d) LLB from Jogesh Chandra Chaudhury College of Law under the Calcutta University in the year 1982</p>
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
</div>


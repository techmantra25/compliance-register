<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Acknowledgement</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.6;
        }

        .container {
            width: 100%;
        }

        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        td {
            padding: 6px;
            border-bottom: 1px solid #ccc;
        }

        .section-title {
            font-weight: bold;
            margin-top: 15px;
        }

        .signature {
            margin-top: 50px;
        }

        .signature td {
            border: none;
            padding-top: 40px;
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="title">
            ACKNOWLEDGEMENT
        </div>

        <p>
            The Nomination Paper of the following Candidate in Form 2B and the Affidavit in Form 26 to be filed in
            connection with the ensuing General Elections to the WBLA, 2026 have duly been examined by Fox and Mandal,
            and found to be appropriate for submission to the Returning Officer, subject to the terms and conditions
            noted below:
        </p>

        <table style="width:100%; border-collapse: collapse; font-size:12px;">

            <tr>
                <td width="40%"><strong>Name of the Candidate</strong></td>
                <td>: {{ $candidateName ?? 'N/A' }}</td>
            </tr>

            <tr>
                <td><strong>Assembly Constituency (AC)</strong></td>
                <td>: {{ $assemblyName ?? 'N/A' }}</td>
            </tr>

            <tr>
                <td><strong>Date of Examination</strong></td>
                
                <td>
                    : {{ $Examination
                        ? \Carbon\Carbon::parse($Examination)->format('d M Y h:i A')
                        : \Carbon\Carbon::now()->format('d M Y h:i A') }}
                </td>
            </tr>

            <tr>
                <td><strong>Last date & time of Submission</strong></td>
                <td>
                    : {{ $nomination_date
                        ? \Carbon\Carbon::parse($nomination_date)->format('d M Y h:i A')
                        : 'N/A' }}
                </td>
            </tr>

        </table>


        <div class="section-title">Terms and conditions:</div>

        <p>
            1. It is presumed that the documents produced by the Candidates/ Proposers/ Election Agents/ Representatives
            of Candidates in support of the personal identity, address proof, educational qualification, Income Tax
            Records and other supporting documents are authentic and genuine.
        </p>

        <p>
            2. Disclosures by Candidates pertaining to the following information are accepted as true and correct based
            strictly on the candidate’s personal declaration and the representations of their professional advisors. The
            law firm has only verified that these fields are correctly populated but has not performed an independent
            audit or legal due diligence to confirm their veracity.
        </p>

        <p>
            a) Financials: All PAN and Income declarations for Self, Spouse, HUF, and Dependents.
        </p>

        <p>
            b) Legal/Criminal: All declarations regarding pending cases, convictions, FIRs, sections of law, and appeal
            statuses.
        </p>

        <p>
            c) Assets: All details concerning movable and immovable property values.
        </p>

        <p>
            3. Form 26 is a sworn affidavit, and the ultimate legal burden for the accuracy of these disclosures rests
            solely with the deponent (the candidate). The law firm’s role is limited to ensuring the form is technically
            unassailable for the purposes of the Returning Officer's scrutiny.
        </p>


        <br><br>

        <p><strong>For Fox & Mandal:</strong></p>
        <p><strong>Checked & Verified By:</strong></p>
        <p>{{$authorizedBy}}</p>
        <table class="signature">
            <tr>
                <td width="50%">
                    ___________________________<br>
                    (Authorized Signatory)
                </td>

                <td width="50%">
                </td>
            </tr>
        </table>


        <p><strong>Candidate / Authorized Representative:</strong>
            I acknowledge receipt of the checked Nomination Form in Form 2B/Affidavit in Form 26. I affirm that I have
            reviewed the contents and that all disclosures are true and accurate.
        </p>


        <table class="signature">
            <tr>
                <td>
                    Signature: ___________________________
                </td>
            </tr>

            <tr>
                <td>
                    Name: _______________________________
                </td>
            </tr>

            <tr>
                <td>
                    Date/Time: __________________________
                </td>
            </tr>
        </table>


    </div>

</body>

</html>
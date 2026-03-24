<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Acknowledgement</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.4;
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
            margin-top: 20px;
        }

        .signature td {
            border: none;
            padding-top: 5px;
        }
        p {
            margin: 6px 0;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="title">
        ACKNOWLEDGEMENT
    </div>

    <p>
        The Nomination Form of the following candidate in Form 2B and the Affidavit in Form 26 proposed to be filed in
        connection with the ensuing General Elections to the WBLA, 2026 have duly been examined by IPAC and Fox &
        Mandal, and found to be in order for submission to the Returning Officer, subject to the observations noted below:
    </p>

    <table>
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
            <td><strong>Last Date & Time of Submission</strong></td>
            <td>
                : {{ $nomination_date
                    ? \Carbon\Carbon::parse($nomination_date)->format('d M Y h:i A')
                    : 'N/A' }}
            </td>
        </tr>
    </table>

    <div class="section-title">Notes:</div>

    <p>
        1. It is presumed that the documents produced by the Candidate/ Proposer/ Election Agent/ representative of the
        candidate in support of the personal identity, address proof, educational qualification, Income Tax Records
        (Financial Data), Criminal Case/ Litigation History (if any) and other supporting documents are true and correct
        and nothing has been suppressed or concealed.
    </p>

    <p>
        2. Disclosures by the candidate pertaining to the following information have been accepted as true and correct
        based strictly on the Candidate's personal declaration and the representations of his / her professional advisors.
        The checking team has only verified that these fields are correctly populated and has not performed an independent
        audit or legal due diligence to confirm their truth or veracity.
    </p>

    <p>a) Financials: All PAN and income declarations for Self, Spouse, HUF, and Dependents.</p>
    <p>b) Legal/Criminal: All declarations regarding pending cases, convictions, FIRs, sections of law, and appeal statuses.</p>
    <p>c) Assets: All details concerning movable and immovable property values.</p>

    <p>
        3. Form 26 is a sworn affidavit, and the entire risk and responsibility for the accuracy of these disclosures and
        the affidavit rests solely with the deponent (the Candidate). The checking team’s role is limited to verifying
        filling up of the Form as per data and records made available to us.
    </p>
    <br>

    <div class="section-title">CONFIRMATION BY CANDIDATE/ AUTHORIZED REPRESENTATIVE</div>

    <p>I CONFIRM</p>

    <p style="padding-top:10px;">
        <strong>Candidate / Authorized Representative:</strong> I acknowledge receipt of the checked Nomination Form in Form 2B/ Affidavit
        in Form 26. I take responsibility for the truth of the data mentioned therein and agree with the observations of
        the team checking the Form mentioned above. I take responsibility for timely submission in the prescribed manner
        after finally reviewing the contents of the Form and Affidavit and checking that all disclosures are true and accurate.
    </p>

    <table class="signature">
        <tr>
            <td>Signature: ___________________________</td>
        </tr>
        <tr>
            <td>Name: _______________________________</td>
        </tr>
        <tr>
            <td>Date/Time: __________________________</td>
        </tr>
    </table>

</div>

</body>

</html>
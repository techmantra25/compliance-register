<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.6;
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
            margin-top: 10px;
        }

        td {
            padding: 6px;
            vertical-align: top;
        }

        .signature {
            margin-top: 60px;
        }
    </style>
</head>

<body>

    <div class="title">OBSERVATION MEMO</div>

    <p>
        The Nomination Paper of the following Candidate in Form 2B and the Affidavit in Form 26 to be filed in
        connection with the ensuing General Elections to the WBLA, 2026 have duly been examined by Fox and Mandal, and
        the following discrepancies/ defects have been found. Those would have to be rectified before submission of the
        forms to the Returning Officer:
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
            <td>: {{ \Carbon\Carbon::parse($examinationDate)->format('d M Y') }}</td>
        </tr>

        <tr>
            <td><strong>Discrepancies/ defects Observed</strong></td>
            <td style="line-height:1.6;">
                {!! $observations ?? '__________________________________________' !!}
            </td>
        </tr>

        <tr>
            <td><strong>Last date and time for submission of rectified Forms and curing of defects</strong></td>
            <td>
                : {{ $nomination_date
    ? \Carbon\Carbon::parse($nomination_date)->format('d M Y h:i A')
    : 'N/A' }}
            </td>
        </tr>

    </table>


    <br><br>

    <p><strong>For Fox & Mandal:</strong></p>

    <p class="signature">
        _____________________________<br>
        (Authorized Signatory)
    </p>


    <p>
        <strong>Candidate / Authorized Representative:</strong>
        I acknowledge receipt of the Observations against the Nomination Form in Form 2B/Affidavit in Form 26. I will
        rectify the discrepancies/ defects and resubmit the forms within the time above. I understand that any delay
        will be on my account and Fox & Mandal will have no risk/ liability in that regard.
    </p>


    <br><br>

    <p>
        Signature: ___________________________
    </p>

    <p>
        Name: _______________________________
    </p>

    <p>
        Date/Time: __________________________
    </p>

</body>

</html>
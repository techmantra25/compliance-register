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
        table, td {
            border: 1px solid #ccc; 
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <div class="title">OBSERVATION MEMO</div>

    <p>
        The Nomination Paper of the following Candidate in Form 2B and the Affidavit in Form 26 proposed to be filed in
        connection with the ensuing General Elections to the WBLA, 2026 have duly been examined by IPAC and Fox & Mandal,
        and the following discrepancies/ defects have been found. Those would have to be rectified before submission of the
        forms to the Returning Officer:
    </p>

    <table>

        <tr>
            <td width="40%"><strong>Name of the Candidate</strong>:</td>
            <td> {{ $candidateName ?? 'N/A' }}</td>
        </tr>

        <tr>
            <td><strong>Assembly Constituency (AC)</strong>:</td>
            <td> {{ $assemblyName ?? 'N/A' }}</td>
        </tr>

        <tr>
            <td><strong>Date of Examination</strong>:</td>
            <td> {{ $examinationDate
                ? \Carbon\Carbon::parse($examinationDate)->format('d M Y h:i A')
                : \Carbon\Carbon::now()->format('d M Y h:i A') }}</td>
        </tr>

        <tr>
            <td><strong>Discrepancies/ Defects Observed</strong>:</td>
            <td style="line-height:1.8;">
                
                @php
                    $obsList = is_array($observations)
                        ? $observations
                        : json_decode($observations, true);

                    $count = 1;
                @endphp

                @if(!empty($obsList))

                    {{-- Normal Observations --}}
                    @foreach($obsList as $obs)
                        @if($obs !== 'Others')
                            {{ $count++ }}) {{ $obs }}<br>
                        @endif
                    @endforeach

                    {{-- Others Section --}}
                    @if(in_array('Others', $obsList))
                        {{ $count }}) Others:@if(!empty($others))
                                {!! $others !!}
                        @endif

                        
                    @endif

                @else
                    __________________________________________
                @endif
            </td>
        </tr>

        <tr>
            <td><strong>Last date and time for submission of rectified Forms and curing of defects</strong>:</td>
            <td>
                 {{ $nomination_date
                    ? \Carbon\Carbon::parse($nomination_date)->format('d M Y h:i A')
                    : 'N/A' }}
            </td>
        </tr>

    </table>

    <br><br>

    <p>
        <strong>Candidate / Authorized Representative:</strong>
        I acknowledge receipt of the Observations against the draft Nomination Form in Form 2B/Affidavit in Form 26.
        I understand my responsibility to rectify the discrepancies/ defects and resubmit the Forms within the time above
        for further checking. I understand that any delay will be on my account and the checking team will have no risk/
        liability in that regard.
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

    <div style="position: absolute; bottom: 40px;">
        <div style="width:200px; border-bottom:1px solid #000;"></div>
        <p style="font-size:11px; margin-top:5px;">Representative only</p>
    </div>

</body>

</html>
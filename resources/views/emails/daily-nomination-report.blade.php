<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Nomination Documents Processing Report</title>
</head>

<body style="margin:0;padding:0;background-color:#f4f6f9;font-family:Arial,Helvetica,sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f9;padding:30px 0;">
        <tr>
            <td align="center">

                <table width="650" cellpadding="0" cellspacing="0"
                    style="background:#ffffff;border-radius:6px;border:1px solid #e5e5e5;overflow:hidden;">

                    <!-- Header -->
                    <tr>
                        <td style="background:#1f4e79;color:#ffffff;padding:18px 25px;font-size:18px;font-weight:bold;">
                            Nomination Documents Processing Report
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:25px;color:#333;font-size:14px;line-height:1.6;">

                            <p>Dear Sir/Madam,</p>

                            <p>
                                Please find below the <strong>Nomination Documents Processing Report</strong> as on
                                <strong>{{ \Carbon\Carbon::parse($data['today'])->format('d M Y') }}</strong>.
                            </p>

                            <p style="margin-top:10px; color:#555;">
                                The detailed report is attached with this email.
                            </p>

                            @php
                            $grandTotal = 0;
                            $grandPending = 0;
                            $grandInappropriate = 0;
                            $grandCompleted = 0;
                            @endphp

                            {{-- Loop Phases --}}
                            @foreach($data['phaseArray'] as $phase)
                            @php
                            $grandTotal += $phase['total_records'];
                            $grandPending += $phase['pending_records'];
                            $grandInappropriate += $phase['inappropriate_records'];
                            $grandCompleted += $phase['completed_records'];
                            @endphp

                            <h4 style="margin-bottom:5px;">
                                {{ $phase['name'] }} ({{ $phase['assembly'] }} Seats)
                            </h4>

                            <table width="100%" cellpadding="8" cellspacing="0"
                                style="border-collapse:collapse;margin-bottom:20px;font-size:14px;">

                                <tr style="background:#f2f2f2;">
                                    <td style="border:1px solid #ddd;"><strong>Status</strong></td>
                                    <td style="border:1px solid #ddd;"><strong>Count</strong></td>
                                </tr>

                                <tr>
                                    <td style="border:1px solid #ddd;">Total Records</td>
                                    <td style="border:1px solid #ddd;">{{ $phase['total_records'] }}</td>
                                </tr>

                                <tr style="background:#f9f9f9;">
                                    <td style="border:1px solid #ddd;">Pending</td>
                                    <td style="border:1px solid #ddd;">{{ $phase['pending_records'] }}</td>
                                </tr>

                                <tr>
                                    <td style="border:1px solid #ddd;">Inappropriate Documents</td>
                                    <td style="border:1px solid #ddd;">{{ $phase['inappropriate_records'] }}</td>
                                </tr>

                                <tr style="background:#f9f9f9;">
                                    <td style="border:1px solid #ddd;">Completed</td>
                                    <td style="border:1px solid #ddd;">{{ $phase['completed_records'] }}</td>
                                </tr>

                            </table>
                            @endforeach

                            <!-- Overall Summary -->
                            <h4 style="margin-bottom:5px;">Overall Summary</h4>

                            <table width="100%" cellpadding="8" cellspacing="0"
                                style="border-collapse:collapse;margin-bottom:20px;font-size:14px;">

                                <tr style="background:#f2f2f2;">
                                    <td style="border:1px solid #ddd;"><strong>Status</strong></td>
                                    <td style="border:1px solid #ddd;"><strong>Count</strong></td>
                                </tr>

                                <tr>
                                    <td style="border:1px solid #ddd;">Total Records</td>
                                    <td style="border:1px solid #ddd;">{{ $grandTotal }}</td>
                                </tr>

                                <tr style="background:#f9f9f9;">
                                    <td style="border:1px solid #ddd;">Pending</td>
                                    <td style="border:1px solid #ddd;">{{ $grandPending }}</td>
                                </tr>

                                <tr>
                                    <td style="border:1px solid #ddd;">Inappropriate Documents</td>
                                    <td style="border:1px solid #ddd;">{{ $grandInappropriate }}</td>
                                </tr>

                                <tr style="background:#f9f9f9;">
                                    <td style="border:1px solid #ddd;">Completed</td>
                                    <td style="border:1px solid #ddd;">{{ $grandCompleted }}</td>
                                </tr>

                            </table>

                            <p>
                                Regards,<br>
                                <strong>Election Management System</strong>
                            </p>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#f5f5f5;padding:15px 25px;font-size:12px;color:#777;text-align:center;">
                            This is an automated system generated email. Please do not reply.
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
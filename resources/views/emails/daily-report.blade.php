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
                    <td style="padding:25px;color:#333333;font-size:14px;line-height:1.6;">

                        <p style="margin-top:0;">
                            Dear Sir/Madam,
                        </p>

                        <p>
                            Please find below the <strong>Nomination Documents Processing Report</strong> as on
                            <strong>{{ $data['date'] ?? now()->format('d M Y') }}</strong>.
                        </p>

                        <!-- Phase 1 -->
                        <h4 style="margin-bottom:5px;">Phase 1</h4>
                        <table width="100%" cellpadding="8" cellspacing="0"
                            style="border-collapse:collapse;margin-bottom:20px;font-size:14px;">
                            <tr style="background:#f2f2f2;">
                                <td style="border:1px solid #ddd;"><strong>Status</strong></td>
                                <td style="border:1px solid #ddd;"><strong>Count</strong></td>
                            </tr>
                            <tr>
                                <td style="border:1px solid #ddd;">Total Records</td>
                                <td style="border:1px solid #ddd;">{{ $data['phase1']['total'] ?? 150 }}</td>
                            </tr>
                            <tr style="background:#f9f9f9;">
                                <td style="border:1px solid #ddd;">Pending</td>
                                <td style="border:1px solid #ddd;">{{ $data['phase1']['pending'] ?? 35 }}</td>
                            </tr>
                            <tr>
                                <td style="border:1px solid #ddd;">Inadequate Documents</td>
                                <td style="border:1px solid #ddd;">{{ $data['phase1']['inappropriate'] ?? 12 }}</td>
                            </tr>
                            <tr style="background:#f9f9f9;">
                                <td style="border:1px solid #ddd;">Completed</td>
                                <td style="border:1px solid #ddd;">{{ $data['phase1']['completed'] ?? 103 }}</td>
                            </tr>
                        </table>

                        <!-- Phase 2 -->
                        <h4 style="margin-bottom:5px;">Phase 2</h4>
                        <table width="100%" cellpadding="8" cellspacing="0"
                            style="border-collapse:collapse;margin-bottom:20px;font-size:14px;">
                            <tr style="background:#f2f2f2;">
                                <td style="border:1px solid #ddd;"><strong>Status</strong></td>
                                <td style="border:1px solid #ddd;"><strong>Count</strong></td>
                            </tr>
                            <tr>
                                <td style="border:1px solid #ddd;">Total Records</td>
                                <td style="border:1px solid #ddd;">{{ $data['phase2']['total'] ?? 120 }}</td>
                            </tr>
                            <tr style="background:#f9f9f9;">
                                <td style="border:1px solid #ddd;">Pending</td>
                                <td style="border:1px solid #ddd;">{{ $data['phase2']['pending'] ?? 25 }}</td>
                            </tr>
                            <tr>
                                <td style="border:1px solid #ddd;">Inadequate Documents</td>
                                <td style="border:1px solid #ddd;">{{ $data['phase2']['inappropriate'] ?? 10 }}</td>
                            </tr>
                            <tr style="background:#f9f9f9;">
                                <td style="border:1px solid #ddd;">Completed</td>
                                <td style="border:1px solid #ddd;">{{ $data['phase2']['completed'] ?? 85 }}</td>
                            </tr>
                        </table>

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
                                <td style="border:1px solid #ddd;">{{ $data['overall']['total'] ?? 270 }}</td>
                            </tr>
                            <tr style="background:#f9f9f9;">
                                <td style="border:1px solid #ddd;">Pending</td>
                                <td style="border:1px solid #ddd;">{{ $data['overall']['pending'] ?? 60 }}</td>
                            </tr>
                            <tr>
                                <td style="border:1px solid #ddd;">Inadequate Documents</td>
                                <td style="border:1px solid #ddd;">{{ $data['overall']['inappropriate'] ?? 22 }}</td>
                            </tr>
                            <tr style="background:#f9f9f9;">
                                <td style="border:1px solid #ddd;">Completed</td>
                                <td style="border:1px solid #ddd;">{{ $data['overall']['completed'] ?? 188 }}</td>
                            </tr>
                        </table>

                        <p style="margin-bottom:0;">
                            Regards,<br>
                            <strong>Compliance Register System</strong>
                        </p>

                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td
                        style="background:#f5f5f5;padding:15px 25px;font-size:12px;color:#777777;text-align:center;">
                        This is an automated system generated email. Please do not reply to this email.
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>

</html>

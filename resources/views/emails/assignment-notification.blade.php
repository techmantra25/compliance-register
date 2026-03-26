<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Assembly Assignment for Vetting</title>
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
                            Nomination Document Vetting Assignment
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:25px;color:#333333;font-size:14px;line-height:1.6;">

                            <p style="margin-top:0;">Dear {{ $data['employee_name'] ?? 'User' }},</p>

                            <p>
                                You have been assigned to review and verify nomination documents for the following candidate
                                under the <strong>Compliance Register System</strong>.
                            </p>

                            <!-- Details Table -->
                            <table width="100%" cellpadding="10" cellspacing="0"
                                style="border-collapse:collapse;margin:20px 0;font-size:14px;">

                                <tr style="background:#f2f2f2;">
                                    <td style="border:1px solid #ddd;"><strong>Candidate Name</strong></td>
                                    <td style="border:1px solid #ddd;">
                                        {{ $data['candidate']->name ?? 'N/A' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="border:1px solid #ddd;"><strong>Assembly (AC)</strong></td>
                                    <td style="border:1px solid #ddd;">
                                        {{ $data['ac'] ?? 'N/A' }}
                                    </td>
                                </tr>

                                <tr style="background:#f2f2f2;">
                                    <td style="border:1px solid #ddd;"><strong>Nomination Date</strong></td>
                                    <td style="border:1px solid #ddd;">
                                        {{ $data['nominationDate'] ?? 'N/A' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="border:1px solid #ddd;"><strong>Election Date</strong></td>
                                    <td style="border:1px solid #ddd;">
                                        {{ $data['electionDate'] ?? 'N/A' }}
                                    </td>
                                </tr>

                                <tr style="background:#f2f2f2;">
                                    <td style="border:1px solid #ddd;"><strong>Status</strong></td>
                                    <td style="border:1px solid #ddd;color:#1f4e79;font-weight:bold;">
                                        Assigned for Vetting
                                    </td>
                                </tr>

                            </table>

                            <p>
                                Kindly log in to the system and complete the vetting process within the required timeline.
                            </p>

                            <!-- Button -->
                            <table cellpadding="0" cellspacing="0" style="margin:25px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $data['link'] }}"
                                            style="background:#1f4e79;color:#ffffff;padding:12px 22px;text-decoration:none;font-size:14px;border-radius:4px;display:inline-block;">
                                            View & Start Vetting
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p>
                                If any discrepancies are found, please update your remarks in the system accordingly.
                            </p>

                            <p>
                                Thank you for your cooperation.
                            </p>

                            <p style="margin-bottom:0;">
                                Regards,<br>
                                <strong>Election Management System</strong>
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
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Nomination Document Vetting Request</title>
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
                            Election Candidate Nomination Document Vetting
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:25px;color:#333333;font-size:14px;line-height:1.6;">

                            <p style="margin-top:0;">Dear <strong>Legal Team</strong>,</p>

                            <p>
                                All required documents for the below candidate have been uploaded and are now
                                <strong>"Ready for Vetting"</strong>
                            </p>

                            <table width="100%" cellpadding="8" cellspacing="0"
                                style="border-collapse:collapse;margin:20px 0;font-size:14px;">

                                <tr style="background:#f2f2f2;">
                                    <td style="border:1px solid #ddd;"><strong>Candidate Name</strong></td>
                                    <td style="border:1px solid #ddd;">
                                        {{ $data['candidate']->name ?? 'N/A' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="border:1px solid #ddd;"><strong>Assembly Constituency (AC)</strong></td>
                                    <td style="border:1px solid #ddd;">
                                        {{ $data['ac'] }}
                                    </td>
                                </tr>

                                <tr style="background:#f2f2f2;">
                                    <td style="border:1px solid #ddd;"><strong>Nomination Date</strong></td>
                                    <td style="border:1px solid #ddd;">
                                        {{ $data['nominationDate'] }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="border:1px solid #ddd;"><strong>Election Date</strong></td>
                                    <td style="border:1px solid #ddd;">
                                        {{ $data['electionDate'] }}
                                    </td>
                                </tr>

                            </table>

                            <p>
                                Kindly review the submitted documents and complete the vetting process <strong>as soon as possible</strong> so that the nomination process can proceed without delay.
                            </p>

                            <!-- Button -->
                            <table cellpadding="0" cellspacing="0" style="margin:25px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $data['link'] }}"
                                            style="background:#1f4e79;color:#ffffff;padding:12px 22px;text-decoration:none;font-size:14px;border-radius:4px;display:inline-block;">
                                            View Nomination Documents
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p>
                                If any discrepancies or additional requirements are identified, kindly update your remarks in the system.
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
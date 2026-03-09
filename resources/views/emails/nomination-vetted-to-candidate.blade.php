<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Nomination Documents Vetted</title>
</head>

<body style="margin:0;padding:0;background-color:#f4f6f9;font-family:Arial,Helvetica,sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f9;padding:30px 0;">
        <tr>
            <td align="center">

                <table width="650" cellpadding="0" cellspacing="0"
                    style="background:#ffffff;border-radius:6px;border:1px solid #e5e5e5;overflow:hidden;">

                    <tr>
                        <td style="background:#1f4e79;color:#ffffff;padding:18px 25px;font-size:18px;font-weight:bold;">
                            Candidate Nomination Document Update
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:25px;color:#333333;font-size:14px;line-height:1.6;">

                            <p style="margin-top:0;">
                                Dear <strong>{{ $data['candidate']->name ?? 'Candidate' }}</strong>,
                            </p>

                            <p>
                                We are pleased to inform you that your <strong>nomination documents have been
                                    successfully vetted</strong>.
                            </p>

                            <p>
                                Below are the important details regarding your nomination:
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
                                    <td style="border:1px solid #ddd;"><strong>Last Date of Nomination</strong></td>
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
                                Please make sure to complete all remaining nomination procedures within the prescribed
                                timeline.
                            </p>

                            <p>
                                If you require any assistance, please contact the election coordination team.
                            </p>

                            <p>
                                We wish you the very best for the upcoming election process.
                            </p>

                            <p style="margin-bottom:0;">
                                Regards,<br>
                                <strong>Election Management System</strong>
                            </p>

                        </td>
                    </tr>

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
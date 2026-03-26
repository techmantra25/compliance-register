<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Vetting Request</title>
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
                            Vetting Request – Compliance Register System
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:25px;color:#333333;font-size:14px;line-height:1.6;">

                            <p style="margin-top:0;">
                                Dear <strong>{{ $admin->name }}</strong>,
                            </p>

                            <p>
                                A candidate has been assigned to you for vetting in the 
                                <strong>Compliance Register System</strong>.
                            </p>

                            <!-- Candidate Info Table -->
                            <table width="100%" cellpadding="8" cellspacing="0"
                                style="border-collapse:collapse;margin:20px 0;font-size:14px;">

                                <tr style="background:#f2f2f2;">
                                    <td style="border:1px solid #ddd;"><strong>Candidate Name</strong></td>
                                    <td style="border:1px solid #ddd;">{{ $candidate->name }}</td>
                                </tr>

                                <tr>
                                    <td style="border:1px solid #ddd;"><strong>Assembly</strong></td>
                                    <td style="border:1px solid #ddd;">
                                        {{ optional($candidate->assembly)->assembly_name_en }}
                                    </td>
                                </tr>

                            </table>

                            <p>
                                Kindly review the candidate documents and proceed with the vetting process.
                            </p>

                            <!-- Button -->

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
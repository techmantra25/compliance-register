<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Password Reset OTP</title>
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
                            Password Reset Request
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:25px;color:#333333;font-size:14px;line-height:1.6;">

                            <p style="margin-top:0;">Hello,</p>

                            <p>
                                We received a request to reset your password for the
                                <strong>Compliance Register System</strong>.
                            </p>

                            <p>
                                Please use the following <strong>One-Time Password (OTP)</strong> to reset your password.
                            </p>

                            <!-- OTP BOX -->
                            <table width="100%" cellpadding="10" cellspacing="0"
                                style="border-collapse:collapse;margin:20px 0;font-size:16px;text-align:center;">

                                <tr style="background:#f2f2f2;">
                                    <td style="border:1px solid #ddd;font-size:26px;font-weight:bold;color:#1f4e79;letter-spacing:5px;">
                                        {{ $otp }}
                                    </td>
                                </tr>

                            </table>

                            <p>
                                This OTP will remain valid for <strong>5 minutes</strong>.
                            </p>

                            <p>
                                If you did not request a password reset, please ignore this email. Your account will remain secure.
                            </p>

                            <p>
                                Thank you.
                            </p>

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
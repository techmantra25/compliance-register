<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Employee Login Credentials</title>
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
                            Account Created – Compliance Register System
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:25px;color:#333333;font-size:14px;line-height:1.6;">

                            <p>Dear <strong>{{ $admin->name }}</strong>,</p>

                            <p>
                                Your account has been successfully created in the
                                <strong>Compliance Register System</strong>.
                            </p>

                            <table width="100%" cellpadding="8" cellspacing="0"
                                style="border-collapse:collapse;margin:20px 0;font-size:14px;">

                                <tr style="background:#f2f2f2;">
                                    <td style="border:1px solid #ddd;"><strong>Name</strong></td>
                                    <td style="border:1px solid #ddd;">{{ $admin->name }}</td>
                                </tr>

                                <tr>
                                    <td style="border:1px solid #ddd;"><strong>Email</strong></td>
                                    <td style="border:1px solid #ddd;">{{ $admin->email }}</td>
                                </tr>

                                <tr style="background:#f2f2f2;">
                                    <td style="border:1px solid #ddd;"><strong>Password</strong></td>
                                    <td style="border:1px solid #ddd;">{{ $password }}</td>
                                </tr>

                            </table>

                            <p>
                                Please use the above credentials to log in to the system.
                                For security reasons, it is recommended to change your password after first login.
                            </p>

                            <table cellpadding="0" cellspacing="0" style="margin:25px 0;">
                                <tr>
                                    <td align="center">
                                        {{-- <a href="{{ url('/') }}" --}}
                                         <a href="https://foxandmandalconsulting.com/login"
                                            style="background:#1f4e79;color:#ffffff;padding:12px 22px;text-decoration:none;font-size:14px;border-radius:4px;display:inline-block;">
                                            Login to System
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p>
                                If you did not expect this email, please contact the administrator.
                            </p>

                            <p>
                                Regards,<br>
                                <strong>Compliance Register System​</strong>
                            </p>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td
                            style="background:#f5f5f5;padding:15px 25px;font-size:12px;color:#777777;text-align:center;">
                            This is an automated system generated email. Please do not reply.
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
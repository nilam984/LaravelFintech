<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Welcome</title>
</head>

<body style="margin:0; padding:0; background-color:#f1f5f9; font-family:Arial, Helvetica, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" border="0"
        style="background-color:#f1f5f9; padding:40px 15px;">

        <tr>
            <td align="center">

                <table width="600" cellpadding="0" cellspacing="0" border="0"
                    style="max-width:600px; width:100%; background:#ffffff; border-radius:12px; overflow:hidden;">

                    {{-- Header --}}
                    <tr>
                        <td style="background:#0891b2; padding:25px 30px; text-align:center;">

                            <h1 style="margin:0; color:#ffffff; font-size:24px;">
                                Welcome to {{ config('app.name') }}
                            </h1>

                        </td>
                    </tr>

                    {{-- Content --}}
                    <tr>
                        <td style="padding:35px 30px;">

                            <h2 style="margin-top:0; color:#1e293b; font-size:22px;">
                                Hello {{ $user->name }},
                            </h2>

                            <p style="color:#475569; font-size:15px; line-height:1.7;">
                                Your reseller account has been successfully created by our administration team.
                            </p>

                            <p style="color:#475569; font-size:15px; line-height:1.7;">
                                You can use the following credentials to log in to your reseller account.
                            </p>

                            {{-- Credentials --}}
                            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                                style="margin:25px 0; border:1px solid #e2e8f0; border-radius:8px;">

                                <tr>
                                    <td
                                        style="padding:15px; background:#f8fafc; color:#475569; font-size:14px; width:35%;">
                                        Email
                                    </td>

                                    <td style="padding:15px; color:#0f172a; font-size:14px; font-weight:bold;">
                                        {{ $user->email }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding:15px; background:#f8fafc; color:#475569; font-size:14px;">
                                        Password
                                    </td>

                                    <td style="padding:15px; color:#0f172a; font-size:14px; font-weight:bold;">
                                        {{ $password }}
                                    </td>
                                </tr>

                            </table>

                            {{-- Login Button --}}
                            <div style="text-align:center; margin:30px 0;">

                                <a href="{{ url('/login') }}"
                                    style="display:inline-block; background:#0891b2; color:#ffffff; text-decoration:none; padding:12px 25px; border-radius:8px; font-size:14px; font-weight:bold;">
                                    Login to Your Account
                                </a>

                            </div>

                            <p style="color:#64748b; font-size:13px; line-height:1.6;">
                                For security reasons, please change your password after your first login.
                            </p>

                            <p style="color:#475569; font-size:14px; line-height:1.6; margin-bottom:0;">
                                Regards,<br>
                                <strong>{{ config('app.name') }} Team</strong>
                            </p>

                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="background:#f8fafc; padding:20px 30px; text-align:center;">

                            <p style="margin:0; color:#94a3b8; font-size:12px;">
                                © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                            </p>

                        </td>
                    </tr>

                </table>

            </td>
        </tr>

    </table>

</body>

</html>

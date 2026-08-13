<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">

    <title>Onboarding Initiated</title>
</head>

<body style="margin:0; padding:0; background:#f8fafc; font-family:Arial, sans-serif;">

    <div
        style="max-width:600px; margin:30px auto; background:#ffffff; border:1px solid #e2e8f0; border-radius:12px; overflow:hidden;">

        <div style="padding:25px; text-align:center; background:#ecfeff;">

            <h2 style="margin:0; color:#0f172a;">
                Onboarding Initiated
            </h2>

            <p style="margin:8px 0 0; color:#64748b; font-size:14px;">
                Welcome to Fintech App
            </p>

        </div>

        <div style="padding:30px;">

            <p style="color:#334155; font-size:15px;">
                Hello <strong>{{ $order->name }}</strong>,
            </p>

            <p style="color:#475569; font-size:14px; line-height:1.6;">
                Your onboarding request has been successfully initiated on our platform.
                Your payment has been received successfully and your account setup is now being processed.
            </p>

            <div style="margin-top:25px; border:1px solid #e2e8f0; border-radius:8px; padding:18px;">

                <p style="margin:0 0 12px; font-size:14px; color:#0f172a;">
                    <strong>Onboarding Details</strong>
                </p>


                <p style="margin:8px 0; font-size:13px; color:#64748b;">
                    Login Email:
                    <strong style="color:#0f172a;">
                        {{ $order->email }}
                    </strong>
                </p>
                <p style="margin:8px 0; font-size:13px; color:#64748b;">
                    Login Password:
                    <strong style="color:#0f172a;">
                        {{ substr($order->mobile, 2, 6) }}
                    </strong>
                </p>
                <p style="margin:8px 0; font-size:13px; color:#64748b;">
                    Merchant Transaction ID:
                    <strong style="color:#0f172a;">
                        {{ $order->gateway_order_id }}
                    </strong>
                </p>
                <p style="margin:8px 0; font-size:13px; color:#64748b;">
                    Gateway Transaction ID:
                    <strong style="color:#0f172a;">
                        {{ $order->gateway_payment_id }}
                    </strong>
                </p>

                <p style="margin:8px 0; font-size:13px; color:#64748b;">
                    Amount Paid:
                    <strong style="color:#0f172a;">
                        ₹{{ number_format((float) $order->total_amount, 2) }}
                    </strong>
                </p>

                <p style="margin:8px 0; font-size:13px; color:#64748b;">
                    Status:
                    <strong style="color:#16a34a;">
                        Payment Successful
                    </strong>
                </p>

            </div>

            <p style="margin-top:25px; color:#475569; font-size:14px; line-height:1.6;">
                We will continue processing your onboarding. You will receive further
                communication once your account setup is completed.
            </p>

            <p style="margin-top:25px; color:#334155; font-size:14px;">
                Thank you for choosing our platform.
            </p>

        </div>

        <div style="padding:18px; text-align:center; background:#f8fafc; border-top:1px solid #e2e8f0;">

            <p style="margin:0; color:#94a3b8; font-size:12px;">
                This is an automated email. Please do not reply to this email.
            </p>

        </div>

    </div>

</body>

</html>

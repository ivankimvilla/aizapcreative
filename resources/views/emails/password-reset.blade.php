<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset your password</title>
</head>
<body style="margin:0; padding:32px 16px; background:#f3f3f1; font-family:Arial, Helvetica, sans-serif; color:#111827;">
    <div style="max-width:640px; margin:0 auto; background:#ffffff; border:1px solid #e5e7eb; border-radius:18px; overflow:hidden; box-shadow:0 18px 42px rgba(17, 24, 39, 0.08);">
        <div style="background:#0b0b0b; padding:30px 24px 24px; text-align:center;">
            <img src="{{ asset('logo.png') }}" alt="Aizap Creatives" style="display:block; margin:0 auto 12px; width:160px; max-width:100%; height:auto;">
            <div style="font-size:12px; letter-spacing:3px; color:#facc15; font-weight:700; text-transform:uppercase;">Aizap Creatives</div>
        </div>

        <div style="padding:34px 32px 28px; background:#ffffff;">
            <h1 style="margin:0 0 18px; font-size:34px; line-height:1.15; color:#111827; font-weight:800;">Hello!</h1>

            <p style="margin:0 0 18px; font-size:17px; line-height:1.8; color:#374151;">
                You are receiving this email because we received a password reset request for your account.
            </p>

            <div style="margin:20px 0 24px; text-align:center;">
                <a href="{{ $resetUrl }}" style="display:inline-block; background:#111827; color:#ffffff; font-size:16px; font-weight:700; text-decoration:none; padding:16px 28px; border-radius:12px;">Reset Password</a>
            </div>

            <p style="margin:0 0 12px; font-size:16px; line-height:1.8; color:#374151;">
                This password reset link will expire in 10 minutes.
            </p>

            <p style="margin:0 0 18px; font-size:16px; line-height:1.8; color:#374151;">
                If you did not request a password reset, no further action is required.
            </p>

            <p style="margin:0 0 6px; font-size:16px; line-height:1.8; color:#374151;">Regards,</p>
            <p style="margin:0; font-size:16px; line-height:1.8; color:#111827; font-weight:700;">Aizap Creatives</p>

            <div style="margin-top:28px; border-top:1px solid #e5e7eb; padding-top:18px;">
                <p style="margin:0; font-size:13px; line-height:1.7; color:#6b7280;">
                    If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your browser:<br>
                    <span style="word-break:break-all; color:#2563eb;">{{ $resetUrl }}</span>
                </p>
            </div>
        </div>

        <div style="background:#f9fafb; border-top:1px solid #e5e7eb; text-align:center; padding:18px 16px; font-size:12px; color:#6b7280;">
            © 2026 Aizap Creatives. All rights reserved.
        </div>
    </div>
</body>
</html>

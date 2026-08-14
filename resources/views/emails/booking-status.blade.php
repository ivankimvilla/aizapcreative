<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Update</title>
</head>
<body style="margin:0; padding:32px 16px; background:#f3f4f6; font-family:Arial, Helvetica, sans-serif; color:#111827;">
    <div style="max-width:680px; margin:0 auto; background:#ffffff; border:1px solid #e5e7eb; border-radius:22px; overflow:hidden; box-shadow:0 18px 40px rgba(15, 23, 42, 0.08);">
        <div style="background:linear-gradient(135deg, #0f172a 0%, #1f2937 100%); padding:26px 30px; text-align:center;">
            <img src="{{ asset('logo.png') }}" alt="Aizap Creatives" style="display:block; margin:0 auto 12px; width:160px; max-width:100%; height:auto;">
            <div style="font-size:12px; letter-spacing:2.5px; color:#f8fafc; text-transform:uppercase; font-weight:700;">Aizap Creatives</div>
        </div>

        <div style="padding:34px 30px 28px;">
            <p style="margin:0 0 12px; font-size:12px; letter-spacing:0.16em; text-transform:uppercase; color:#6b7280; font-weight:700;">
                Booking update
            </p>

            <h2 style="margin:0 0 18px; font-size:32px; line-height:1.2; color:#111827; font-weight:700;">
                Your booking is {{ ucfirst($status) }}
            </h2>

            <p style="margin:0 0 18px; font-size:16px; line-height:1.8; color:#374151;">
                Hi {{ $booking->name }},
            </p>

            <p style="margin:0 0 18px; font-size:16px; line-height:1.8; color:#374151;">
                Your booking request for <strong>{{ $booking->service }}</strong> has been <strong>{{ ucfirst($status) }}</strong>.
            </p>

            @if($status === 'confirmed')
                <p style="margin:0 0 20px; font-size:16px; line-height:1.8; color:#374151;">
                    We’ve reserved your selected time slot and we’re ready to move forward with the next steps for your project.
                </p>
            @elseif($status === 'completed')
                <p style="margin:0 0 20px; font-size:16px; line-height:1.8; color:#374151;">
                    Your booking has been completed. Thank you for trusting Aizap Creatives with your project.
                </p>
            @endif

            <div style="margin:0 0 20px; background:#f8fafc; border:1px solid #e5e7eb; border-radius:14px; padding:18px 20px;">
                <div style="font-size:12px; color:#6b7280; font-weight:700; letter-spacing:0.12em; text-transform:uppercase; margin:0 0 8px;">Scheduled time</div>
                <div style="font-size:18px; color:#111827; font-weight:700; line-height:1.5;">
                    {{ $booking->starts_at?->format('F j, Y g:i A') ?? 'Not available' }}
                </div>
            </div>

            @if($booking->meeting_link)
                <div style="margin:0 0 24px;">
                    <a href="{{ $booking->meeting_link }}" style="display:inline-block; background:#facc15; color:#111827; text-decoration:none; font-weight:700; padding:14px 22px; border-radius:999px; font-size:15px;">
                        Open meeting link
                    </a>
                </div>
            @endif

            <p style="margin:0; font-size:16px; line-height:1.8; color:#374151;">
                Thank you for working with us,<br>
                <strong style="color:#111827;">Aizap Creatives</strong>
            </p>
        </div>

        <div style="background:#f8fafc; border-top:1px solid #e5e7eb; padding:18px 30px; text-align:center; font-size:13px; color:#6b7280;">
            Aizap Creatives • Creative Strategy & AI Video Production
        </div>
    </div>
</body>
</html>

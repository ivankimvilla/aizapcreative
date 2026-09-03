<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Contact Message</title>
  </head>
  <body style="margin:0; background:#f3f3f3; font-family:Arial, Helvetica, sans-serif; color:#111111; line-height:1.7;">
    @php
        $logoPath = public_path('logo.png');
    @endphp

    <div style="max-width:680px; margin:24px auto; background:#ffffff; border:1px solid #e8e8e8; border-radius:12px; overflow:hidden;">
      <div style="background:#0b0b0b; padding:20px 24px; text-align:center;">
        @if (file_exists($logoPath))
          <img src="{{ $message->embed($logoPath) }}" alt="Aizap Creatives" width="180" style="max-width:100%; height:auto; display:block; margin:0 auto; border:0; outline:none;">
        @else
          <img src="{{ asset('logo.png') }}" alt="Aizap Creatives" width="180" style="max-width:100%; height:auto; display:block; margin:0 auto; border:0; outline:none;">
        @endif
      </div>

      <div style="padding:28px 32px 36px;">
        <div style="font-size:12px; letter-spacing:2px; text-transform:uppercase; color:#666666; margin-bottom:12px; font-weight:700;">AIZAP CREATIVES</div>
        <h1 style="margin:0 0 16px; font-size:28px; line-height:1.25; color:#111111;">New Contact Message</h1>
        <p style="margin:0 0 16px; font-size:16px; line-height:1.6; color:#111111;">
          A new message came in through the contact form.
        </p>

        <table style="width:100%; border-collapse:collapse; font-size:14px; line-height:1.7;">
          <tr>
            <td style="padding:8px 0; font-weight:700; width:140px; color:#111111;">Name</td>
            <td style="padding:8px 0; color:#333333;">{{ $messageData['name'] }}</td>
          </tr>
          <tr>
            <td style="padding:8px 0; font-weight:700; color:#111111;">Email</td>
            <td style="padding:8px 0; color:#333333;">{{ $messageData['email'] }}</td>
          </tr>
          <tr>
            <td style="padding:8px 0; font-weight:700; color:#111111;">Phone</td>
            <td style="padding:8px 0; color:#333333;">{{ $messageData['phone'] ?? 'N/A' }}</td>
          </tr>
          <tr>
            <td style="padding:8px 0; font-weight:700; color:#111111;">Subject</td>
            <td style="padding:8px 0; color:#333333;">{{ $messageData['subject'] ?? 'N/A' }}</td>
          </tr>
        </table>

        <div style="margin-top:20px; background:#f5f5f5; padding:16px; border-radius:10px; border:1px solid #e9e9e9;">
          <div style="font-size:12px; letter-spacing:1.2px; text-transform:uppercase; color:#555555; margin-bottom:6px; font-weight:700;">Message</div>
          <div style="white-space:pre-wrap; color:#222222; line-height:1.7;">{{ $messageData['message'] }}</div>
        </div>

        <div style="margin-top:24px; text-align:center;">
          <a href="{{ route('admin.messages') }}" style="display:inline-block; background:#111111; color:#ffffff; text-decoration:none; padding:12px 22px; border-radius:6px; font-weight:700;">View messages</a>
        </div>
      </div>
    </div>
  </body>
</html>

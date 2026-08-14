<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ $subject ?? 'Aizap Creatives' }}</title>
  </head>
  <body style="margin:0; background:#f5f5f5; font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; color:#111111; line-height:1.7;">
    <div style="max-width:620px; margin:0 auto; background:#ffffff; padding:0;">
      @php
        $logoPath = public_path('logo.png');
      @endphp

      <div style="background:#000000; padding:18px 20px 14px; margin:0 0 20px 0; text-align:center; border-radius:0;">
        @if (file_exists($logoPath))
          <img src="{{ $message->embed($logoPath) }}" alt="Aizap Creatives" width="180" style="max-width:100%; height:auto; display:block; margin:0 auto; border:0; outline:none;">
        @else
          <img src="https://aizapcreative.com/logo.png" alt="Aizap Creatives" width="180" style="max-width:100%; height:auto; display:block; margin:0 auto; border:0; outline:none;">
        @endif
      </div>

      @if (($isQuoteRequest ?? false))
        <h2 style="margin:0 0 16px 0; font-size:28px; line-height:1.25; color:#111111;">
          We've Received Your Quote Request
        </h2>

        <div style="font-size:16px; color:#111111; padding:0 0 18px 0;">
          <p style="margin:0 0 18px 0;">
            Dear <strong style="color:#111111;">{{ $recipientName ?? 'there' }}</strong>,
          </p>

          <p style="margin:0 0 16px 0; color:#111111;">
            Thank you for contacting <strong style="color:#111111;">Aizap Creatives</strong>.
          </p>

          <p style="margin:0 0 16px 0; color:#111111;">
            We've successfully received your quote request and truly appreciate the opportunity to learn more about your project.
          </p>

          <p style="margin:0 0 16px 0; color:#111111;">
            Our team is now reviewing the details you submitted. You can expect a response within <strong style="color:#111111;">1 business day</strong>, including the next steps and any information needed to move forward.
          </p>

          <p style="margin:0 0 16px 0; color:#111111;">
            If you'd like to add more details or send supporting files, simply reply to this email-we'll be happy to assist you.
          </p>

          <p style="margin:0 0 16px 0; color:#111111;">
            Thank you for choosing <strong style="color:#111111;">Aizap Creatives</strong>. We look forward to working with you.
          </p>

          <p style="margin:0 0 8px 0; color:#111111;">Warm regards,</p>
          <p style="margin:0 0 0 0; font-weight:700; color:#111111;">Aizap Creatives</p>
          <p style="margin:0;">
            <a href="https://aizapcreative.com" style="color:#111111; text-decoration:none;">https://aizapcreative.com</a>
          </p>
        </div>
      @else
        <h2 style="margin:0 0 16px 0; font-size:28px; line-height:1.25; color:#111111;">
          We've Received Your Message
        </h2>

        <div style="font-size:16px; color:#111111; padding:0 0 18px 0;">
          <p style="margin:0 0 18px 0;">
            Dear <strong style="color:#111111;">{{ $recipientName ?? 'there' }}</strong>,
          </p>

          <p style="margin:0 0 16px 0; color:#111111;">
            Thank you for contacting <strong style="color:#111111;">Aizap Creatives</strong>.
          </p>

          <p style="margin:0 0 16px 0; color:#111111;">
            We have successfully received your message and appreciate the opportunity to learn more about your project and goals.
          </p>

          <p style="margin:0 0 16px 0; color:#111111;">
            Our team is currently reviewing your message, and we will get back to you with the next steps as soon as possible. You can expect a response within <strong style="color:#111111;">1 business day</strong>.
          </p>

          <p style="margin:0 0 16px 0; color:#111111;">
            If you have any additional information or supporting files to share, simply reply to this email-we'll be happy to assist you.
          </p>

          <p style="margin:0 0 16px 0; color:#111111;">
            Thank you for choosing Aizap Creatives. We look forward to working with you.
          </p>

          <p style="margin:0 0 8px 0; color:#111111;">Warm regards,</p>
          <p style="margin:0 0 0 0; font-weight:700; color:#111111;">Aizap Creatives</p>
          <p style="margin:0;">
            <a href="https://aizapcreative.com" style="color:#111111; text-decoration:none;">https://aizapcreative.com</a>
          </p>
        </div>
      @endif
    </div>
  </body>
</html>

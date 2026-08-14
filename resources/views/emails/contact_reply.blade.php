<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ $subject ?? 'Aizap Creatives' }}</title>
  </head>
  <body style="font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; color: #111;">
    @php
      $logoPath = public_path('logo.png');
    @endphp

    @if (file_exists($logoPath))
      <p style="margin:0 0 12px 0;">
        <img src="{{ $message->embed($logoPath) }}" alt="Aizap Creatives" style="max-width:240px;height:auto;display:block;">
      </p>
    @else
      <p style="margin:0 0 12px 0;">
        <img src="https://aizapcreative.com/logo.png" alt="Aizap Creatives" style="max-width:240px;height:auto;display:block;">
      </p>
    @endif

    <p style="margin:0 0 12px 0;">Hi {{ $recipientName ?? 'there' }},</p>

    <div style="margin-bottom:12px;">{!! nl2br(e($bodyText)) !!}</div>

    <p style="margin:0 0 6px 0;">Warm regards,</p>
    <p style="margin:0 0 2px 0;">Aizap Creatives</p>
    <p style="margin:0;"><a href="https://aizapcreative.com">https://aizapcreative.com</a></p>
  </body>
</html>

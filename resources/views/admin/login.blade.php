<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>AIZAP Creatives — Sign in</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Manrope:wght@400;500;600;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/admin/login.css') }}">
</head>
<body>

<div class="screen">

  <!-- LEFT: BRAND PANEL -->
  <div class="brand-panel">
    <div class="brand-top">
      <div class="wordmark">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <path d="M13.2 1L4 13.4H10.6L9.4 23L20 9.6H13.4L13.2 1Z" fill="#FFD400"/>
        </svg>
        <span>AIZ<em>AP</em> CREATIVES</span>
      </div>
    </div>

    <div class="brand-mid">
      <h1 class="headline">Where ideas <span class="accent">strike</span> first.</h1>
      <svg class="spark-rule" viewBox="0 0 220 26" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <path d="M2 20 L60 20 L72 4 L84 24 L96 10 L108 20 L218 20"/>
      </svg>
      <p class="sub">Sign in to your studio workspace — briefs, boards, and campaigns, all in one current.</p>
    </div>

    <div class="brand-bottom">
      <span>Est. Davao · Aizap Creative Studio</span>
      <span class="tag">All systems live</span>
    </div>
  </div>

  <!-- SEAM: signature jagged lightning divider -->
  <div class="seam" aria-hidden="true">
    <svg viewBox="0 0 18 800" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M9 0 L4 60 L14 130 L2 210 L16 280 L3 350 L15 420 L4 490 L14 560 L2 630 L16 700 L6 760 L9 800" />
    </svg>
  </div>

  <!-- RIGHT: FORM PANEL -->
  <div class="form-panel">
    <div class="form-wrap">
      <p class="form-eyebrow">Welcome back</p>
      <h2 class="form-title">Sign in</h2>
      <p class="form-desc">Enter your details to access your projects and client boards.</p>

      <form action="#" method="post">
        <div class="field">
          <label for="email">Email address</label>
          <input id="email" type="email" placeholder="you@studio.com" autocomplete="email">
        </div>

        <div class="field">
          <label for="password">Password</label>
          <div class="password-wrap">
            <input id="password" type="password" placeholder="Password" autocomplete="current-password">
            <button type="button" class="toggle-password" aria-label="Show password" aria-pressed="false">
              <svg class="icon-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M1.5 12S5 5 12 5s10.5 7 10.5 7-3.5 7-10.5 7S1.5 12 1.5 12Z"/>
                <circle cx="12" cy="12" r="3.2"/>
              </svg>
              <svg class="icon-eye-off" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 3l18 18"/>
                <path d="M10.6 5.2A10.9 10.9 0 0 1 12 5c7 0 10.5 7 10.5 7a13.3 13.3 0 0 1-3.1 3.9M6.6 6.6C3.8 8.4 1.5 12 1.5 12s3.5 7 10.5 7c1.5 0 2.8-.3 3.9-.8"/>
                <path d="M9.9 9.9a3.2 3.2 0 0 0 4.2 4.2"/>
              </svg>
            </button>
          </div>
        </div>

        <div class="row-between">
          <label class="remember">
            <input type="checkbox">
            Remember me
          </label>
          <a href="{{ route('admin.reset-password') }}">Forgot password?</a>
        </div>

        <button class="btn-primary" type="submit">
          Sign in
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
        </button>
      </form>

    </div>
  </div>

</div>
<script src="{{ asset('js/admin/login.js') }}"></script>
</body>
</html>
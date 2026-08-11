<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Aizap Creatives - Reset password</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Manrope:wght@400;500;600;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/admin/reset-password.css') }}">
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
            <h1 class="headline">Every studio <span class="accent">forgets</span> sometimes.</h1>
            <svg class="spark-rule" viewBox="0 0 220 26" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M2 20 L60 20 L72 4 L84 24 L96 10 L108 20 L218 20"/>
            </svg>
            <p class="sub">We'll send a reset link to your inbox so you're back to your boards in no time.</p>
        </div>

        <div class="brand-bottom">
            <span>Est. Davao · Creative Studio</span>
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
            <p class="form-eyebrow">Account recovery</p>
            <h2 class="form-title">Reset password</h2>
            <p class="form-desc">Enter your email address and we'll guide you through the next step for your admin account.</p>

            @if(session('status'))
                <div class="form-status">{{ session('status') }}</div>
            @endif

            @if(session('reset_link'))
                <div class="form-status" style="margin-top: 12px;">
                    <p style="margin-bottom: 8px;">Use this reset link for now:</p>
                    <a href="{{ session('reset_link') }}" style="word-break: break-all;">{{ session('reset_link') }}</a>
                </div>
            @endif

            @if($errors->any())
                <div class="form-errors">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.password.email') }}">
                @csrf
                <div class="field">
                    <label for="email">Email address</label>
                    <input id="email" name="email" type="email" placeholder="you@studio.com" autocomplete="email" required>
                </div>

                <button class="btn-primary" type="submit">
                    Send reset link
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </button>
            </form>

            <a class="back" href="{{ route('admin.login') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M11 6l-6 6 6 6"/></svg>
                Back to sign in
            </a>
        </div>
    </div>

</div>


</html>

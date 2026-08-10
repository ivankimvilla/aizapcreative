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
            <p class="sub">Enter your email and the link you'll receive will let you reset your admin password.</p>
        </div>
    </div>

    <div class="seam" aria-hidden="true">
        <svg viewBox="0 0 18 800" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M9 0 L4 60 L14 130 L2 210 L16 280 L3 350 L15 420 L4 490 L14 560 L2 630 L16 700 L6 760 L9 800" />
        </svg>
    </div>

    <div class="form-panel">
        <div class="form-wrap">
            <p class="form-eyebrow">Account recovery</p>
            <h2 class="form-title">Reset password</h2>

            @if(session('status'))
                <div class="form-status">{{ session('status') }}</div>
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

            <form method="POST" action="{{ route('admin.password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="field">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" value="{{ $email ?? old('email') }}" placeholder="you@studio.com" required>
                    @error('email') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <div class="field">
                    <label for="password">New password</label>
                    <input id="password" name="password" type="password" placeholder="At least 8 characters" required>
                    @error('password') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <div class="field">
                    <label for="password_confirmation">Confirm password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required>
                    @error('password_confirmation') <div class="field-error">{{ $message }}</div> @enderror
                </div>

                <button class="btn-primary" type="submit">Reset password</button>
            </form>

            <a class="back" href="{{ route('admin.login') }}">Back to sign in</a>
        </div>
    </div>

    </body>
    </html>

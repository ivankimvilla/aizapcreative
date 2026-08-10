<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aizap Creatives - Change password</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Manrope:wght@400;500;600;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/change-password.css') }}">
</head>
<body>
  <div class="shell">
    @include('admin.sidebar.sidebar')

    <div class="seam" aria-hidden="true">
      <svg viewBox="0 0 10 800" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M5 0 L2 60 L8 130 L1 210 L9 280 L2 350 L8 420 L2 490 L8 560 L1 630 L9 700 L3 760 L5 800" />
      </svg>
    </div>

    <main class="main">
      <div class="card">

        <div class="card-header">
            <div class="icon-ring">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     aria-hidden="true">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
            </div>
            <p class="eyebrow">Security</p>
            <h2 class="title">Change password</h2>
            <p class="desc">Create a new password for your admin account. This screen is UI-only for now.</p>
        </div>

        <div class="divider"></div>

        <form method="POST" action="{{ route('admin.change-password.post') }}">
            @csrf

            <div class="field">
                <label for="current_password">Current password</label>
                <div class="field-wrap">
                    <input
                        id="current_password"
                        name="current_password"
                        type="password"
                        placeholder="Enter current password"
                        required
                        autocomplete="current-password"
                    >
                    <button type="button" class="eye-btn" aria-label="Show current password" data-target="current_password">
                        <svg class="eye-icon" xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             aria-hidden="true">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </button>
                </div>
                @error('current_password') <div class="field-error">{{ $message }}</div> @enderror
            </div>

            <div class="field">
                <label for="password">New password</label>
                <div class="field-wrap">
                    <input
                        id="password"
                        name="password"
                        type="password"
                        placeholder="At least 8 characters"
                        required
                        autocomplete="new-password"
                    >
                    <button type="button" class="eye-btn" aria-label="Show new password" data-target="password">
                        <svg class="eye-icon" xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             aria-hidden="true">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </button>
                </div>
                @error('password') <div class="field-error">{{ $message }}</div> @enderror
            </div>

            <div class="field">
                <label for="password_confirmation">Confirm new password</label>
                <div class="field-wrap">
                    <input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        placeholder="Re-enter new password"
                        required
                        autocomplete="new-password"
                    >
                    <button type="button" class="eye-btn" aria-label="Show confirm password" data-target="password_confirmation">
                        <svg class="eye-icon" xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             aria-hidden="true">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </button>
                </div>
                @error('password_confirmation') <div class="field-error">{{ $message }}</div> @enderror
            </div>

            <button class="btn" type="submit">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                     aria-hidden="true">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
                Update password
            </button>
        </form>

    </div>

    </main>
  </div>

    <script src="{{ asset('js/admin/change-password.js') }}"></script>
</body>
</html>
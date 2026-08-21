@extends('admin.layouts.app')

@section('title', 'Aizap Creatives - Change password')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin/change-password.css') }}">
@endsection

@section('content')
    <div class="topbar">
        <div class="topbar-left">
            <button class="menu-toggle" id="menuToggle" aria-label="Open menu" aria-expanded="false">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
            </button>
            <div class="topbar-title">
            </div>
        </div>
    </div>

    <div class="settings-main">
        <div class="card">

        @if (session('status'))
            <div class="settings-alert settings-alert--success" role="status">{{ session('status') }}</div>
        @endif
        @if ($errors->any() && ! $errors->has('current_password') && ! $errors->has('password') && ! $errors->has('password_confirmation') && ! $errors->has('email') && ! $errors->has('email_current_password'))
            <div class="settings-alert settings-alert--error" role="alert">{{ $errors->first() }}</div>
        @endif

        <div class="card-header">
            <div class="icon-ring">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     aria-hidden="true">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
            </div>
            <p class="eyebrow">Account settings</p>
            <h2 class="title">Email &amp; password</h2>
            <p class="desc">Update your admin account email address and password.</p>
        </div>

        <div class="divider"></div>

        <div class="settings-grid">
        <form method="POST" action="{{ route('admin.change-email.post') }}" class="settings-form settings-form--email">
            @csrf

            <div class="field">
                <label for="current_email">Current email</label>
                <input id="current_email" name="current_email" type="email" value="{{ auth()->user()->email }}" readonly autocomplete="email">
                @error('current_email') <div class="field-error">{{ $message }}</div> @enderror
            </div>

            <div class="field">
                <label for="admin_email">New admin email</label>
                <input id="admin_email" name="email" type="email" value="{{ old('email') }}" placeholder="admin@example.com" required autocomplete="email">
                @error('email') <div class="field-error">{{ $message }}</div> @enderror
            </div>

            <div class="field">
                <label for="email_current_password">Current password</label>
                <div class="field-wrap">
                    <input id="email_current_password" name="current_password" type="password" placeholder="Enter current password" required autocomplete="current-password">
                    <button type="button" class="eye-btn" aria-label="Show current password" data-target="email_current_password">
                        <svg class="eye-icon" xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             aria-hidden="true">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </button>
                </div>
                @error('email_current_password') <div class="field-error">{{ $message }}</div> @enderror
            </div>

            <button class="btn" type="submit">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                     aria-hidden="true">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
                Update email
            </button>
        </form>

        <form method="POST" action="{{ route('admin.change-password.post') }}" class="settings-form settings-form--password">
            @csrf

            <div class="field">
                <label for="current_password">Current password</label>
                <div class="field-wrap">
                    <input id="current_password" name="current_password" type="password" placeholder="Enter current password" required autocomplete="current-password">
                    <button type="button" class="eye-btn" aria-label="Show current password" data-target="current_password">
                        <svg class="eye-icon" xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    </button>
                </div>
                @error('current_password') <div class="field-error">{{ $message }}</div> @enderror
            </div>

            <div class="field">
                <label for="password">New password</label>
                <div class="field-wrap">
                    <input id="password" name="password" type="password" placeholder="At least 8 characters" required autocomplete="new-password">
                    <button type="button" class="eye-btn" aria-label="Show new password" data-target="password"><svg class="eye-icon" xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></button>
                </div>
                @error('password') <div class="field-error">{{ $message }}</div> @enderror
            </div>

            <div class="field">
                <label for="password_confirmation">Confirm new password</label>
                <div class="field-wrap"><input id="password_confirmation" name="password_confirmation" type="password" placeholder="Re-enter new password" required autocomplete="new-password"><button type="button" class="eye-btn" aria-label="Show confirm password" data-target="password_confirmation"><svg class="eye-icon" xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></button></div>
                @error('password_confirmation') <div class="field-error">{{ $message }}</div> @enderror
            </div>

            <button class="btn" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"></polyline></svg>Update password</button>
        </form>
        </div>

        </div>
    </div>
@endsection

@section('scripts')
<script src="{{ asset('js/admin/change-password.js') }}"></script>
@endsection
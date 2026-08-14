<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Models\User;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $data['email'])->first();

        if (! $user) {
            return back()->withErrors(['email' => 'Email address not found.'])->withInput();
        }

        if (! Hash::check($data['password'], $user->password)) {
            return back()->withErrors(['password' => 'Invalid password.'])->withInput();
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    public function showChangePassword()
    {
        return view('admin.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = $request->user();
        if (! Hash::check($request->input('current_password'), $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $user->password = Hash::make($request->input('password'));
        $user->setRememberToken(Str::random(60));
        $user->save();

        return back()->with('status', 'Password updated successfully.');
    }

    public function changeEmail(Request $request)
    {
        $data = $request->validate([
            'current_email' => 'required|email',
            'current_password' => 'required|string',
            'email' => 'required|email|unique:users,email,'.$request->user()->id,
        ]);

        $user = $request->user();
        if (strcasecmp($data['current_email'], $user->email) !== 0) {
            return back()->withErrors(['current_email' => 'Current email does not match your admin account.']);
        }

        if (! Hash::check($data['current_password'], $user->password)) {
            return back()->withErrors(['email_current_password' => 'Current password is incorrect.']);
        }

        $user->email = $data['email'];
        $user->email_verified_at = null;
        $user->save();

        return back()->with('status', 'Email updated successfully.');
    }

    // Password reset: show request form
    public function showLinkRequestForm()
    {
        return view('admin.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $email = trim($request->input('email'));
        $user = User::whereRaw('LOWER(email) = ?', [Str::lower($email)])->first();

        if (! $user) {
            return back()->withErrors(['email' => __('We can\'t find a user with that email address.')]);
        }

        try {
            $status = Password::sendResetLink(['email' => $user->email]);
        } catch (\Throwable $e) {
            Log::error('Password reset email transport failed.', [
                'email' => $user->email,
                'exception' => $e->getMessage(),
            ]);

            return back()->withErrors([
                'email' => 'The reset email could not be sent. Please check the Gmail SMTP setup and app password.',
            ]);
        }

        $token = DB::table(config('auth.passwords.users.table', 'password_reset_tokens'))
            ->where('email', $user->email)
            ->value('token');

        if (! $token) {
            $token = hash_hmac('sha256', Str::random(40), config('app.key'));

            DB::table(config('auth.passwords.users.table', 'password_reset_tokens'))
                ->updateOrInsert(
                    ['email' => $user->email],
                    ['token' => $token, 'created_at' => now()],
                );
        }

        $resetLink = route('admin.password.reset', ['token' => $token, 'email' => $user->email]);

        Log::info('Password reset link generated', [
            'email' => $user->email,
            'link' => $resetLink,
        ]);

        $response = $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->with('status', __('Password reset link generated'));

        if (app()->environment(['local', 'testing']) && $resetLink) {
            $response->with('reset_link', $resetLink);
        }

        return $response;
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('admin.passwords.reset')->with([
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($request) {
                $user->password = Hash::make($password);
                $user->setRememberToken(Str::random(60));
                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('admin.login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}

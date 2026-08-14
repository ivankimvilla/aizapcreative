<?php

use App\Models\User;
use App\Notifications\AdminResetPasswordNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

uses(RefreshDatabase::class);

it('stores a password reset token for the supplied email address', function () {
    config(['mail.default' => 'log']);

    $user = User::factory()->create([
        'email' => 'ivanalmadin0@gmail.com',
    ]);

    Notification::fake();

    $response = $this->post('/admin/password/email', [
        'email' => $user->email,
    ]);

    $response->assertSessionHasNoErrors();

    $this->assertDatabaseHas('password_reset_tokens', [
        'email' => $user->email,
    ]);

    $this->assertSame('10', (string) config('auth.passwords.users.expire'));

    $token = DB::table('password_reset_tokens')->where('email', $user->email)->value('token');
    $this->assertNotEmpty($token);

    Notification::assertSentTo(
        $user,
        AdminResetPasswordNotification::class,
        function ($notification) use ($user) {
            $this->assertSame($user->email, $notification->email ?? $user->email);
            $this->assertNotEmpty($notification->token);

            return true;
        }
    );
});

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $email = env('ADMIN_EMAIL', 'admin@example.com');
        $password = env('ADMIN_PASSWORD', 'secret123');

        User::firstOrCreate([
            'email' => $email,
        ], [
            'name' => 'Admin',
            'password' => Hash::make($password),
        ]);
    }
}
